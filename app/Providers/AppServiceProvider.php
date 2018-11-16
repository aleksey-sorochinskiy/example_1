<?php

namespace App\Providers;

use App\ActivityGroup;
use App\Athlete;
use App\Drill;
use App\Observers\AthleteObserver;
use App\Observers\DrillObserver;
use App\SetOfExercise;
use App\SpecificActivity;
use App\TypeOfTraining;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Athlete::observe(AthleteObserver::class);
        Drill::observe(DrillObserver::class);
        TypeOfTraining::observe(DrillObserver::class);
        SpecificActivity::observe(DrillObserver::class);
        ActivityGroup::observe(DrillObserver::class);
        SetOfExercise::observe(DrillObserver::class);
        //TODO: create observe for Events(TS, TSTS, OE), TSC, Event Report (TS, TSTS)
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
