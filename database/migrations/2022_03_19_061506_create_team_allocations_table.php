<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('project_id');
            $table->string('is_primary_project');
            $table->string('work_type');
            $table->string('billable');
            $table->string('shadow_eligible');            
            $table->date('start_date');
            $table->date('end_date');           
            $table->integer('unit_rate');
            $table->boolean('status');

              
           
            

            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade');

            $table->foreign('project_id')
            ->references('id')->on('projectmasters')
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
        Schema::dropIfExists('team_allocations');
    }
}
