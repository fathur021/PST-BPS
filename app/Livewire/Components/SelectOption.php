<?php

namespace App\Livewire\Components;

use App\Models\Province;
use App\Models\Regency;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SelectOption extends Component
{
    #[Modelable]
    public $value = null;

    public $name;
    public $label;
    public $colorText = 'text-black';
    public $errorsBag = [];

    #[Reactive]
    public $options;

    #[On('ParentComponentValidated')]
    public function setErrors(array $errors): void
    {
        $this->errorsBag = [];
        foreach ($errors as $name => $messages) {
            $this->errorsBag[$name] = $messages[0] ?? null;
        };
    }

    public function mount ($name, $options, $label){
        $this->name = $name;
        $this->options = $options;
        $this->label =$label;
        $this->options->ensure([Province::class, Regency::class]);
    }

    public function render()
    {
        return view('livewire.components.select-option');
    }
}
