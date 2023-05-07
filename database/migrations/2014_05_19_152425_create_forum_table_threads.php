<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_category')->unsigned();
            $table->integer('author_id')->unsigned();
            $table->string('title');
            $table->boolean('pinned');
            $table->boolean('locked');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
