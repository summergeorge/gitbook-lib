<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishBuildLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publishBuildLogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pid');
            $table->text('book_json')->nullable();
            $table->longText('log')->nullable();
            $table->string('status')->default('ready');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publishBuildLogs');
    }
}
