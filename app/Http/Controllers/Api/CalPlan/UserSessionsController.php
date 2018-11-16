<?php

namespace App\Http\Controllers\Api\CalPlan;

use App\Http\Requests\Sessions\IndexSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSessionsController extends BaseSessionController
{
    /**
     * Display a listing of the resource.
     *
     * @api
     * @link /api/session/user GET
     *
     * @param IndexSession $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index(IndexSession $request)
    {
        return $this->showSessionsOfPerson($request, Auth::user());
    }

    /**
     * @param Request $request
     * @param $data
     * @return mixed|void
     */
    protected function saveSession(Request $request, $data){}
}
