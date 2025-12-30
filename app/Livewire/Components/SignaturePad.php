<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class SignaturePad extends Component
{
    #[Modelable]
    public $value = null;

    public function render()
    {
        return view('livewire.components.signature-pad');
    }
}
