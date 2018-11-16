<?php

namespace App\Jobs;

use App\BaseEvent;
use App\OtherEvent;
use App\TestSession;
use App\TrainingSession;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class RepeatSessions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $trainingSessions = $this->getSessions(TrainingSession::class);
        $this->seedSessions($trainingSessions, TrainingSession::class);

        $testSessions = $this->getSessions(TestSession::class);
        $this->seedSessions($testSessions, TestSession::class);

        $otherEvent = $this->getSessions(OtherEvent::class);
        $this->seedSessions($otherEvent, OtherEvent::class);
    }

    /**
     * Get session data collection
     *
     * @param $class
     * @return mixed
     */
    protected function getSessions($class)
    {
        return $class::where('time_start', '>=',Carbon::now()->addMonth(-1))
            ->where('repeat_period','>',0)
            ->with('athlete')
            ->orderBy('time_start', 'desc')
            ->get()
            ->groupBy('repeat_identification');
    }

    /**
     * Generate seeds of session for next period
     *
     * @param $sessions
     * @param $saveFunction
     */
    protected function seedSessions($sessions, $class)
    {
        foreach ($sessions as $session) {
            $sessionMax = $session->where('time_start',$session->max('time_start'))->first();

            if ($sessionMax->time_start < Carbon::now()->endOfMonth()) {
                $timeStart = $this->getCarbonTime($sessionMax->time_start);
                $timeEnd = $this->getCarbonTime($sessionMax->time_end);

                $athleteIds = $sessionMax->athlete->pluck('id')->toArray();

                do {
                    $timeStart = BaseEvent::incrementDate($timeStart, $sessionMax->repeat_period);
                    $timeEnd  = BaseEvent::incrementDate($timeEnd, $sessionMax->repeat_period);

                    $sessionMax->time_start = BaseEvent::formatTime($timeStart);
                    $sessionMax->time_end   = BaseEvent::formatTime($timeEnd);

                    $this->save($sessionMax, $class, $athleteIds);
                } while ($timeStart < Carbon::now()->endOfMonth());
            }
        }
    }

    /**
     * Save Session
     *
     * @param $sessionData
     * @param $class
     * @param int $athleteIds
     */
    protected function save($sessionData, $class, $athleteIds = 0)
    {
        $data = $this->cleadData($sessionData->toArray());

        $session = new $class($data);
        $session->save();

        if($class == TrainingSession::class || $class == OtherEvent::class ){
            $session->athlete()->attach($athleteIds);
        }
    }

    /**
     * Form Session object for saving
     * @param Model $session
     * @param $sessionData
     * @return Model
     */
    protected function formSessionObject(Model $session, $sessionData)
    {
        $session->location = $sessionData->location;
        $session->note = $sessionData->note;
        $session->user_id = $sessionData->user_id;
        $session->alert_period = $sessionData->alert_period;
        $session->repeat_period = $sessionData->repeat_period;
        $session->time_start = $sessionData->time_start;
        $session->time_end = $sessionData->time_end;
        $session->repeat_identification = $sessionData->repeat_identification;

        return $session;
    }

    /**
     * Format string with time to Carbon object of time
     *
     * @param $time
     * @return Carbon
     */
    protected function getCarbonTime($time)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $time);
    }

    /**
     * Delete 'assessment', 'report', 'completed' from data array
     * @param $data
     * @return mixed
     */
    protected function cleadData($data)
    {
        $parameters = ['assessment', 'report', 'completed'];

        foreach ($parameters as $parameter){
            if (isset($data[$parameter])){
                unset($data[$parameter]);
            }
        }

        return $data;
    }
}