<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFrontendPageTableTranslateable extends Migration
{

    public function up()
    {


        $lang_code = 'en';
        $table_name = 'front_pages';

        DB::statement('ALTER TABLE `' . $table_name . '`
    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
    CHANGE `sub_title` `sub_title` LONGTEXT  NULL DEFAULT NULL,
    CHANGE `details` `details` LONGTEXT  NULL DEFAULT NULL;

    ');

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $ignore = ['/affiliate'];




            $columns = [
                'title',
                'sub_title',
                'details'
            ];

            foreach ($columns as $column) {

                if ($column=='details' && in_array($row->slug, $ignore)) {
                    continue;
                }
                $pos = strpos($row->$column, '{"');
                if ($pos === false) {
                    DB::table($table_name)->where('id', $row->id)->update([
                        $column => '{"' . $lang_code . '":"' . $row->$column . '"}',
                    ]);
                }
            }


        }
    }


    public function down()
    {
        //
    }
}
