<?php

namespace App\Http\Controllers\Api\Athlete;

use App\Athlete;
use App\Http\Requests\Athlete\StoreAthlete;
use App\Http\Requests\Athlete\UpdateAthlete;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * Class AthleteController
 * Controller
 *
 * @package App\Http\Controllers\Api\Athlete
 */
class AthleteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @api
     * @link /athlete GET
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $athletes = Auth::user()
                        ->athletes()
                        ->get()
                        ->load('biometric', 'contact', 'medical', 'technical', 'coach');

        return response($athletes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @api
     * @link /athlete POST
     *
     * @param StoreAthlete $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(StoreAthlete $request)
    {
        $athlete = Auth::user()->athletes()->create($request->only(Athlete::rows()));
        $athlete->save();

        $athlete->contact()->create($request->get('contact'));
        $athlete->biometric()->create($request->get('biometric'));
        $athlete->technical()->create($request->get('technical'));
        $athlete->medical()->create($request->get('medical'));

        $historyParams = Athlete::historyParams();

        foreach ($request->get('biometric') as $key => $value) {
            if (in_array($key, $historyParams)) {
                $athlete->historyChanges()->create([
                    'param_name' => $key,
                    'value' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        foreach ($request->get('technical') as $key => $value) {
            if (in_array($key, $historyParams)) {
                $athlete->historyChanges()->create([
                    'param_name' => $key,
                    'value' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        return response($athlete->load('biometric', 'contact', 'medical', 'technical', 'coach'));
    }

    /**
     * Display the specified resource.
     *
     * @api
     * @link /athlete/{athlete} GET
     *
     * @param \App\Athlete $athlete
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function show(Athlete $athlete)
    {
        return response($athlete->load([
            'historyChanges' => function ($query) {
                $query->orderBy('updated_at', 'asc');
            },
            'biometric',
            'contact',
            'medical',
            'technical',
            'coach',
        ]));
    }

    /**
     * Update resource
     *
     * @api
     * @link /athlete/{athlete} PUT/PATCH
     *
     * @param UpdateAthlete $request
     * @param Athlete $athlete
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateAthlete $request, Athlete $athlete)
    {
        $historyParams = Athlete::historyParams();

        foreach ($request->get('biometric') as $key => $value) {
            if ($value !== null && $value !== '') {
                if (in_array($key, $historyParams) && $athlete['biometric'][$key] != $value) {
                    $athlete->historyChanges()->create([
                        'param_name' => $key,
                        'value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        foreach ($request->get('technical') as $key => $value) {
            if ($value !== null && $value !== '') {
                if (in_array($key, $historyParams) && $athlete['technical'][$key] != $value) {
                    $athlete->historyChanges()->create([
                        'param_name' => $key,
                        'value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        $athlete->update($request->only(Athlete::rows()));
        $athlete->contact()->update($request->get('contact'));
        $athlete->biometric()->update($request->get('biometric'));
        $athlete->technical()->update($request->get('technical'));
        $athlete->medical()->update($request->get('medical'));

        return response($athlete->load('biometric', 'contact', 'medical', 'technical', 'coach'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @api
     * @link /athlete/{athlete} DELETE
     *
     * @param \App\Athlete $athlete
     * @throws \Exception
     */
    public function destroy(Athlete $athlete)
    {
        $athlete->delete();
    }
}
