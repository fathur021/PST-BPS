<?php

namespace App\Livewire\GuestBook;

use App\Models\GuestBook;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;

class FormGuestBook extends Component
{
    use WithFileUploads;

    #[Url]
    public $tamu_dari = 'web';
    
    #[Url]
    public $jenis_layanan_param;

    // FORM PROPERTIES
    public $nama_lengkap;
    public $jenis_kelamin;
    public $usia;
    public $pekerjaan;
    public $jurusan;
    public $asal_universitas;
    public $asal;
    public $asal_universitas_lembaga;
    public $organisasi_nama_perusahaan_kantor;
    public $no_hp;
    public $email;
    public $provinsi_id;
    public $kota_id;
    public $alamat;
    public $tujuan_kunjungan = [];
    public $tujuan_kunjungan_lainnya;
    public $bukti_identitas_diri_path;
    public $dokumen_permintaan_informasi_publik_path;
    
    // SEKARANG BISA NULL/KOSONG!
    public $jenis_layanan = null;

    public $showModal = false;
    public $nomorAntrian;

    // =========================
    // VALIDATION RULES - DIUBAH
    // =========================
    protected function rules()
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'usia' => 'required|numeric|min:1|max:150',
            'pekerjaan' => 'required|string',
            'jurusan' => 'nullable|required_if:pekerjaan,mahasiswa|string|max:255',
            'asal_universitas' => 'nullable|required_if:pekerjaan,mahasiswa|string|max:255',
            'asal_universitas_lembaga' => 'nullable|required_if:pekerjaan,peneliti|string|max:255',
            'asal' => 'nullable|required_if:pekerjaan,dinas/instansi/opd|string|max:255',
            'organisasi_nama_perusahaan_kantor' => 'nullable|required_if:pekerjaan,umum|string|max:255',
            'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'email' => 'required|email|max:255',
            'alamat' => 'required|string|max:500',
            'kota_id' => 'required',
            'provinsi_id' => 'required',
            'tujuan_kunjungan' => 'required|array|min:1',
            'tujuan_kunjungan_lainnya' => 'nullable|string',
            'bukti_identitas_diri_path' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'dokumen_permintaan_informasi_publik_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'jenis_layanan' => 'nullable|string|max:50', // Bisa NULL!
        ];

        // HANYA WhatsApp yang wajib pilih
        if ($this->isFromWhatsApp()) {
            $rules['jenis_layanan'] = 'required|in:pst,ppid';
        }

        if (in_array('lainnya', $this->tujuan_kunjungan)) {
            $rules['tujuan_kunjungan_lainnya'] = 'required|string|max:255';
        }

        return $rules;
    }

    // =========================
    // MOUNT METHOD - SEDERHANA
    // =========================
    public function mount()
    {
        $this->showModal = false;
        $this->nomorAntrian = null;
        
        if (request()->has('tamu_dari')) {
            $this->tamu_dari = request()->query('tamu_dari');
        }
        
        // HANYA set nilai jika dari WhatsApp dengan parameter
        if ($this->isFromWhatsApp() && request()->has('jenis_layanan')) {
            $this->jenis_layanan = request()->query('jenis_layanan');
        }
        // Web langsung: biarkan NULL/kosong
    }

    // =========================
    // COMPUTED PROPERTIES
    // =========================
    #[Computed]
    public function isFromWhatsApp()
    {
        return $this->tamu_dari == 'wa';
    }

    // =========================
    // SUBMIT FORM - DIUBAH
    // =========================
    public function submit()
    {
        // Validasi
        $this->validate();
        
        // Handle tujuan lainnya
        if (!in_array('lainnya', $this->tujuan_kunjungan)) {
            $this->tujuan_kunjungan_lainnya = null;
        }

        // Bersihkan field berdasarkan pekerjaan
        $this->cleanFieldsByPekerjaan();

        // Upload file
        $uploadedFiles = $this->uploadFiles();

        // Siapkan data untuk disimpan
        $dataToSave = [
            'nama_lengkap' => $this->nama_lengkap,
            'jenis_kelamin' => $this->jenis_kelamin,
            'usia' => $this->usia,
            'pekerjaan' => $this->pekerjaan,
            'jurusan' => $this->jurusan,
            'asal_universitas' => $this->asal_universitas,
            'asal' => $this->asal,
            'asal_universitas_lembaga' => $this->asal_universitas_lembaga,
            'organisasi_nama_perusahaan_kantor' => $this->organisasi_nama_perusahaan_kantor,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'provinsi_id' => $this->provinsi_id,
            'kota_id' => $this->kota_id,
            'alamat' => $this->alamat,
            'tujuan_kunjungan' => $this->tujuan_kunjungan,
            'tujuan_kunjungan_lainnya' => $this->tujuan_kunjungan_lainnya,
            'bukti_identitas_diri_path' => $uploadedFiles['bukti_identitas'],
            'dokumen_permintaan_informasi_publik_path' => $uploadedFiles['dokumen_formulir'],
            'jenis_layanan' => $this->jenis_layanan, // Bisa NULL untuk web langsung
            'tamu_dari' => $this->tamu_dari,
        ];

        // Simpan ke database
        $guest = GuestBook::create($dataToSave);
        $guest->refresh();

        $this->nomorAntrian = $guest->nomor_antrian;

        Log::info('Guest Book Created', [
            'id' => $guest->id,
            'nomor_antrian' => $guest->nomor_antrian,
            'tamu_dari' => $guest->tamu_dari,
            'jenis_layanan' => $guest->jenis_layanan,
        ]);

        // Reset form
        $this->resetForm();

        // Tampilkan modal
        $this->showModal = true;
    }

    // =========================
    // HELPER METHODS 
    // =========================
    private function cleanFieldsByPekerjaan()
    {
        switch ($this->pekerjaan) {
            case 'mahasiswa':
                $this->asal = null;
                $this->asal_universitas_lembaga = null;
                $this->organisasi_nama_perusahaan_kantor = null;
                break;

            case 'dinas/instansi/opd':
                $this->jurusan = null;
                $this->asal_universitas = null;
                $this->asal_universitas_lembaga = null;
                $this->organisasi_nama_perusahaan_kantor = null;
                break;

            case 'peneliti':
                $this->jurusan = null;
                $this->asal_universitas = null;
                $this->asal = null;
                $this->organisasi_nama_perusahaan_kantor = null;
                break;

            case 'umum':
                $this->jurusan = null;
                $this->asal_universitas = null;
                $this->asal = null;
                $this->asal_universitas_lembaga = null;
                break;
        }
    }

    private function uploadFiles()
    {
        $uploads = [
            'bukti_identitas' => null,
            'dokumen_formulir' => null,
        ];

        if ($this->bukti_identitas_diri_path) {
            $uploads['bukti_identitas'] = $this->bukti_identitas_diri_path
                ->store('bukti-identitas', 'public');
        }

        if ($this->dokumen_permintaan_informasi_publik_path) {
            $uploads['dokumen_formulir'] = $this->dokumen_permintaan_informasi_publik_path
                ->store('dokumen-formulir/dokumen-permintaan-informasi-publik', 'public');
        }

        return $uploads;
    }

    private function resetForm()
    {
        $this->reset([
            'nama_lengkap',
            'jenis_kelamin',
            'usia',
            'pekerjaan',
            'jurusan',
            'asal_universitas',
            'asal',
            'asal_universitas_lembaga',
            'organisasi_nama_perusahaan_kantor',
            'no_hp',
            'email',
            'provinsi_id',
            'kota_id',
            'alamat',
            'tujuan_kunjungan',
            'tujuan_kunjungan_lainnya',
            'bukti_identitas_diri_path',
            'dokumen_permintaan_informasi_publik_path',
            'jenis_layanan',
        ]);
        
        // Set nilai kembali
        $this->jenis_layanan = null; 
    }

    // =========================
    // DEPENDENT SELECT
    // =========================
    public function updatedProvinsiId()
    {
        $this->kota_id = null;
    }

    #[Computed]
    public function provinces()
    {
        return Province::all();
    }

    #[Computed]
    public function regencies()
    {
        if (!$this->provinsi_id) {
            return collect();
        }
        return Regency::where('provinsi_id', $this->provinsi_id)->get();
    }

    // =========================
    // CLOSE MODAL METHOD
    // =========================
    public function closeModal()
    {
        $this->showModal = false;
        $this->nomorAntrian = null;
    }

    public function render()
    {
        return view('livewire.guest-book.form-guest-book');
    }
}