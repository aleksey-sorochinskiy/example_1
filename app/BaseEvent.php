<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseEvent extends Model
{
    /**
     * Alert periods time in minutes
     *
     * @const array
     */
    const ALERT_PERIODS_TIME = [
        0,
        5,
        15,
        30,
        60,
        120,
        1440,
        2880,
        10080,
    ];

    /**
     * Repeat periods time in minutes
     *
     * @const array
     */
    const REPEAT_PERIODS_TIME = [
        0,
        1,
        7,
        14,
        30,
        365,
    ];

    /**
     * Relation with athletes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function athlete()
    {
        return $this->belongsToMany('App\Athlete');
    }

    /**
     * Relation with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Increment date
     *
     * @param Carbon $time
     * @param $period
     * @return Carbon
     */
    public static function incrementDate(Carbon $time, $period)
    {
        switch ($period){
            case 30:
                return $time->addMonth();
                break;
            case 365:
                return $time->addYear();
                break;
            default:
                return $time->addDays($period);
        }
    }

    /**
     * Format Carbon object of time to string with time
     *
     * @param Carbon $time
     * @return string
     */
    public static function formatTime(Carbon $time)
    {
        return $time->format('Y-m-d H:i:s');
    }
}
