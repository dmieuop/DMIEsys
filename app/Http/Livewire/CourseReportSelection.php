<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class CourseReportSelection extends Component
{
    /** @var \Illuminate\Database\Eloquent\Collection */
    public $batches;
    /** @var \Illuminate\Support\Collection */
    public $courses;
    /** @var string */
    public $selectedBatch = null;
    /** @var string|null */
    public $selectedCourse = null;

    /**
     * @return void
     */
    public function mount()
    {
        $this->batches = Course::where('status', '=', 'Complete')->distinct()->orderByDesc('batch')->get('batch');
        $this->courses = collect();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.course-report-selection');
    }

    /**
     * @return void
     */
    public function updatedSelectedBatch(string $batch)
    {
        $this->courses = Course::where('status', '=', 'Complete')->where('batch', '=', $batch)->get(['course_id', 'course_name']);
        $this->batches = Course::where('status', '=', 'Complete')->distinct()->orderByDesc('batch')->get('batch');
        $this->selectedCourse = null;
    }

    /**
     * @return void
     */
    public function updatedSelectedCourse()
    {
        $this->batches = Course::where('status', '=', 'Complete')->distinct()->orderByDesc('batch')->get('batch');
    }
}
