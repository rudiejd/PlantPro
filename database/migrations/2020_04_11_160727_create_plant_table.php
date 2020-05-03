<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


/**
 * 
 * This is a migration, a big part of Laravel. It allows us to run
 *  and potentially roll back SQL using the php artisan migrate
 *  commands. This migration creates the Plant table. It's basically like
 *  a SQL setup script.
 * 
 * 
 */
class CreatePlantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Plant', function (Blueprint $table) {
            $table->id('plantId');
            $table->string('commonName');
            $table->string('division');
            $table->string('class');
            $table->string('order');
            $table->string('family');
            $table->string('genus');
            $table->string('species');
	    $table->string('variety');
	    $table->softDeletes();
            $table->tinyInteger('isDeleted')->default('0');
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
        Schema::dropIfExists('plant');
    }
}
