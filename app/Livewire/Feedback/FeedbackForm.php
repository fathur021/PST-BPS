<?php

namespace App\Livewire\Feedback;

use App\Models\Feedback;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;

class FeedbackForm extends Component
{
    public $nama_lengkap;
    public $petugas_pst;
    public $front_office;
    public $kepuasan_petugas_pst;
    public $kepuasan_petugas_front_office;
    public $kepuasan_sarana_prasarana;
    public $kritik_saran;
    public $frontOfficeUser;
    public $petugasPstUser;
    public $frontOfficePhotoUrl;
    public $petugasPstPhotoUrl;

    protected $rules = [
        'nama_lengkap' => 'string|required',
        'petugas_pst' => 'required',
        'front_office' => 'required',
        'kepuasan_petugas_pst' => 'required|integer|between:1,5',
        'kepuasan_petugas_front_office' => 'required|integer|between:1,5',
        'kepuasan_sarana_prasarana' => 'required|integer|between:1,5',
    ];

    protected function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks.',
            'petugas_pst.required' => 'Petugas PST wajib dipilih.',
            'front_office.required' => 'Front Office wajib dipilih.',
            'kepuasan_petugas_pst.required' => 'Kepuasan terhadap petugas PST wajib diisi.',
            'kepuasan_petugas_pst.integer' => 'Kepuasan terhadap petugas PST harus berupa angka.',
            'kepuasan_petugas_pst.between' => 'Kepuasan terhadap petugas PST harus antara 1 hingga 5.',
            'kepuasan_petugas_front_office.required' => 'Kepuasan terhadap petugas Front Office wajib diisi.',
            'kepuasan_petugas_front_office.integer' => 'Kepuasan terhadap petugas Front Office harus berupa angka.',
            'kepuasan_petugas_front_office.between' => 'Kepuasan terhadap petugas Front Office harus antara 1 hingga 5.',
            'kepuasan_sarana_prasarana.required' => 'Kepuasan terhadap sarana dan prasarana wajib diisi.',
            'kepuasan_sarana_prasarana.integer' => 'Kepuasan terhadap sarana dan prasarana harus berupa angka.',
            'kepuasan_sarana_prasarana.between' => 'Kepuasan terhadap sarana dan prasarana harus antara 1 hingga 5.',
        ];
    }

    #[Computed()]
    public function listPetugasPst()
    {
        return User::role('pst')->get();
    }

    #[Computed()]
    public function listFrontOffice()
    {
        return User::role('front-office')->get();
    }

    public function updatedPetugasPst(){
        $petugasPstUser = User::find($this->petugas_pst);

        if ($petugasPstUser) {
            $this->petugasPstPhotoUrl = $petugasPstUser->avatar_url;
        } else {
            $this->petugasPstPhotoUrl = null;
        }
    }
    public function updatedFrontOffice(){
        $frontOfficeUser = User::find($this->front_office);

        if ($frontOfficeUser) {
            $this->frontOfficePhotoUrl = $frontOfficeUser->avatar_url;
        } else {
            $this->frontOfficePhotoUrl = null;
        }
    }

    public function submit()
    {
        $validateData = $this->validate();
        Feedback::create($validateData);
        $this->reset();
        $this->dispatch('open-modal');
    }

    public function getListeners()
    {
        return [
            'setPetugasPst' => 'updatePetugasPst',
            'setFrontOffice' => 'updateFrontOffice',
        ];
    }

    public function render()
    {
        return view('livewire.feedback.feedback-form');
    }
}
