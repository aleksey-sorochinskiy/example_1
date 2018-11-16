<?php
/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 26.06.18
 * Time: 13:48
 */

namespace App\Observers;


class EventReportObserver extends ActivityLogHook
{
    public function created(){}

    public function updating()
    {
        // TODO: Implement updating() method.
    }

    public function deleted(){}
}