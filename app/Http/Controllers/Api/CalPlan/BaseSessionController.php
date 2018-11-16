<?php

namespace App\Http\Controllers\Api\CalPlan;

use App\BaseEvent;
use App\Http\Requests\Sessions\IndexSession;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Abstract Class BaseSessionController
 * @package App\Http\Controllers\Api\CalPlan
 */
abstract class BaseSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexSession $request
     * @param $sessionName
     * @return mixed
     */
    protected function indexSession(IndexSession $request, $sessionName)
    {
        $queryParameters = $this->getQueryParameters($request);

        return $this->querySession(Auth::user(), $sessionName, $queryParameters);
    }

    /**
     * Get session query parameters
     *
     * @param Request $request
     * @return array
     */
    protected function getQueryParameters(Request $request)
    {
        $start = 'startOfYear';
        $end = 'endOfYear';
        $dateTime = Carbon::now();

        if ($request->has('period')){
            switch ($request->get('period')){
                case 'month':
                    $start = 'startOfMonth';
                    $end = 'endOfMonth';

                    if ($request->has('date')){
                        $dateTime = Carbon::createFromFormat('Y-m', $request->get('date'));
                    }
                    break;
                case 'week':
                    $start = 'startOfWeek';
                    $end = 'endOfWeek';

                    if ($request->has('date')){
                        $dateTime = Carbon::createFromFormat('Y-m-d', $request->get('date'));
                    }
                    break;
                default:
                    $start = 'startOfYear';
                    $end = 'endOfYear';

                    if ($request->has('date')){
                        $dateTime = Carbon::createFromFormat('Y', $request->get('date'));
                    }
            }
        }

        return [
            'end' => $end,
            'start' => $start,
            'date_time' => $dateTime
        ];
    }

    /**
     * Query Session
     *
     * @param $object
     * @param $sessionName
     * @param $queryParameters
     * @return mixed
     */
    protected function querySession($object ,$sessionName, $queryParameters)
    {
        $start = $queryParameters['start'];
        $end = $queryParameters['end'];
        $dateTime = $queryParameters['date_time'];

        return $object->$sessionName()
            ->with('athlete')
            ->whereBetween('time_start', [
                BaseEvent::formatTime($dateTime->$start()),
                BaseEvent::formatTime($dateTime->$end())
            ])
            ->orderBy('time_start')->get();
    }

    /**
     * Display the specified resource.
     *
     * @param Model $session
     * @return Model
     */
    protected function showSession(Model $session)
    {
        return $session->load('athlete');
    }

    /**
     * Store session
     *
     * @param Request $request
     * @return mixed
     */
    protected function storeSession(Request $request)
    {
        $data = $request->all();
        unset($data['assign']);

        $session = $this->saveSession($request, $data);

        if ($request->has('repeat_period') && $request->get('repeat_period') > 0) {
            $session->update(['repeat_identification'=>'r_'.$session->id]);
            $data['repeat_identification'] = 'r_'.$session->id;

            $this->repeatSession($request, $data);
        }

        return $session->load('athlete');
    }

    /**
     * Save Repeat trainings
     *
     * @param Request $request
     * @param array $data
     */
    protected function repeatSession(Request $request, array $data)
    {
        $timeStart = Carbon::createFromFormat('Y-m-d H:i:s', $data['time_start']);
        $timeEnd = Carbon::createFromFormat('Y-m-d H:i:s', $data['time_end']);
        $period = $request->get('repeat_period');

        do {
            $timeStart = BaseEvent::incrementDate($timeStart, $period);
            $timeEnd   = BaseEvent::incrementDate($timeEnd, $period);

            $data['time_start'] = BaseEvent::formatTime($timeStart);
            $data['time_end'] =  BaseEvent::formatTime($timeEnd);

            $this->saveSession($request, $data);

        } while ($timeStart < Carbon::now()->endOfMonth());
    }

    /**
     * Update session data
     *
     * @param Request $request
     * @param $session
     * @return mixed
     */
    protected function updateSessionData(Request $request, $session)
    {
        $data = $request->all();
        unset($data['assign']);

        if ($request->has('repeat_period')
            && $request->get('repeat_period') > 0
            && $request->get('repeat_period') != $session->repeat_period){

            $session->update(['repeat_identification'=>'r_'.$session->id]);
            $data['repeat_identification'] = 'r_'.$session->id;

            $this->repeatSession($request, $data);
        }

        $session = $this->updateSession($request, $session, $data);

        return $session->load('athlete');
    }

    /**
     * Save session data
     *
     * @param Request $request
     * @param $data
     * @return mixed
     */
    abstract protected function saveSession(Request $request, $data);

    /**
     * Save updating of session data
     *
     * @param Request $request
     * @param $session
     * @param $data
     * @return mixed
     */
     protected function updateSession(Request $request, $session, $data)
     {
         $session->update($data);
         $session->athlete()->sync($request->get('assign'));

         return $session;
     }

    /**
     * Completed session and create report
     *
     * @param Request $request
     * @param Model $session
     * @return Model
     */
     protected function completedSession(Request $request, Model $session)
     {
         $data = $request->all();
         $data['completed'] = 1;

         $session->update($data);

         return $session;
     }

    /**
     * @param Request $request
     * @param $person
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
     protected function showSessionsOfPerson(Request $request, $person)
     {
         $queryParameters = $this->getQueryParameters($request);

         return response([
             'training_session'  => $this->querySession($person,'trainingSessions', $queryParameters),
             'test_session'      => $this->querySession($person,'testSessions', $queryParameters),
             'other_event'       => $this->querySession($person,'otherEvents', $queryParameters),
         ]);
     }

}
