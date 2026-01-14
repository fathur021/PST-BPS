<?php

namespace App\Livewire\GuestBook;

use App\Models\GuestBook;
use App\Models\Province;
use App\Models\Regency;
use Barryvdh\DomPDF\Facade\Pdf; // TAMBAHKAN
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;

class FormGuestBook extends Component
{
    use WithFileUploads;
    
    #[Url]
    public $tamu_dari = 'web';

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
    public $deskripsi;
    public $ktp;

    public $showModal = false;
    public $nomorAntrian;
    public $lastGuestId = null; // TAMBAHKAN untuk menyimpan ID terakhir

    // =========================
    // VALIDATION RULES
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
            'deskripsi' => 'nullable|string',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        if (in_array('lainnya', $this->tujuan_kunjungan)) {
            $rules['tujuan_kunjungan_lainnya'] = 'required|string|max:255';
        }

        return $rules;
    }

    // =========================
    // MOUNT METHOD
    // =========================
    public function mount()
    {
        $this->showModal = false;
        $this->nomorAntrian = null;
        
        if (request()->has('tamu_dari')) {
            $this->tamu_dari = request()->query('tamu_dari');
        }
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
    // SUBMIT FORM
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
            'tamu_dari' => $this->tamu_dari,
            'deskripsi' => $this->deskripsi,
        ];

        // Upload file KTP jika ada
        if ($this->ktp) {
            $ktpPath = $this->ktp->store('ktp', 'public');
            $dataToSave['ktp'] = $ktpPath;
        }

        // Simpan ke database
        $guest = GuestBook::create($dataToSave);
        $guest->refresh();

        // Simpan ID untuk PDF
        $this->lastGuestId = $guest->id;
        
        // Set nomor antrian
        $this->nomorAntrian = $guest->nomor_antrian;

        // Log info
        Log::info('Guest Book Created', [
            'id' => $guest->id,
            'nomor_antrian' => $guest->nomor_antrian,
            'tamu_dari' => $guest->tamu_dari,
        ]);

        // Reset form
        $this->resetForm();

        // Tampilkan modal
        $this->showModal = true;
    }

    // =========================
    // DOWNLOAD PDF METHOD
    // =========================
    public function downloadPdf()
    {
        // Cari data tamu berdasarkan ID terakhir
        $guest = GuestBook::find($this->lastGuestId);
        
        if (!$guest) {
            // Fallback: cari yang terbaru
            $guest = GuestBook::latest()->first();
        }
        
        if (!$guest) {
            session()->flash('error', 'Data tidak ditemukan');
            return;
        }
        
        // Data untuk PDF
        $data = [
            'source' => $guest->tamu_dari,
            'nomorAntrian' => $guest->nomor_antrian,
            'namaLengkap' => $guest->nama_lengkap,
            'noHp' => $guest->no_hp,
            'tujuanKunjungan' => $guest->tujuan_kunjungan,
            'tujuanLainnya' => $guest->tujuan_kunjungan_lainnya,
            'waktu' => $guest->created_at->format('H:i'),
            'tanggal' => $guest->created_at->format('d/m/Y'),
        ];
        
        try {
            // Generate PDF
            $pdf = Pdf::loadView('livewire.guest-book.pdf-ticket', $data);
            
            // Set ukuran kertas seperti struk (80mm width)
            $pdf->setPaper([0, 0, 226.77, 500], 'portrait');
            
            // Download PDF
            return response()->streamDownload(
                function () use ($pdf) {
                    echo $pdf->output();
                },
                'no Antrian-BPS Bukittinggi-' . sprintf('%03d', $guest->nomor_antrian) . '.pdf'
            );
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat PDF: ' . $e->getMessage());
            return null;
        }
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
            'deskripsi',
            'ktp',
        ]);
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
        $this->lastGuestId = null;
    }

    public function render()
    {
        return view('livewire.guest-book.form-guest-book');
    }
}