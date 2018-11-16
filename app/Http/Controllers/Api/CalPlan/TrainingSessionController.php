<?php

namespace App\Http\Controllers\Api\CalPlan;

use App\Http\Requests\Sessions\CompletedSessions;
use App\Http\Requests\Sessions\IndexSession;
use App\Http\Requests\Sessions\StoreTrainingSession;
use App\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TrainingSessionController
 * Controller
 *
 * @package App\Http\Controllers\Api\CalPlan
 */
class TrainingSessionController extends BaseSessionController
{
    /**
     * Display a listing of the resource.
     *
     * @api
     * @link /api/session/training-session GET
     *
     * @param IndexSession $request
     * @return mixed
     */
    public function index(IndexSession $request)
    {
        return $this->indexSession($request, 'trainingSessions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @api
     * @link /api/session/training-session POST
     *
     * @param StoreTrainingSession $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreTrainingSession $request)
    {
        return $this->storeSession($request);
    }
    /**
     * Display the specified resource.
     *
     * @api
     * @link /api/session/training-session/{training-session} GET
     *
     * @param  \App\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSession $trainingSession)
    {
        return response($this->showSession($trainingSession));
    }

    /**
     * Update the specified resource in storage.
     *
     * @api
     * @link /api/session/training-session/{training-session} PUT/PATCH
     *
     * @param Request $request
     * @param TrainingSession $trainingSession
     * @return TrainingSession
     */
    public function update(Request $request, TrainingSession $trainingSession)
    {
        return $this->updateSessionData($request, $trainingSession);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @api
     * @link /api/session/training-session/{training-session} DELETE
     *
     * @param TrainingSession $trainingSession
     * @throws \Exception
     */
    public function destroy(TrainingSession $trainingSession)
    {
        $trainingSession->delete();
    }

    /**
     * Completed Training Session
     *
     * @api
     * @link /api/session/training-session/{session}/completed POST
     *
     * @param CompletedSessions $request
     * @param TrainingSession $session
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function completed(CompletedSessions $request, TrainingSession $session)
    {
        return $this->completedSession($request, $session);
    }

    /**
     * Save Training Session
     *
     * @param Request $request
     * @param $data
     * @return mixed
     */
    protected function saveSession(Request $request, $data)
    {
        $session = Auth::user()->trainingSessions()->create($data);
        $session->athlete()->attach($request->get('assign'));

        return $session;
    }

}
