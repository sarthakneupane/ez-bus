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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('passenger_id');
            $table->integer('seats');
            $table->float('price');
            $table->float('total');
            $table->enum('status',['0','1']);
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('passenger_id')->references('id')->on('users');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
