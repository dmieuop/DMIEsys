<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InventoryItemAddQRCode extends Component
{
    /** @var array */
    protected $listeners = ['updateQRCode'];

    /** @var string */
    public $item_code = 'DMIE-IT-CPU-HP-06-017-001';
    /** @var string */
    public $item_code_link = 'https://mie.pdn.ac.lk/dmiesys/inventory/';
    /** @var int */
    public $QRcodeSize = 100;

    /**
     * @param string $item_code
     * @return void
     */
    public function updateQRCode(string $item_code)
    {
        if ($item_code == '') $this->item_code = 'DMIE-IT-CPU-HP-06-017-001';
        else $this->item_code = $item_code;
        $this->item_code_link = 'https://mie.pdn.ac.lk/dmiesys/inventory/' . $this->item_code;
        $this->render();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.inventory-item-add-q-r-code', [
            'item_code' => $this->item_code,
            'item_code_link' => $this->item_code_link,
            'QRcodeSize' => $this->QRcodeSize,
        ]);
    }
}
