<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');

            /*******************************************/
            /* 0 => Text Area                          */
            /* 1 => Datepicker                         */
            /* 2 => Radio Option (Single choice)       */
            /* 3 => Checkbox Option (Multiple choices) */
            /*******************************************/
            $table->integer('type')->unsigned()->default('0');

            $table->text('question');
            $table->text('right_answer')->nullable()->default('-');
            $table->longText('choices')->nullable()->default('-'); //JSON format
            $table->boolean('isRequired')->default(false);
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
        Schema::dropIfExists('contents');
    }
}
