<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Student;
use App\Models\StudentEnrollment;
use Livewire\Component;

class StudentReportSelection extends Component
{
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $batches;
    /** @var \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection */
    public $students;
    /** @var string|null */
    public $selectedBatch = null;
    /** @var string|null */
    public $selectedStudent = null;

    public function mount(): void
    {
        $this->batches = Student::where('hasMarks', '=', '1')->distinct()->orderByDesc('batch')->get('batch');
        $this->students = collect();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.student-report-selection');
    }

    public function updatedSelectedBatch(string $batch): void
    {
        $this->students = StudentEnrollment::where('student_id', 'like', $batch . '%')->distinct()->get('student_id');
        $this->batches = Course::where('status', '=', 'Complete')->distinct()->orderByDesc('batch')->get('batch');
        $this->selectedStudent = null;
    }

    public function updatedSelectedStudent(): void
    {
        $this->students = StudentEnrollment::where('student_id', 'like', $this->selectedBatch . '%')->distinct()->get('student_id');
        $this->batches = Course::where('status', '=', 'Complete')->distinct()->orderByDesc('batch')->get('batch');
    }
}
