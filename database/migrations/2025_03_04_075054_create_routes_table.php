<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {

            $table->id(); // Creates an auto-incrementing 'id' column
            $table->unsignedBigInteger('from');
            $table->unsignedBigInteger('to');
            $table->decimal('fare');
            $table->timestamps(); // Adds 'created_at' and 'updated_at' columns
             $table->softDeletes();
            $table->foreign('from')->references('id')->on('locations');
            $table->foreign('to')->references('id')->on('locations');
        });
    }

    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
