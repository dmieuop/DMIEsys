<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_category')->unsigned();
            $table->string('title');
            $table->string('subtitle');
            $table->integer('weight');
        });
    }
};
