<?php

namespace App\Http\Controllers\Api\Athlete;

use App\Athlete;
use App\AthleteHistory;
use App\Biometric;
use App\Http\Requests\Athlete\GetAthleteHistorySignificative;
use App\Http\Requests\Athlete\StoreAthleteHistoryRequest;
use App\Http\Requests\Athlete\UpdateAthleteHistory;
use App\Technical;
use App\Http\Controllers\Controller;

/**
 * Class AthleteHistoryController
 * Controller
 *
 * @package App\Http\Controllers\Api\Athlete
 */
class AthleteHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @api
     * @link /athlete-history GET
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetAthleteHistorySignificative $request)
    {
        $historyChange = Athlete::find($request->get('athlete_id'))->historyChanges()
            ->where('param_name', $request->get('param_name'))->get();
        return response($historyChange);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @api
     * @link /athlete-history POST
     *
     * @param StoreAthleteHistoryRequest $request
     */
    public function store(StoreAthleteHistoryRequest $request)
    {
        Athlete::find($request->get('athlete_id'))->historyChanges()
            ->create($request->only(AthleteHistory::rows()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @api
     * @link /athlete-history/{param} PUT/PATCH
     *
     * @param UpdateAthleteHistory $request
     * @param $param
     */
    public function update(UpdateAthleteHistory $request, $param)
    {
        $rows = $request->get('data');
        $athlete = Athlete::find($request->get('athlete_id'));

        $value = $rows[0][ 'value' ];
        $date = $rows[0][ 'updated_at' ];

        $athlete->historyChanges()->where('param_name', $param)->whereNotIn('id', array_column($rows, 'id'))->delete();

        foreach ($rows as $data) {
            if ( $data[ 'updated_at' ] > $date ) {
                $value = $data[ 'value' ];
            }

            $athlete->historyChanges()->updateOrCreate(['id' => $data['id']], $data);
        }

        $biometric = new Biometric();
        $technical = new Technical();

        if ( in_array($param, $biometric->getFillable()) ) {
            $athlete->biometric()
                ->update([ $param => $value ]);
        } elseif( in_array($param, $technical->getFillable()) ) {
            $athlete->technical()
                ->update([ $param => $value ]);
        }
    }

    /**
     * Remove the specified resource from storage
     *
     * @api
     * @link /athlete-history/{history} DELETE
     *
     * @param \App\AthleteHistory $history
     * @throws \Exception
     */
    public function destroy(AthleteHistory $history)
    {
        $history->delete();
    }
}
