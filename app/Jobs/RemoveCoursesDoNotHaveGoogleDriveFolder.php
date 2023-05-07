<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\GoogleFolderId;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveCoursesDoNotHaveGoogleDriveFolder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $all_courses = Course::where('status', 'Ongoing')->where('should_remove', 1)->get();

        foreach ($all_courses as $course) {
            $course->delete();
        }
    }
}
