<?php
/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 26.06.18
 * Time: 11:59
 */

namespace App\Observers;


use App\ActivityLog;
use App\Athlete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class AthleteObserver Athlete model hooks
 * @package App\Observers
 */
class AthleteObserver extends ActivityLogHook
{
    /**
     * Logging create athlete
     *
     * @param Athlete $athlete
     */
    public function created(Athlete $athlete = null)
    {
        if ($athlete){
            ActivityLog::createAthlete(Auth::user(), $athlete);
        }
    }

    /**
     * Logging update athlete
     *
     * @param Athlete $athlete
     */
    public function updating(Athlete $athlete = null)
    {
        if ($athlete){
            $oldAthlete = Athlete::find($athlete->id);
            $res = false;

            foreach ($athlete->toArray() as $key=>$item) {
                if ($athlete->$key != $oldAthlete->$key && $key != 'img'){
                    $res = true;
                }
            }

            if ($res){
                ActivityLog::modifiedAthlete(Auth::user(), $oldAthlete, $athlete);
            }

            if ($athlete->img != $oldAthlete->img){
                if ($athlete->img == null){
                    $activity = ActivityLog::REMOVED_ACTIVITY;
                } elseif ($oldAthlete->img == null){
                    $activity = ActivityLog::ADDED_ACTIVITY;
                }else{
                    $activity = ActivityLog::UPDATED_ACTIVITY;
                }

                ActivityLog::changeAthletePicture(Auth::user(), $athlete, $activity);
            }
        }
    }

    /**
     * Logging delete athlete
     *
     * @param Athlete $athlete
     */
    public function deleted(Athlete $athlete = null)
    {
        if ($athlete){
            ActivityLog::removedAthlete(Auth::user(), $athlete);
        }
    }
}