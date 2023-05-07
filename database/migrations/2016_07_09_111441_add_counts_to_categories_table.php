<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('forum_categories', function (Blueprint $table) {
            // Add increments to the thread and post counts on the categories table
            $table->integer('post_count')->after('enable_threads')->default(0);
            $table->integer('thread_count')->after('enable_threads')->default(0);
        });
    }
};
