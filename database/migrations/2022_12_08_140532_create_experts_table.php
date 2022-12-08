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
            $table->id('expert_id');
            $table->string('email',255)->unique();
            $table->string('password',255);
            $table->string('name',255);
            $table->string('photo',255)->nullable();
            $table->string('phone',55);
            $table->float('wallet',8,2,true)->default(0);
            $table->string('address',255);
            $table->float('rate')->default(0.0);
            $table->integer('rate_count',false,true)->default(0);
            $table->float('cost',8,2,true);
            $table->integer('duration',false,true);
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
        Schema::dropIfExists('experts');
    }
};
