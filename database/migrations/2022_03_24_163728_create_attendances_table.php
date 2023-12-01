<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
             
            $table->json('primary_project');
            $table->json('secondary_project');
            $table->date('attendance_date');
            $table->integer('total_working_hours');
            $table->float('day_count');
            $table->text('work_from');

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade');

             
            

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
        Schema::dropIfExists('attendances');
    }
}
