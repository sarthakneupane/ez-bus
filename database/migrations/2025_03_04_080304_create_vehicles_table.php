<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key 'id'
            $table->unsignedBigInteger('bus_company_id');
            $table->string('vehicle_no')->unique(); // Vehicle registration number
            $table->unsignedBigInteger('vehicle_type_id');
            $table->unsignedBigInteger('vehicle_class_id');
            
            $table->text('amenities')->nullable(); // Amenities provided in the vehicle
            $table->unsignedBigInteger('seat_formats_id');
            $table->string('registration_pdf')->nullable(); // PDF path for vehicle registration
            $table->string('image')->nullable(); // Image path for the vehicle

            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // Adds deleted_at column for soft deletes ✅

            $table->foreign('bus_company_id')->references('id')->on('bus_companies');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->foreign('vehicle_class_id')->references('id')->on('vehicle_classes');
            $table->foreign('seat_formats_id')->references('id')->on('seat_formats');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
