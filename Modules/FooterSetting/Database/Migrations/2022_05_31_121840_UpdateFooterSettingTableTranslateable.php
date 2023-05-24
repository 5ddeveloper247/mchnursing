<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class UpdateFooterSettingTableTranslateable extends Migration
{

    public function up()
    {
        DB::statement('ALTER TABLE `footer_widgets`
    CHANGE `name` `name` LONGTEXT  NULL DEFAULT NULL;');

        $lang_code = 'en';
        $table_name = 'footer_widgets';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->name, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'name' => '{"' . $lang_code . '":"' . $row->name . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
