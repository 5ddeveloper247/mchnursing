<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePrivacyPolicyTableTranslateable extends Migration
{

    public function up()
    {
        DB::statement('ALTER TABLE `privacy_policies`
    CHANGE `page_banner_title` `page_banner_title` LONGTEXT  NULL DEFAULT NULL,
    CHANGE `page_banner_sub_title` `page_banner_sub_title` LONGTEXT  NULL DEFAULT NULL,
    CHANGE `details` `details` LONGTEXT  NULL DEFAULT NULL;
    ');

        $lang_code = 'en';
        $table_name = 'privacy_policies';

        $rows = DB::table($table_name)->get();
        foreach ($rows as $row) {
            $pos = strpos($row->page_banner_title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'page_banner_title' => '{"' . $lang_code . '":"' . $row->page_banner_title . '"}',
                ]);
            }

            $pos = strpos($row->page_banner_sub_title, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'page_banner_sub_title' => '{"' . $lang_code . '":"' . $row->page_banner_sub_title . '"}',
                ]);
            }

            $pos = strpos($row->details, '{"');
            if ($pos === false) {
                DB::table($table_name)->where('id', $row->id)->update([
                    'details' => '{"' . $lang_code . '":"' . $row->details . '"}',
                ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
