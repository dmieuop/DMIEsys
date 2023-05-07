<?php

namespace App\Console\Commands;

use App\Mail\RemindToMeetStudent;
use App\Models\Student;
use App\Models\User;
use App\Traits\Notify;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RemindAdvisorsToLogComments extends Command
{
    use Notify;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RemindAdvisorsToLogComments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check the student list and send a email to the advisors who did not meet their students for past 3 months. This will happens only in Tuesday.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $advisors = User::active()->get();
        foreach ($advisors as $advisor) {
            $students_older_than_6mo = Student::where('graduated', 0)
                ->where('student_advisor', $advisor->id)
                ->where('last_advisory_report', '<=', now()->subMonths(2))
                ->get();
            $students = Student::where('graduated', 0)
                ->where('student_advisor', $advisor->id)
                ->where('last_advisory_report', '<=', now()->subMonth())
                ->get();
            $body = [
                'advisor' => $advisor->title . ' ' . $advisor->name,
                'students' => $students,
            ];
            if ($students->first()) {
                Mail::to($advisor->email)->send(new RemindToMeetStudent($body));
            }
            if ($students_older_than_6mo->first()) {
                $reg_no_list = '(';
                foreach ($students_older_than_6mo as $student) {
                    if ($student === $students_older_than_6mo->last()) $reg_no_list = $reg_no_list . $student->student_id . ')';
                    else $reg_no_list = $reg_no_list . $student->student_id . ',';
                }
                $message = '<span class="bg-red-200 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Needs Attention</span> ' . $body['advisor'] . ' did not meet with their students ' . $reg_no_list . ' or record anything for more than two months. Please request that they meet with their students.';
                $this->notifyHOD($message);
            }
        }
    }
}
