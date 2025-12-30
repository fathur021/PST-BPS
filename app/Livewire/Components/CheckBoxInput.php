<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class CheckBoxInput extends Component
{
    #[Modelable]
    public $input = []; // Store selected values in an array
    
    public $name;
    public $label;
    public $colorText = 'text-black';
    public $options = [];
    public $errorsBag = [];
    
    public function mount($name, $label, $options = [], $input = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->input = $input; 
    }

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
        return view('livewire.components.check-box-input');
    }
}
