<?php

use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class AddSidebarManagerModule extends Migration
{
    public function up()
    {
        try {
            $module = new ModuleManagerController();
            $module->FreemoduleAddOnsEnable('SidebarManager');
        } catch (\Exception $e) {

        }
    }

    public function down()
    {
        //
    }
}
