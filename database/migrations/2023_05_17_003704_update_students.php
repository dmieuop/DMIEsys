<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('profile_photo', 100)->nullable()->after('profile_link');
            $table->string('cv', 100)->nullable()->after('profile_photo');
            $table->boolean('job_seeker')->default(0)->after('cv');
        });
    }
};
