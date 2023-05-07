<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('google_folder_ids', function (Blueprint $table) {
            $table->id();
            $table->string('course_id', 10)->unique();
            $table->string('folder_id', 50);
            $table->string('1_general_information', 50);
            $table->string('2_mid_semester_examination', 50);
            $table->string('3_end_semester_examination', 50);
            $table->string('4_assessment', 50);
            $table->string('5_teaching_and_learning_material', 50);
            $table->string('5_1_tutorials', 50)->nullable();
            $table->string('5_2_assignments', 50)->nullable();
            $table->string('5_3_practical_materials', 50)->nullable();
            $table->string('5_4_lecture_materials', 50)->nullable();
            $table->string('6_attendance', 50);
            $table->string('6_2_medicals_and_requests_for_lab_re-schedule', 50)->nullable();
            $table->string('7_evaluation_&_feedback', 50);
            $table->string('7_1_course_evaluation_summary', 50)->nullable();
            $table->string('7_2_teacher_Evaluation_summary', 50)->nullable();
            $table->string('7_3_practical_evaluation_summary', 50)->nullable();
            $table->string('7_4_peer_reviews', 50)->nullable();
            $table->string('7_5_internal_QA_meeting_outcome', 50)->nullable();
            $table->string('8_marked_samples', 50);
            $table->string('8_1_tutorials_marked_samples', 50)->nullable();
            $table->string('8_2_assignments_marked_samples', 50)->nullable();
            $table->string('8_3_practical_course_work_marked_samples', 50)->nullable();
            $table->string('8_4_mid_semester_examination_marked_samples', 50)->nullable();
            $table->string('8_5_end_semester_examination_marked_samples', 50)->nullable();
            $table->string('9_FEeLS', 50);
            $table->timestamps();
        });
    }
};
