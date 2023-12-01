<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaymodelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holidaymodels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('holidayname',100);
			$table->date('holidaydate')->unique();
			$table->string('holidaytype',100);
            $table->string('holidayscope',100);
            $table->boolean('holidaystatus')->default(1);
            $table->boolean('fullDay')->default(1);
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
        Schema::dropIfExists('holidaymodels');
    }
}
