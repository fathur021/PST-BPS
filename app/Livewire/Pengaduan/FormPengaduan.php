<?php

namespace App\Livewire\Pengaduan;

use App\Models\FormPengaduan as ModelsFormPengaduan;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormPengaduan extends Component
{
    use WithFileUploads;
    
    public $nama_lengkap;
    public $alamat;
    public $pekerjaan;
    public $no_hp;
    public $email;
    public $rincian_informasi;
    public $tujuan_penggunaan_informasi;
    public $cara_memperoleh_informasi;
    public $cara_mendapatkan_salinan_informasi;
    public $bukti_identitas_diri_path;
    public $dokumen_pernyataan_keberatan_atas_permohonan_informasi_path;
    public $dokumen_permintaan_informasi_publik_path;
    public $tanda_tangan;

    protected $rules = [
        'nama_lengkap' => 'required|string|max:255',
        'alamat' => 'required|string|max:500',
        'pekerjaan' => 'required|string',
        'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
        'email' => 'required|email|max:255',
        'rincian_informasi' => 'required|string',
        'tujuan_penggunaan_informasi' => 'required|string',
        'cara_memperoleh_informasi' => 'required|string',
        'cara_mendapatkan_salinan_informasi' => 'required|string',
        'bukti_identitas_diri_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', 
        'dokumen_pernyataan_keberatan_atas_permohonan_informasi_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'dokumen_permintaan_informasi_publik_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'tanda_tangan' => 'required|string',
    ];

    protected function messages()
    {
        return [
            'nama_lengkap.required' => 'Nama depan wajib diisi.',
            'nama_lengkap.string' => 'Nama depan harus berupa teks.',
            'nama_lengkap.max' => 'Nama depan maksimal 255 karakter.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.string' => 'Alamat harus berupa teks.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'pekerjaan.required' => 'Pekerjaan wajib diisi.',
            'pekerjaan.string' => 'Pekerjaan harus berupa teks.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP harus berupa angka.',
            'no_hp.min' => 'Nomor HP minimal 10 karakter.',
            'no_hp.max' => 'Nomor HP maksimal 15 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'rincian_informasi.required' => 'Rincian Informasi wajib diisi.',
            'rincian_informasi.string' => 'Rincian Informasi harus berupa teks.',
            'tujuan_penggunaan_informasi.required' => 'Tujuan Penggunaan Informasi wajib diisi.',
            'tujuan_penggunaan_informasi.string' => 'Tujuan Penggunaan Informasi harus berupa teks.',
            'cara_memperoleh_informasi.required' => 'Cara Memperoleh Informasi wajib diisi.',
            'cara_memperoleh_informasi.string' => 'Cara Memperoleh Informasi harus berupa teks.',
            'cara_mendapatkan_salinan_informasi.required' => 'Cara Mendapatkan Salinan Informasi wajib diisi.',
            'cara_mendapatkan_salinan_informasi.string' => 'Cara Mendapatkan Salinan Informasi harus berupa teks.',

            // Custom messages for new fields
            'bukti_identitas_diri_path.required' => 'Bukti Identitas Diri wajib diunggah.',
            'bukti_identitas_diri_path.file' => 'Bukti Identitas Diri harus berupa file.',
            'bukti_identitas_diri_path.mimes' => 'Bukti Identitas Diri harus berupa file dengan format jpg, jpeg, png, atau pdf.',
            'bukti_identitas_diri_path.max' => 'Ukuran file Bukti Identitas Diri maksimal 2MB.',

            'dokumen_pernyataan_keberatan_atas_permohonan_informasi_path.file' => 'Dokumen harus berupa file.',
            'dokumen_pernyataan_keberatan_atas_permohonan_informasi_path.mimes' => 'Dokumen harus berupa file dengan format jpg, jpeg, png, atau pdf.',
            'dokumen_pernyataan_keberatan_atas_permohonan_informasi_path.max' => 'Ukuran Dokumen maksimal 2MB.',

            'dokumen_permintaan_informasi_publik_path.file' => 'Dokumen harus berupa file.',
            'dokumen_permintaan_informasi_publik_path.mimes' => 'Dokumen harus berupa file dengan format jpg, jpeg, png, atau pdf.',
            'dokumen_permintaan_informasi_publik_path.max' => 'Ukuran Dokumen maksimal 2MB.',

            'tanda_tangan.required' => 'Tanda tangan wajib diisi.',
            'tanda_tangan.string' => 'Tanda tangan harus berupa data string.',
        ];
    }

    public function submit()
    {
            
            $this->validate();
            Log::info($this->validate());
            if ($this->bukti_identitas_diri_path) {
                $filePathBuktIIdentitas = $this->bukti_identitas_diri_path->store('bukti-identitas', 'public');
            }
            if ($this->dokumen_pernyataan_keberatan_atas_permohonan_informasi_path) {
                $filePathPernyataanKeberatan = $this->dokumen_pernyataan_keberatan_atas_permohonan_informasi_path->store('dokumen-formulir/dokumen-pernyataan-keberatan-atas-permohonan-informasi', 'public');
            }
            if ($this->dokumen_permintaan_informasi_publik_path) {
                $filePathPermintaanInformasi = $this->dokumen_permintaan_informasi_publik_path->store('dokumen-formulir/dokumen-permintaan-informasi-publik', 'public');
            }
            ModelsFormPengaduan::create([
                'nama_lengkap' => $this->nama_lengkap,
                'alamat' => $this->alamat,
                'pekerjaan' => $this->pekerjaan,
                'no_hp' => $this->no_hp,
                'email' => $this->email,
                'rincian_informasi' => $this->rincian_informasi,
                'tujuan_penggunaan_informasi' => $this->tujuan_penggunaan_informasi,
                'cara_memperoleh_informasi' => $this->cara_memperoleh_informasi,
                'cara_mendapatkan_salinan_informasi' => $this->cara_mendapatkan_salinan_informasi,
                'bukti_identitas_diri_path' => $filePathBuktIIdentitas ?? null, // Simpan path file ke database
                'dokumen_pernyataan_keberatan_atas_permohonan_informasi_path' => $filePathPernyataanKeberatan ?? null, // Simpan path file ke database
                'dokumen_permintaan_informasi_publik_path' => $filePathPermintaanInformasi ?? null, // Simpan path file ke database
                'tanda_tangan' => $this->tanda_tangan,
            ]);
            session()->flash('message', 'Pengaduan entry created successfully.');
            Log::info("Sukses membuat pengaduan");

            Log::info("Sukses reset inputan");
            $this->dispatch('open-modal');
            Log::info("Sukses membuka modal");

    }

    public function rendered(): void
    {
        $this->dispatch('ParentComponentValidated', $this->getErrorBag()->messages());
    }

    public function render()
    {
        return view('livewire.pengaduan.form-pengaduan');
    }
}
