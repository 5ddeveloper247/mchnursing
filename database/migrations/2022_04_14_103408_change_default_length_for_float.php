<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeDefaultLengthForFloat extends Migration
{

    public function up()
    {
        $sqls[] = "ALTER TABLE `users` CHANGE `balance` `balance` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        if (Schema::hasTable('checkouts')) {
            $sqls[] = "ALTER TABLE `checkouts` CHANGE `discount` `discount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
            $sqls[] = "ALTER TABLE `checkouts` CHANGE `purchase_price` `purchase_price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
            $sqls[] = "ALTER TABLE `checkouts` CHANGE `price` `price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('coupons')) {
            $sqls[] = "ALTER TABLE `coupons` CHANGE `value` `value` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
            $sqls[] = "ALTER TABLE `coupons` CHANGE `min_purchase` `min_purchase` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
            $sqls[] = "ALTER TABLE `coupons` CHANGE `max_discount` `max_discount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('courses')) {
            $sqls[] = "ALTER TABLE `courses` CHANGE `reveune` `reveune` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('course_enrolleds')) {
            $sqls[] = "ALTER TABLE `course_enrolleds` CHANGE `purchase_price` `purchase_price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
            $sqls[] = "ALTER TABLE `course_enrolleds` CHANGE `discount_amount` `discount_amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
            $sqls[] = "ALTER TABLE `course_enrolleds` CHANGE `reveune` `reveune` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('offline_payments')) {
            $sqls[] = "ALTER TABLE `offline_payments` CHANGE `amount` `amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
            $sqls[] = "ALTER TABLE `offline_payments` CHANGE `after_bal` `after_bal` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }
        if (Schema::hasTable('carts')) {
            $sqls[] = "ALTER TABLE `carts` CHANGE `price` `price` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('withdraws')) {
            $sqls[] = "ALTER TABLE `withdraws` CHANGE `amount` `amount` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        if (Schema::hasTable('instructor_payouts')) {
            $sqls[] = "ALTER TABLE `instructor_payouts` CHANGE `reveune` `reveune` DOUBLE(20,2) NOT NULL DEFAULT '0.00';";
        }

        foreach ($sqls as $sql) {
            DB::statement($sql);
        }

    }

    public function down()
    {
        //
    }
}
