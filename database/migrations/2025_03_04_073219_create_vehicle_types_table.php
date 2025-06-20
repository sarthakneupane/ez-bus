<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTypesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->string('name'); // Column to store the name of the vehicle type
            $table->string('slug')->unique(); // Column to store the slug of the vehicle type Adish Dahal => adish-
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_types');
    }
}
