<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('forum_categories', function (Blueprint $table) {
            $table->nestedSet();
            $table->dropColumn(['category_id', 'weight']);
        });
    }
};
