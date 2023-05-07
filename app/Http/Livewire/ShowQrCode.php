<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowQrCode extends Component
{
    /** @var int */
    public $QRcodeSize = 150;
    /** @var string */
    public $itemCode = '...';
    /** @var array */
    protected $listeners = ['itemCodeChanged' => 'SetQR'];

    public function render(): \Illuminate\View\View
    {
        return view('livewire.show-qr-code');
    }

    public function SetQR(string $val): void
    {
        $this->itemCode = $val;
    }
}
