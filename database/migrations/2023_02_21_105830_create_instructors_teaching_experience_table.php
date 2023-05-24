<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorsTeachingExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors_teaching_experience', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('current_position', 100)->nullable();
            $table->string('phone', 100)->unique();
            $table->string('employee_name', 100)->nullable();
            $table->date('date_employer')->nullable();
            $table->string('supervisor_name', 100)->nullable();
            $table->varchar('upload_resume', 255)->nullable();
            $table->string('cover', 255)->nullable();
            $table->string('address', 255);
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
        Schema::dropIfExists('instructors_teaching_experience');
    }
}
