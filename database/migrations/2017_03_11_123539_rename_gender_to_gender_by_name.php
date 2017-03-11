<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameGenderToGenderByName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('gender', 'gender_by_name');
        });
        Schema::table('members', function (Blueprint $table) {
            $table->integer('gender')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('gender_by_name', 'gender');
        });
    }
}
