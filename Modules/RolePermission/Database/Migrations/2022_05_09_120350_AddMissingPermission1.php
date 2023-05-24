<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddMissingPermission1 extends Migration
{

    public function up()
    {
        DB::table('permissions')->insert([
            [
                'name' => 'Regular Student Import',
                'route' => 'regular_student_import',
                'parent_route' => 'students',
                'type' => 2,
            ], [
                'name' => 'New Enroll',
                'route' => 'student.new_enroll',
                'parent_route' => 'students',
                'type' => 2,
            ], [
                'name' => 'Setting',
                'route' => 'student.student_field',
                'parent_route' => 'students',
                'type' => 2,
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
