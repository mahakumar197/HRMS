<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectmastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projectmasters', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->unsignedBigInteger('user_id');
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('project_id');
            $table->string('billing_mode');
            $table->string('currency'); 
            $table->boolean('status');

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
        Schema::dropIfExists('projectmasters');
    }
}
