<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vehicle_has_routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('route_id');

            // Foreign key constraints
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');

            $table->timestamps(); // Optional: to track created_at/updated_at
            $table->softDeletes(); // Enables soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_has_routes');
    }
};
