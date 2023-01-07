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
        Schema::create('experts', function (Blueprint $table) {
            $table->unsignedBigInteger('expert_id');
            $table->foreign('expert_id')->references('user_id')->on('users');
            $table->string('phone', 55);
            $table->text('experience');
            $table->string('address', 255);
            $table->float('rate')->default(0.0);
            $table->integer('rate_count', false, true)->default(0);
            $table->float('cost', 8, 2, true)->default(10);
            $table->integer('duration', false, true)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experts');
    }
};
