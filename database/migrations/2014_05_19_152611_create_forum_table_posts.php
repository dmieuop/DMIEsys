<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_thread')->unsigned();
            $table->integer('author_id')->unsigned();
            $table->text('content');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
