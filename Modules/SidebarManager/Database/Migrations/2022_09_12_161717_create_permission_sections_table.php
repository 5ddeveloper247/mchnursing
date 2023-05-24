<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionSectionsTable extends Migration
{
    public function up()
    {
        try {
            Schema::create('permission_sections', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->integer('position')->default(9999);
                $table->tinyInteger('ecommerce')->default(0);
                $table->timestamps();
            });
            DB::table('permission_sections')->insert([
                'id' => 1,
                'name' => '',
                'position' => 1
            ]);
        } catch (\Exception $exception) {

        }
    }

    public function down()
    {
        Schema::dropIfExists('permission_sections');
    }
}
