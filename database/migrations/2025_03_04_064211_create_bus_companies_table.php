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
        Schema::create('bus_companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('bc_name');
            $table->integer('no_of_bus');
            $table->enum('status', [0, 1]); // Assuming 0 = inactive, 1 = active
            $table->string('company_registration')->nullable(); // Column to store file path of company registration proof
            $table->string('cover_letter')->nullable();         // Column to store file path of cover letter
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bus_companies');
    }
};
