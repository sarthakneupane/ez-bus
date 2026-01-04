<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing 'id' column
            $table->string('name'); // Cities of biratnagar
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
            $table->softDeletes(); // Adds 'deleted_at' column for soft deletes
        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
