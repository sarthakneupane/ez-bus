<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleClassesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_classes', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing 'id' column
            $table->string('name'); // Creates a 'name' column
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_classes');
    }
}
