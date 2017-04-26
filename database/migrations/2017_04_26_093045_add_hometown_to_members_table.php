<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHometownToMembersTable extends Migration
{
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('hometown_address');
            $table->string('hometown_place_id');
            $table->float('hometown_lat');
            $table->float('hometown_lng');
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('hometown_address');
            $table->dropColumn('hometown_place_id');
            $table->dropColumn('hometown_lat');
            $table->dropColumn('hometown_lng');
        });
    }
}
