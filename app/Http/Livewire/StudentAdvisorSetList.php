<?php

namespace App\Http\Livewire;

use App\Models\Student;
use App\Models\User;
use Livewire\Component;

class StudentAdvisorSetList extends Component
{
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $batches;
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $advisors;
    /** @var \Illuminate\Support\Collection */
    public $students;
    /** @var string */
    public $student_id;
    /** @var string */
    public $advisor_id;
    /** @var string|null */
    public $selectedBatch = null;
    /** @var string|null */
    public $selectedStudent = null;
    /** @var int|null */
    public $selectedStudentHasAdvisor = false;
    /** @var string|null */
    public $selectedAdvisor = null;


    public function mount(): void
    {
        $this->batches = Student::where('graduated', 0)
            ->distinct()->orderByDesc('batch')->get('batch');
        $this->students = collect();
        $this->advisors = User::role(['Head of the Department', 'Professor', 'Senior Lecturer', 'Lecturer', 'Contract Basis Lecturer', 'Probationary Lecturer', 'Visiting Lecture', 'Temporary Lecturer'])->active()->get(['id', 'title', 'name']);
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.student-advisor-set-list');
    }

    public function updatedSelectedBatch(string $batch): void
    {
        $this->selectedStudentHasAdvisor = null;
        $this->batches = Student::where('graduated', 0)
            ->distinct()->orderByDesc('batch')->get('batch');
        $this->students = Student::where('batch', $batch)->get('student_id');
    }

    public function updatedSelectedStudent(string $id): void
    {
        $this->selectedStudentHasAdvisor = null;
        $this->batches = Student::where('graduated', 0)
            ->distinct()->orderByDesc('batch')->get('batch');
        $this->student_id = $id;
        $student = Student::where('student_id', $id)->first();
        if ($student->student_advisor) $this->selectedStudentHasAdvisor = $student->student_advisor;
    }

    public function updatedSelectedAdvisor(string $id): void
    {
        $this->batches = Student::where('graduated', 0)
            ->distinct()->orderByDesc('batch')->get('batch');
        $this->advisor_id = $id;
    }
}
