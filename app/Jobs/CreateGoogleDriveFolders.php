<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\GoogleFolderId;
use App\Models\User;
use App\Traits\Notify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class CreateGoogleDriveFolders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Notify;

    /** @var \App\Models\Course */
    protected $course;
    /** @var \App\Models\User */
    protected $user;

    public function __construct(Course $course, User $user)
    {
        $this->course = $course;
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '1_general_information');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '2_mid_semester_examination');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '3_end_semester_examination');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '4_assessment');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '5_teaching_and_learning_material');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '6_attendance');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '7_evaluation_&_feedback');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '8_marked_samples');
            Storage::cloud()->makeDirectory($this->course['course_folder_id'] .  '/' . '9_FEeLS');

            $all_folders = collect(Storage::cloud()->listContents($this->course['course_folder_id'], false));

            $folder = new GoogleFolderId();
            $folder->course_id = $this->course['course_id'];
            $folder->folder_id = $this->course['course_folder_id'];
            for ($i = 0; $i < count($all_folders); $i++) {
                $folder[$all_folders[$i]['name']] = $all_folders[$i]['basename'];
            }
            $folder->save();

            $course_folder = GoogleFolderId::where('course_id', $this->course['course_id'])->first();
            $teaching_and_learning_material_folder_id = $course_folder['5_teaching_and_learning_material'];
            $attendance_folder_id = $course_folder['6_attendance'];
            $evaluation_and_feedback_folder_id = $course_folder['7_evaluation_&_feedback'];
            $marked_samples_folder_id = $course_folder['8_marked_samples'];
            Storage::cloud()->makeDirectory($teaching_and_learning_material_folder_id .  '/' . '5_1_tutorials');
            Storage::cloud()->makeDirectory($teaching_and_learning_material_folder_id .  '/' . '5_2_assignments');
            Storage::cloud()->makeDirectory($teaching_and_learning_material_folder_id .  '/' . '5_3_practical_materials');
            Storage::cloud()->makeDirectory($teaching_and_learning_material_folder_id .  '/' . '5_4_lecture_materials');
            Storage::cloud()->makeDirectory($attendance_folder_id .  '/' . '6_2_medicals_and_requests_for_lab_re-schedule');
            Storage::cloud()->makeDirectory($evaluation_and_feedback_folder_id .  '/' . '7_1_course_evaluation_summary');
            Storage::cloud()->makeDirectory($evaluation_and_feedback_folder_id .  '/' . '7_2_teacher_Evaluation_summary');
            Storage::cloud()->makeDirectory($evaluation_and_feedback_folder_id .  '/' . '7_3_practical_evaluation_summary');
            Storage::cloud()->makeDirectory($evaluation_and_feedback_folder_id .  '/' . '7_4_peer_reviews');
            Storage::cloud()->makeDirectory($evaluation_and_feedback_folder_id .  '/' . '7_5_internal_QA_meeting_outcome');
            Storage::cloud()->makeDirectory($marked_samples_folder_id .  '/' . '8_1_tutorials_marked_samples');
            Storage::cloud()->makeDirectory($marked_samples_folder_id .  '/' . '8_2_assignments_marked_samples');
            Storage::cloud()->makeDirectory($marked_samples_folder_id .  '/' . '8_3_practical_course_work_marked_samples');
            Storage::cloud()->makeDirectory($marked_samples_folder_id .  '/' . '8_4_mid_semester_examination_marked_samples');
            Storage::cloud()->makeDirectory($marked_samples_folder_id .  '/' . '8_5_end_semester_examination_marked_samples');

            $all_folders = collect(Storage::cloud()->listContents($this->course['course_folder_id'], true));
            for ($i = 0; $i < count($all_folders); $i++) {
                $course_folder[$all_folders[$i]['name']] = $all_folders[$i]['basename'];
            }
            $course_folder->save();
            $message = 'Google Drive folders for <b>' . $this->course->course_id . '</b> created successfully!';
            $this->notifyUser($this->user, $message);
        } catch (\Throwable $th) {
            $this->DeleteRecords();
        }
    }

    public function DeleteRecords(): void
    {
        $course_folder = GoogleFolderId::where('course_id', $this->course['course_id'])->first();
        if ($course_folder) $course_folder->delete();
        Storage::cloud()->deleteDirectory($this->course['course_folder_id']);
        $this->course->should_remove = true;
        $this->course->save();
        $message = 'There was a problem creating Google Drive folders for <b>' . $this->course->course_id . '</b>. All the record for the course was deleted.';
        $this->notifyUser($this->user, $message);
        RemoveCoursesDoNotHaveGoogleDriveFolder::dispatch();
    }
}
