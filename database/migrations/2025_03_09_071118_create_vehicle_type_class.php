<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vehicle_type_class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types');
            $table->foreignId('vehicle_class_id')->constrained('vehicle_classes');
            $table->integer('fare_increment');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicle_type_class');
    }
};
