<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(0);
            $table->string('name',50);
            $table->string('location',255);
            $table->integer('alert_period')->default(0);
            $table->integer('repeat_period')->default(0);
            $table->integer('athlete_id')->default(0);
            $table->string('note',200)->nullable();
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->integer('assessment')->nullable()->default(0);
            $table->string('report',200)->nullable()->default(null);
            $table->boolean('completed')->default(false);
            $table->string('repeat_identification')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_sessions');
    }
}
