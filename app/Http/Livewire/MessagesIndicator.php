<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MessagesIndicator extends Component
{
    /** @var array */
    protected $listeners = ['updateMessageIndicator' => 'render'];

    public function render(): \Illuminate\View\View
    {
        return view('livewire.messages-indicator', [
            'count' => auth()->user()->newThreadsCount(),
        ]);
    }
}
