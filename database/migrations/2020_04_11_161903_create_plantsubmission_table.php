<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 
 * This is a migration, a big part of Laravel. It allows us to run
 *  and potentially roll back SQL using the php artisan migrate
 *  commands. This migration creates the PlantSubmission table. It's basically like
 *  a SQL setup script.
 * 
 * 
 */
class CreatePlantSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PlantSubmission', function (Blueprint $table) {
            $table->id('plantSubmissionId');
            $table->bigInteger('userId')->unsigned();
            $table->foreign('userId')->references('userId')->on('users')->onDelete('cascade');
            $table ->bigInteger('plantId')->unsigned();
            $table->bigInteger('upvotes');
            $table->foreign('plantId')->references('plantId')->on('Plant')->onDelete('cascade'); 
            $table->double('latitude');
            $table->double('longitude');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantsubmission');
    }
}
