<?php

namespace App\Http\Livewire;

use App\Models\AdvisoryComment;
use Livewire\Component;

class ShowPastAdvisoryComments extends Component
{
    protected $listeners = ['showPastComments'];
    public $student_id = null;

    public function render(): \Illuminate\View\View
    {
        $past_comments = AdvisoryComment::where('student_id', $this->student_id)
            ->where('commented_by', auth()->user()->id)
            ->orderByDesc('created_at')->limit(3)->get();
        return view('livewire.show-past-advisory-comments', [
            'past_comments' => $past_comments,
            'student_id' => $this->student_id,
        ]);
    }

    public function showPastComments(string $student_id): void
    {
        $this->student_id = $student_id;
    }
}
