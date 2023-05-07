<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class StudentDropDownView extends Component
{
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $batches;
    /** @var \Illuminate\Support\Collection */
    public $students;
    /** @var string */
    public $student_id;
    /** @var array|null */
    public $selectedBatch = null;
    /** @var array|null */
    public $selectedID = null;

    public function mount(): void
    {
        $this->batches = Student::distinct()->orderByDesc('batch')->get('batch');
        $this->students = collect();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.student-drop-down-view');
    }

    public function updatedSelectedBatch(string $batch): void
    {
        $this->batches = Student::distinct()->orderByDesc('batch')->get('batch');
        $this->students = Student::where('batch', $batch)->get('student_id');
    }

    public function updatedSelectedID(string $id): void
    {
        $this->batches = Student::distinct()->orderByDesc('batch')->get('batch');
        $this->student_id = $id;
    }
}
