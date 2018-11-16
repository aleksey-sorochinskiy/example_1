<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ActivityLog
 *
 * Model
 *
 * @uses table "activity_logs   "
 *
 * @property integer $id
 * @property string $action
 * @property integer $user_id
 * @property integer $checked
 * @property timestamp $created_at
 * @property timestamp $updated_at
 *
 * @package App
 *
 * @SWG\Definition(
 *     @SWG\Property(
 *         property="id",
 *         type="integer",
 *         description="Activity ID"
 *     ),
 *     @SWG\Property(
 *         property="user_id",
 *         type="integer",
 *         description="User ID"
 *     ),
 *     @SWG\Property(
 *         property="action",
 *         type="string",
 *         description="Action"
 *     ),
 *     @SWG\Property(
 *         property="checked",
 *         type="boolean",
 *         description="Indicator"
 *     ),
 *     @SWG\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation date"
 *     ),
 *     @SWG\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update date"
 *     )
 * )
 */
class ActivityLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action'
    ];

    /**
     * Activity value for updated
     *
     * @var string
     */
    const UPDATED_ACTIVITY = 'updated';

    /**
     * Activity value for added
     *
     * @var string
     */
    const ADDED_ACTIVITY = 'added';

    /**
     * Activity value for removed
     *
     * @var string
     */
    const REMOVED_ACTIVITY = 'removed';

    /**
     * List of activity
     *
     * @var array
     */
    const ACTIVITY = [
        self::UPDATED_ACTIVITY,
        self::ADDED_ACTIVITY,
        self::REMOVED_ACTIVITY
    ];

    /**
     * Entity title for Type of Training
     *
     * @var string
     */
    const TYPE_OF_TRAINING_ENTITY = 'Type of Training';

    /**
     * Entity title for Specific Activity
     *
     * @var string
     */
    const SPECIFIC_ACTIVITY_ENTITY = 'Specific Activity';

    /**
     * Entity title for Activities Group
     *
     * @var string
     */
    const ACTIVITIES_GROUP_ENTITY = 'Activities Group';

    /**
     * Entity title for Set of Exercises
     *
     * @var string
     */
    const SET_OF_EXERCISES_ENTITY = 'Set of Exercises';

    /**
     * Entity title for Drill
     *
     * @var string
     */
    const DRILL_ENTITY = 'Drill';

    /**
     * List of entity
     *
     * @var array
     */
    const ENTITY = [
        self::TYPE_OF_TRAINING_ENTITY,
        self::SPECIFIC_ACTIVITY_ENTITY,
        self::ACTIVITIES_GROUP_ENTITY,
        self::SET_OF_EXERCISES_ENTITY,
        self::DRILL_ENTITY
    ];

    /**
     * Event title for Training Sessions
     *
     * @var string
     */
    const TS_EVENT = 'TS';

    /**
     * Event title for Test Sessions
     *
     * @var string
     */
    const TSTS_EVENT = 'TSTS';

    /**
     * Event title for Other Events
     *
     * @var string
     */
    const OE_EVENT = 'OE';

    /**
     * List of events
     *
     * @var array
     */
    const EVENTS = [
      self::TS_EVENT,
      self::TSTS_EVENT,
      self::OE_EVENT
    ];

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
     * Logging User Log In
     *
     * @param User $user
     */
    public static function userLogIn(User $user)
    {
        self::saveLog($user, "User $user->username logged in");
    }

    /**
     * Logging User Log Out
     *
     * @param User $user
     */
    public static function userLogOut(User $user)
    {
        self::saveLog($user, "User $user->username logged out");
    }

    /**
     * Logging User updated own profile
     *
     * @param User $user
     */
    public static function userUpdatedProfile(User $user)
    {
        self::saveLog($user, "User $user->username updated own profile");
    }

    /**
     * Logging User changed account password
     *
     * @param User $user
     */
    public static function userChangedPassword(User $user)
    {
        self::saveLog($user, "User $user->username changed account password");
    }

    /**
     * Logging Create new athlete
     *
     * @param User $user
     */
    public static function createAthlete(User $user, Athlete $athlete)
    {
        self::wasCreated($user, 'athlete', "$athlete->first_name $athlete->last_name");
    }

    /**
     * Logging removed athlete
     *
     * @param User $user
     */
    public static function removedAthlete(User $user, Athlete $athlete)
    {
        self::wasRemoved($user, "Athlete", "$athlete->first_name $athlete->last_name");
    }

    /**
     * Logging athlete changes
     *
     * @param User $user
     * @param Athlete $oldAthlete
     * @param Athlete $newAthlete
     */
    public static function modifiedAthlete(User $user, Athlete $oldAthlete, Athlete $newAthlete)
    {
        self::wasModified($user, $oldAthlete, $newAthlete, "Athlete");
    }

    /**
     * Logging change Athlete Profile Picture
     *
     * @param User $user
     * @param Athlete $athlete
     * @param $activity
     */
    public static function changeAthletePicture(User $user, Athlete $athlete, $activity)
    {
        self::saveLog($user, "Profile picture of $athlete->first_name $athlete->last_name was $activity");
    }

    /**
     * Logging started training sessions
     *
     * @param User $user
     * @param $trainingSessions
     */
    public static function TSStarted(User $user, $trainingSessions)
    {
        self::saveLog($user, "TS $trainingSessions->name was started");
    }

    /**
     * Logging drills created
     *
     * @param User $user
     * @param Model $drillObject Object of drills(TypeOfTraining/SpecificActivity/ActivityGroup/SetOfExercise/Drill)
     */
    public static function createdDrills(User $user, Model $drillObject)
    {
        $entityType = self::getEntityType($drillObject);
        self::wasCreated($user, $entityType, $drillObject->name);
    }

    /**
     * Logging drills removed
     *
     * @param User $user
     * @param Model $drillObject Object of drills(TypeOfTraining/SpecificActivity/ActivityGroup/SetOfExercise/Drill)
     */
    public static function removedDrills(User $user, Model $drillObject)
    {
        self::wasRemoved($user, self::getEntityType($drillObject), $drillObject->name);
    }

    /**
     * Logging drills modified
     *
     * @param User $user
     * @param Model $oldDrillObject
     * @param Model $newDrillObject
     */
    public static function modifiedDrills(User $user, Model $oldDrillObject, Model $newDrillObject)
    {
        $entityType = self::getEntityType($oldDrillObject);
        self::wasModified($user, $oldDrillObject, $newDrillObject, $entityType);
    }

    /**
     * Logging events created
     *
     * @param User $user
     * @param Model $event
     */
    public static function createdEvent(User $user, Model $event)
    {
        $eventType = self::getEventType($event);
        //TODO: save created
    }

    /**
     * Logging completed Event
     *
     * @param User $user
     * @param Model $event
     */
    public static function completedEvent(User $user, Model $event)
    {
        $eventType = self::getEventType($event);
        self::saveLog($user, "$eventType $event->name was completed");
    }

    /**
     * Logging removed event
     *
     * @param User $user
     * @param Model $event
     */
    public static function removedEvent(User $user, Model $event)
    {
        self::wasRemoved($user, self::getEventType($event), $event->name);
    }

    /**
     * Logging Events modified(TS, TSTS, OE)
     *
     * @param User $user
     * @param Model $oldEventObject
     * @param Model $newEventObject
     */
    public static function modifiedEvent(User $user, Model $oldEventObject, Model $newEventObject)
    {
        $eventType = self::getEventType($oldEventObject);
        self::wasModified($user, $oldEventObject, $newEventObject, $eventType);
    }

    /**
     * Logging Create new Training Session Card
     *
     * @param User $user
     * @param $trainingSessionCard
     */
    public static function createdTSC(User $user, $trainingSessionCard)//TODO: Update to real TSC
    {
        self::wasCreated($user, 'TSC', $trainingSessionCard->name);
    }

    /**
     * Logging removed Training Session Card
     *
     * @param User $user
     * @param $trainingSessionCard
     */
    public static function removedTSC(User $user, $trainingSessionCard)//TODO: Update to real TSC
    {
        self::wasRemoved($user, "TSC", $trainingSessionCard->name);
    }

    /**
     * Logging athlete Training Session Card
     *
     * @param User $user
     * @param $oldTsc
     * @param Athlete $newTsc
     */
    public static function modifiedTSC(User $user, $oldTsc, Athlete $newTsc)//TODO: Update to real TSC
    {
        self::wasModified($user, $oldTsc, $newTsc, "TSC");
    }

    /**
     * Logging Events Report modified(TS, TSTS, OE)
     *
     * @param User $user
     * @param Model $oldEventReportObject
     * @param Model $newEventReportObject
     */
    public static function modifiedEventReport(User $user, Model $oldEventReportObject, Model $newEventReportObject)
    {
        $eventType = self::getEventReportType($oldEventReportObject);
        self::wasModified($user, $oldEventReportObject, $newEventReportObject, $eventType, 'Report');
    }

    /**
     * Logging created actions
     *
     * @param User $user
     * @param string $entityTitle
     * @param string $entityName
     */
    protected static function wasCreated(User $user, $entityTitle = '', $entityName = '')
    {
        self::saveLog($user, "New $entityTitle $entityName was created");
    }

    /**
     * Logging removed actions
     *
     * @param User $user
     * @param string $entityTitle
     * @param string $entityName
     */
    protected static function wasRemoved(User $user, $entityTitle = '', $entityName = '')
    {
        self::saveLog($user, "$entityTitle $entityName was removed");
    }

    /**
     * Logging modified actions
     *
     * @param User $user
     * @param $old
     * @param $new
     * @param string $title
     * @param string $name
     */
    protected static function wasModified(User $user, $old, $new, $title = '', string  $name = null)
    {
         $changeList = self::formationChangedData($old->toArray(), $new->toArray());
        $action = "$title ".($name??$old->name)." was modified:\n".$changeList;

        self::saveLog($user, $action);
    }

    /**
     * Save activity log
     *
     * @param $user
     * @param string $action
     */
    protected static function saveLog(User $user, string $action)
    {
        self::create([
            'user_id' => $user->id,
            'action'  => $action
        ]);
    }

    /**
     * Formation Changed Data fore saving
     * @param array $old
     * @param array $new
     * @return string
     */
    protected static function formationChangedData($old, $new)
    {
        $output = '';

        foreach ($old as $key=>$item) {
            if ($old[$key] != $new[$key] && $key != 'updated_at' && $key != 'img'){
                $output .= "$key updated from ".($old[$key]??'NONE')." to ".($new[$key]??'NONE')."\n";
            }
        }

        return $output;
    }

    /**
     * Get the type for the entity by object
     *
     * @param Model $entity Entity
     * @return string ENTITY Name for Entity
     */
    protected static function getEntityType(Model $entity)
    {
        switch(get_class($entity)) {
            case TypeOfTraining::class:
                return self::TYPE_OF_TRAINING_ENTITY;
                break;
            case SpecificActivity::class:
                return self::SPECIFIC_ACTIVITY_ENTITY;
                break;
            case ActivityGroup::class:
                return self::ACTIVITIES_GROUP_ENTITY;
                break;
            case SetOfExercise::class:
                return self::SET_OF_EXERCISES_ENTITY;
                break;
            case Drill::class:
                return self::DRILL_ENTITY;
                break;
            default:
                return "Entity is not defined";
                break;
        }
    }

    /**
     * Get the type for the event by object
     *
     * @param Model $event
     * @return string
     */
    protected static function getEventType(Model $event) //TODO: Change to real class name
    {
        switch(get_class($event)) {
            case TypeOfTraining::class:
                return self::TS_EVENT;
                break;
            case SpecificActivity::class:
                return self::TSTS_EVENT;
                break;
            case ActivityGroup::class:
                return self::OE_EVENT;
                break;
            default:
                return "Event is not defined";
                break;
        }
    }

    /**
     * Get the type for the event report by object
     *
     * @param Model $event
     * @return string
     */
    protected static function getEventReportType(Model $event) //TODO: Change to real class name
    {
        switch(get_class($event)) {
            case TypeOfTraining::class:
                return self::TS_EVENT;
                break;
            case SpecificActivity::class:
                return self::TSTS_EVENT;
                break;
            default:
                return "Event is not defined";
                break;
        }
    }
}