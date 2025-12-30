<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class TextInput extends Component
{
    #[Modelable]
    public $value = null;

    public $label;
    public $name;
    public $colorText = 'text-black';
    public $type = 'text';
    public $placeholder = '';
    public $errorsBag = [];

    // Tambahan variabel untuk tipe number
    public $min = 1;
    public $max = 150;
    public $span = 'Tahun'; // Misalnya untuk usia

    public $inputmode;
    public $pattern;

    public $rows;

    #[On('ParentComponentValidated')]
    public function setErrors(array $errors): void
    {
        $this->errorsBag = [];
        foreach ($errors as $name => $messages) {
            $this->errorsBag[$name] = $messages[0] ?? null;
        }
    }

    public function render()
    {
        return view('livewire.components.text-input');
    }
}

