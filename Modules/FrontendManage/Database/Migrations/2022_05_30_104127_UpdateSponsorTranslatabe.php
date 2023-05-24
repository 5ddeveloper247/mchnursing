<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class UpdateSponsorTranslatabe extends Migration
{

    public function up()
    {
        DB::statement('ALTER TABLE `sponsors`
    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL');

        $lang_code = 'en';
        $table_name = 'sponsors';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'title' => '{"' . $lang_code . '":"' . $row->title . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
