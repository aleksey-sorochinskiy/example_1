<?php
/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 26.06.18
 * Time: 13:10
 */

namespace App\Observers;
/**
 * Abstract Class ActivityLogHook
 * @package App\Observers
 */
abstract class ActivityLogHook
{
    abstract public function created();

    abstract public function updating();

    abstract public function deleted();
}