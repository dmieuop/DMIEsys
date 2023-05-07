<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->index('category_id');
        });

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->index('thread_id');
        });
    }
};
