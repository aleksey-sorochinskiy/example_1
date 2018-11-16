<?php

namespace App\Http\Controllers\Api\CalPlan;

use App\Http\Requests\Sessions\CompletedTestSession;
use App\Http\Requests\Sessions\IndexSession;
use App\Http\Requests\Sessions\StoreTestSession;
use App\Http\Requests\Sessions\UpdateTestSession;
use App\TestSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class TestSessionController
 * Controller
 *
 * @package App\Http\Controllers\Api\CalPlan
 */
class TestSessionController extends BaseSessionController
{
    /**
     * Display a listing of the resource.
     *
     * @api
     * @link /api/session/test-session GET
     *
     * @param IndexSession $request
     * @return mixed
     */
    public function index(IndexSession $request)
    {
        return $this->indexSession($request, 'testSessions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @api
     * @link /api/session/test-session POST
     *
     * @param StoreTestSession $request
     * @return mixed
     */
    public function store(StoreTestSession $request)
    {
        return $this->storeSession($request);
    }

    /**
     * Display the specified resource.
     *
     * @api
     * @link /api/session/test-session/{test-session} GET
     *
     * @param  \App\TestSession  $testSession
     * @return \Illuminate\Http\Response
     */
    public function show(TestSession $testSession)
    {
        return response($this->showSession($testSession));
    }

    /**
     * Update the specified resource in storage.
     *
     * @api
     * @link /api/session/test-session/{test-session} PUT/PATCH
     *
     * @param UpdateTestSession $request
     * @param TestSession $testSession
     * @return mixed
     */
    public function update(UpdateTestSession $request, TestSession $testSession)
    {
        return $this->updateSessionData($request, $testSession);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @api
     * @link /api/session/test-session/{test-session} DELETE
     *
     * @param TestSession $testSession
     * @throws \Exception
     */
    public function destroy(TestSession $testSession)
    {
        $testSession->delete();
    }

    /**
     * Completed Test Session
     *
     * @api
     * @link /api/session/test-session/{session}/completed POST
     *
     * @param CompletedTestSession $request
     * @param TestSession $session
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function completed(CompletedTestSession $request, TestSession $session)
    {
        return $this->completedSession($request, $session);
    }

    /**
     * Save Test Session
     *
     * @param Request $request
     * @param $data
     * @return mixed
     */
    protected function saveSession(Request $request, $data)
    {
        $session = Auth::user()->testSessions()->create($data);

        return $session;
    }

    /**
     * Update Test Session
     *
     * @param Request $request
     * @param $session
     * @param $data
     * @return mixed
     */
    protected function updateSession(Request $request, $session, $data)
    {
        $session->update($data);

        return $session;
    }
}
