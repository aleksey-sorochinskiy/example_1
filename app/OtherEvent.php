<?php

namespace App;
/**
 * Class OtherEvent
 * Model
 *
 * @property integer    $id
 * @property string     $summary
 * @property string     $location
 * @property string     $note
 * @property integer    $user_id
 * @property integer    $alert_period
 * @property integer    $repeat_period
 * @property dateTime   $time_start
 * @property dateTime   $time_end
 * @property string     $repeat_identification
 * @property timestamp  $created_at
 * @property timestamp  $updated_at
 *
 * @package App
 */
class OtherEvent extends BaseEvent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'time_start',
        'location',
        'alert_period',
        'repeat_period',
        'note',
        'summary',
        'report',
        'repeat_identification',
        'assessment',
        'time_end',
        'completed'
    ];
}
