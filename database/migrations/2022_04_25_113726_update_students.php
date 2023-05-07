<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->bigInteger('student_advisor')->nullable()->after('batch');
            $table->dateTime('last_advisory_report')->useCurrent()->after('student_advisor');
        });
    }
};
