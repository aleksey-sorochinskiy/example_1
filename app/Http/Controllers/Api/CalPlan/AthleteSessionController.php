<?php

namespace App\Http\Controllers\Api\CalPlan;

use App\Athlete;
use App\Http\Requests\Sessions\IndexSession;
use Illuminate\Http\Request;

/**
 * Class AthleteSessionController
 * Controller
 *
 * @package App\Http\Controllers\Api\CalPlan
 */
class AthleteSessionController extends BaseSessionController
{
    /**
     * Display the specified resource.
     *
     * @api
     * @link /api/session/athlete/{athlete} GET
     *
     * @param IndexSession $request
     * @param Athlete $athlete
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show(IndexSession $request, Athlete $athlete)
    {
        return $this->showSessionsOfPerson($request, $athlete);
    }

    /**
     * @param Request $request
     * @param $data
     * @return mixed|void
     */
    protected function saveSession(Request $request, $data){}
}
