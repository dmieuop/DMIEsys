<?php

namespace App\Http\Livewire;

use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Str;

class StudentLoginDropdown extends Component
{
    public $selectedCategory = null;
    public $selectedBatch = null;
    public $selectedStudentID = null;
    public $batches;
    public $students;
    public $email = null;

    public function MaskEmail(string $originalEmail): string
    {
        $emailPrefix =  Str::beforeLast($originalEmail, '@');
        $emailPrefixLength =  Str::length($emailPrefix);
        $maskedEmail = Str::mask($originalEmail, '*', 2, $emailPrefixLength - 2);

        return $maskedEmail;
    }

    public function mount(): void
    {
        $this->students = collect();
        $this->email = null;
        $this->batches = Student::distinct()->orderByDesc('batch')->get('batch');
        if (!is_null($this->selectedBatch)) {
            $this->students = Student::undergraduate()->where('batch', $this->selectedBatch)->get('student_id');
        }
    }

    public function render()
    {
        return view('livewire.student-login-dropdown');
    }

    public function updatedSelectedCategory(string $cat): void
    {
        if ($cat == 'undergraduate') {
            $this->batches = Student::distinct()->orderByDesc('batch')->get('batch');
        } elseif ($cat == 'alumni') {
            $this->selectedBatch = null;
            $this->selectedStudentID = null;
        }
    }

    public function updatedSelectedBatch(): void
    {
        $this->selectedStudentID = null;
        $this->mount();
    }

    public function updatedSelectedStudentID(): void
    {
        $this->mount();
        $user = Student::where('student_id', $this->selectedStudentID)->first();
        $this->email = $this->MaskEmail($user->email);
    }
}
