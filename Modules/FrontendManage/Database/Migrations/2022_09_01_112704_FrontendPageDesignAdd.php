<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\PrivacyPolicy;

class FrontendPageDesignAdd extends Migration
{
    public function up()
    {
        $privacy = PrivacyPolicy::first();
        $frontend = FrontPage::where('slug', '/privacy')->first();
        $frontend->title = $privacy->page_banner_title;
        $frontend->sub_title = $privacy->page_banner_sub_title;
        $frontend->banner = $privacy->page_banner;
        $frontend->details = '<div class="col-sm-12 ui-resizable" data-type="container-content"><div  data-type="component-text"
     data-keditor-title="Text block" data-keditor-categories="Text">' . $privacy->details . '</div></div>';
        $frontend->save();
    }

    public function down()
    {

    }
}
