<?php

namespace App\Jobs;

use App\BaseEvent;
use App\Notifications\SendAlertSession;
use App\OtherEvent;
use App\TestSession;
use App\TrainingSession;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AlertSession implements ShouldQueue
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
        $periods = BaseEvent::ALERT_PERIODS_TIME;

        foreach ($periods as $period) {
            $this->sendNotification(TrainingSession::class, $period);

            $this->sendNotification(TestSession::class, $period);

            $this->sendNotification(OtherEvent::class, $period);
        }
    }

    /**
     * Send Notification of alert session
     * @param $class
     * @param $period
     */
    protected function sendNotification($class, $period)
    {
        $time = Carbon::now()->addMinutes($period);

        $trainingSessions = $class::whereBetween('time_start',[
            $time->format('Y-m-d H:i').':00',
            $time->format('Y-m-d H:i').':59'
        ])
            ->with('user')->get();

        foreach ($trainingSessions as $session) {
            $session->user->notify(new SendAlertSession($session));
        }
    }
}
