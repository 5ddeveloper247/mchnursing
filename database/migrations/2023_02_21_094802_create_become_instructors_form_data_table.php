<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBecomeInstructorsFormDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('become_instructors_form_data', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('instructor_position_id');
            $table->integer('ainstructor_hear_id');
            $table->date('start_date');
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
        Schema::dropIfExists('become_instructors_form_data');
    }
}
