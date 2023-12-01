<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();
            $table->date('startDate');
            $table->date('endDate');
            $table->string('name');
            $table->boolean('fullDay')->default(1);
            $table->integer('noOfDayApplied');
            $table->integer('noOfWorkingDay');
            $table->integer('noOfPublicHoliday');
            $table->integer('noOfDayDeduct');
            $table->integer('leaveStatus')->default(0);
            $table->foreignId('user_id');
            $table->foreignId('leave_type_id');
            $table->boolean('needCertificate')->default(0);
            $table->text('leaveReason');
            $table->integer('assignedBy')->nullable();
            $table->text('remarks')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
            
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
        Schema::dropIfExists('leave_applications');
    }
}
