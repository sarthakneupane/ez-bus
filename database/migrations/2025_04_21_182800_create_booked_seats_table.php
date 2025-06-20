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
        Schema::create('booked_seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('user_id');
            $table->string('seat_number'); // e.g., A1, A2
            $table->string('boarding_point');
            $table->timestamps();

            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['schedule_id', 'seat_number']); // prevent double booking
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booked_seats');
    }
};
