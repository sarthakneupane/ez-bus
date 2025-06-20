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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_has_routes_id');
            $table->dateTime('departure_date_time');
            $table->dateTime('arrival_date_time');
            $table->enum('status',[0,1])->default('1');
            $table->integer('booked_seats');
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('vehicle_has_routes_id')->references('id')->on('vehicle_has_routes');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
