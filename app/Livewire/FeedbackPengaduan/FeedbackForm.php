<?php

namespace App\Livewire\FeedbackPengaduan;

use App\Livewire\Feedback\FeedbackForm as FeedbackFeedbackForm;
use App\Models\FeedbackPengaduan;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FeedbackForm extends Component
{
    public $nama_lengkap;
    public $petugas_pengaduan;
    public $kepuasan_petugas_pengaduan;
    public $kepuasan_sarana_prasarana_pengaduan;
    public $kritik_saran;
    public $petugasPengaduanUser;
    public $petugasPengaduanPhotoUrl;

    protected $rules = [
        'nama_lengkap' => 'string|required',
        'petugas_pengaduan' => 'required',
        'kepuasan_petugas_pengaduan' => 'required|integer|between:1,5',
        'kepuasan_sarana_prasarana_pengaduan' => 'required|integer|between:1,5',
        'kritik_saran' => 'string',
    ];

    protected function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string' => 'Nama lengkap harus berupa teks.',
            'petugas_pengaduan.required' => 'Petugas PST wajib dipilih.',
            'kepuasan_petugas_pengaduan.required' => 'Kepuasan terhadap petugas PST wajib diisi.',
            'kepuasan_petugas_pengaduan.integer' => 'Kepuasan terhadap petugas PST harus berupa angka.',
            'kepuasan_petugas_pengaduan.between' => 'Kepuasan terhadap petugas PST harus antara 1 hingga 5.',
            'kepuasan_sarana_prasarana_pengaduan.required' => 'Kepuasan terhadap petugas PST wajib diisi.',
            'kepuasan_sarana_prasarana_pengaduan.integer' => 'Kepuasan terhadap petugas PST harus berupa angka.',
            'kepuasan_sarana_prasarana_pengaduan.between' => 'Kepuasan terhadap petugas PST harus antara 1 hingga 5.',

        ];
    }

    #[Computed()]
    public function listPetugasPengaduan()
    {
        return User::all();
    }

    public function updatedPetugasPengaduan(){
        $petugasPengaduanUser = User::find($this->petugas_pengaduan);

        if ($petugasPengaduanUser) {
            $this->petugasPengaduanPhotoUrl = $petugasPengaduanUser->avatar_url;
        } else {
            $this->petugasPengaduanPhotoUrl = null;
        }
    }

    public function submit()
    {
        $validateData = $this->validate();
        FeedbackPengaduan::create($validateData);
        $this->reset();
        $this->dispatch('open-modal');
    }

    public function getListeners()
    {
        return [
            'setPetugasPengaduan' => 'updatePetugasPengaduan',
        ];
    }

    public function render()
    {
        return view('livewire.feedback-pengaduan.feedback-form');
    }
}
