<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           
            $table->string('employee_code')->nullable(); 
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();         
             
            
            $table->date('joining_date')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            
            $table->string('marital_status')->nullable();
            $table->string('phone_number');
            $table->string('emergency_contact');
            $table->string('reporting_to');
            $table->text('res_address')->nullable();
            $table->string('res_city')->nullable();
            $table->string('res_state')->nullable();
            $table->string('res_postal_code',50)->nullable();
            $table->text('per_address')->nullable();
            $table->string('per_city')->nullable();
            $table->string('per_state')->nullable();
            $table->string('per_postal_code',50)->nullable();
            $table->string('nationality')->nullable();
            $table->String('dependency')->nullable();
            $table->string('dependency_name')->nullable();
            $table->string('higest_qualification')->nullable();
            $table->boolean('employee_status')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('pan_number')->nullable();
            
            $table->float('experience')->nullable();
            
            $table->text('skill_set')->nullable();
            $table->date('exit_date')->nullable();            
            $table->string('role')->nullable();
            $table->string('image_path')->nullable();
            $table->dateTime('password_change_at')->nullable();
            $table->dateTime('last_login_time')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('previous_employer')->nullable();
            $table->string('maternity_leave')->nullable();
            $table->date('ml_from_date')->nullable();
            $table->date('ml_to_date')->nullable();


            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
