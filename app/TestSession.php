<?php

namespace App;
/**
 * Class TestSession
 * Model
 *
 * @property integer    $id
 * @property string     $location
 * @property string     $note
 * @property string     $name
 * @property integer    $user_id
 * @property integer    $alert_period
 * @property integer    $repeat_period
 * @property integer    $athlete_id
 * @property dateTime   $time_start
 * @property dateTime   $time_end
 * @property string     $repeat_identification
 * @property timestamp  $created_at
 * @property timestamp  $updated_at
 *
 * @package App
 *
 */
class TestSession extends BaseEvent
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
        'name',
        'athlete_id',
        'report',
        'repeat_identification',
        'assessment',
        'time_end',
        'completed'
    ];

    /**
     * Relation with athletes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function athlete()
    {
        return $this->belongsTo('App\Athlete');
    }
}