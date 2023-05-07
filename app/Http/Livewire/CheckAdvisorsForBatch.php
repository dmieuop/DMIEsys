<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;

class CheckAdvisorsForBatch extends Component
{
    /** @var string|null */
    public $selectedBatch = null;
    public $students = [];

    public function render()
    {
        return view('livewire.check-advisors-for-batch', [
            'batches' => Student::where('graduated', 0)->distinct()->orderByDesc('batch')->get('batch'),
        ]);
    }

    public function updatedSelectedBatch($batch)
    {
        $this->students = Student::where('batch', $batch)->get(['student_id', 'student_advisor', 'graduated']);
        // dd($this->students);
    }
}
