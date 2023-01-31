<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timer', function (Blueprint $table) {
            $table->increments('timerid');
            $table->integer('workTime');
            $table->integer('breakTime');
            $table->integer('longBreakTime');
            $table->string('roomName', 70);
            $table->string('status', 70);
            $table->string('mode', 70);
            $table->string('endTime', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timer');
    }
}
