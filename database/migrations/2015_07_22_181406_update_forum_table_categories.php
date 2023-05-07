<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('forum_categories', function (Blueprint $table) {
            $table->renameColumn('parent_category', 'category_id');
            // $table->renameColumn('subtitle', 'description');
        });

        Schema::table('forum_categories', function (Blueprint $table) {
            // $table->renameColumn('parent_category', 'category_id');
            $table->renameColumn('subtitle', 'description');
        });

        Schema::table('forum_categories', function (Blueprint $table) {
            $table->integer('category_id')->default(0)->change();
            $table->text('description')->nullable()->change();
            $table->integer('weight')->default(0)->change();

            $table->boolean('enable_threads')->default(0);
            $table->boolean('private')->default(0);

            $table->timestamps();
        });
    }
};
