<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->id('work_time_id');
            $table->unsignedBigInteger('expert_id');
            $table->foreign('expert_id')->references('expert_id')->on('experts');
            $table->tinyInteger('day',false,true);
            $table->tinyInteger('from');
            $table->tinyInteger('to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_times');
    }
};
