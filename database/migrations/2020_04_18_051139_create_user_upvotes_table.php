<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserUpvotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UserUpvotes', function (Blueprint $table) {
            $table->bigInteger('userId')->unsigned();
            $table->bigInteger('plantSubmissionId')->unsigned();
            $table->unique( ['userId', 'plantSubmissionId'] );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('UserUpvotes');
    }
}
