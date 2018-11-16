<?php

namespace App;

/**
 * Class TrainingSession
 * Model
 *
 * @property integer    $id
 * @property string     $location
 * @property string     $note
 * @property integer    $user_id
 * @property integer    $alert_period
 * @property integer    $repeat_period
 * @property integer    $training_session_card_id
 * @property dateTime   $time_start
 * @property dateTime   $time_end
 * @property string     $repeat_identification
 * @property timestamp  $created_at
 * @property timestamp  $updated_at
 *
 * @package App
 */
class TrainingSession extends BaseEvent
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
        'training_session_card_id',
        'note',
        'report',
        'repeat_identification',
        'assessment',
        'time_end',
        'completed'
    ];


}
