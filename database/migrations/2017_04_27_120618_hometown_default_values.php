<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HometownDefaultValues extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('hometown_address')->default('')->change();
            $table->string('hometown_place_id')->default('')->change();
            $table->float('hometown_lat')->default(0)->change();
            $table->float('hometown_lng')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            //
        });
    }
}
