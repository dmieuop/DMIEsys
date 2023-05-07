<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->integer('first_post_id')->after('locked')->unsigned()->nullable();
        });
    }
};
