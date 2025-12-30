<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;

class GuestBookPage extends Component
{
    public function index(Request $request)
    {
        // $tipePengunjung = $request->query('from', 'langsung');
    }

    public function render()
    {
        return view('livewire.guest-book-page', [
            // 'tipePengunjung' => $this->tipePengunjung,
        ]);
    }
}
