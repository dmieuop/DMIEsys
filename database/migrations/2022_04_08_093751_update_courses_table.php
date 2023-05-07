<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('course_folder_id', 50)->nullable()->after('status');
            $table->boolean('should_remove')->default(0)->after('course_folder_id');
        });
    }
};
