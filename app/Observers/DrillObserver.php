<?php
/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 26.06.18
 * Time: 13:19
 */

namespace App\Observers;


use App\ActivityLog;
use App\Drill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DrillObserver extends ActivityLogHook
{
    /**
     * Logging create drill
     *
     * @param Model|null $drill
     */
    public function created(Model $drill = null)
    {
        if ($drill){
            ActivityLog::createdDrills(Auth::user(), $drill);
        }
    }

    /**
     * Logging update drill
     *
     * @param Model|null $drill
     */
    public function updating(Model $drill = null)
    {
        if ($drill){
            $model = get_class($drill);
            $oldDrill = $model::find($drill->id);
            ActivityLog::modifiedDrills(Auth::user(), $oldDrill, $drill);
        }
    }

    /**
     * Logging delete drill
     *
     * @param Model|null $drill
     */
    public function deleted(Model $drill = null)
    {
        if ($drill){
            ActivityLog::removedDrills(Auth::user(), $drill);
        }
    }
}