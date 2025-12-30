<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class RadioButtonInput extends Component
{
    #[Modelable]
    public $input = null;
    
    public $name;
    public $label;
    public $colorText = 'text-black';
    public $options = [];
    public $value = null;

    public $errorsBag = [];


    public function mount($name, $label, $options = [], $value = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
        $this->value = $value;
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
        return view('livewire.components.radio-button-input');
    }
}
