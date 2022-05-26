<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSurveyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surver-details', function (Blueprint $table) {
            $table->increments('surver_detail_id');
            $table->bigInteger('question_id')->unsigned()->index();
            $table->bigInteger('quality_id')->unsigned()->index();
            $table->bigInteger('survey_id')->unsigned()->index();
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
        Schema::drop('surver-details');
    }
}
