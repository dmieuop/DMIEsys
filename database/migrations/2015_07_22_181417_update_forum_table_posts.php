<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->renameColumn('parent_thread', 'thread_id');
            $table->integer('post_id')->after('content')->unsigned()->nullable();
        });
    }
};
