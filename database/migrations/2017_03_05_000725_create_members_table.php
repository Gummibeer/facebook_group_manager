<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->string('first_name');
            $table->string('full_name');
            $table->boolean('is_silhouette')->default(false);
            $table->boolean('is_administrator')->default(false);
            $table->integer('gender')->default(0);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
}
