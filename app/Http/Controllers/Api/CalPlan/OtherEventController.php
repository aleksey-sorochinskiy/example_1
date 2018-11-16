<?php

namespace App\Http\Controllers\Api\CalPlan;

use App\Http\Requests\Sessions\CompletedSessions;
use App\Http\Requests\Sessions\IndexSession;
use App\OtherEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class OtherEventController
 * Controller
 *
 * @package App\Http\Controllers\Api\CalPlan
 */
class OtherEventController extends BaseSessionController
{
    /**
     * Display a listing of the resource.
     *
     * @api
     * @link /api/session/other-event GET
     *
     * @param IndexSession $request
     * @return mixed
     */
    public function index(IndexSession $request)
    {
        return $this->indexSession($request, 'otherEvents');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @api
     * @link /api/session/other-event POST
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->storeSession($request);
    }

    /**
     * Display the specified resource.
     *
     * @api
     * @link /api/session/other-event/{other-event} GET
     *
     * @param  \App\OtherEvent  $otherEvent
     * @return \Illuminate\Http\Response
     */
    public function show(OtherEvent $otherEvent)
    {
        return response($this->showSession($otherEvent));
    }

    /**
     * Update the specified resource in storage.
     *
     * @api
     * @link /api/session/other-event/{other-event} PUT/PATCH
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OtherEvent  $otherEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OtherEvent $otherEvent)
    {
        return $this->updateSessionData($request, $otherEvent);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @api
     * @link /api/session/other-event/{other-event} DELETE
     *
     * @param OtherEvent $otherEvent
     * @throws \Exception
     */
    public function destroy(OtherEvent $otherEvent)
    {
        $otherEvent->delete();
    }

    /**
     * Completed Training Session
     *
     * @api
     * @link /api/session/other-event/{session}/completed POST
     *
     * @param CompletedSessions $request
     * @param OtherEvent $event
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function completed(CompletedSessions $request, OtherEvent $event)
    {
        return $this->completedSession($request, $event);
    }

    /**
     * Save Other Event
     *
     * @param Request $request
     * @param $data
     * @return mixed
     */
    protected function saveSession(Request $request, $data)
    {
        $session = Auth::user()->otherEvents()->create($data);
        $session->athlete()->attach($request->get('assign'));

        return $session;
    }
}
