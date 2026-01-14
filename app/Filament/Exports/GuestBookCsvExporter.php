<?php

namespace App\Filament\Exports;

use App\Models\GuestBook;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class GuestBookCsvExporter
{
    /**
     * Export data GuestBook ke CSV dengan format yang rapi dan urutan sesuai form
     */
    public static function export()
    {
        try {
            // Ambil data dengan relasi
            $guestBooks = GuestBook::with(['provinsi', 'kota', 'petugasPst'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            $filename = 'buku_tamu_' . date('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            
            $callback = function() use ($guestBooks) {
                $file = fopen('php://output', 'w');
                
                // Tambah BOM untuk UTF-8 (agar Excel membaca dengan benar)
                fwrite($file, "\xEF\xBB\xBF");
                
                // ✅ URUTAN SESUAI FORM di GuestBookResource.php (SECTION PER SECTION)
                fputcsv($file, [
                    // SECTION 1: IDENTITAS PRIBADI (sesuai Section 1 di form)
                    'ID',
                    'Nomor Antrian',
                    'Sumber Tamu (WA/Web)',
                    'Nama Lengkap',
                    'Jenis Kelamin',
                    'Usia',
                    'Email',
                    'Nomor HP',
                    'Provinsi',
                    'Kota/Kabupaten',
                    'Alamat Lengkap',
                    
                    // SECTION 2: PEKERJAAN (sesuai Section 2 di form)
                    'Pekerjaan',
                    'Jurusan',
                    'Asal Universitas',
                    'Asal Instansi',
                    'Asal Universitas/Lembaga',
                    'Organisasi/Perusahaan/Kantor',
                    
                    // SECTION 3: TUJUAN KUNJUNGAN (sesuai Section 3 di form)
                    'Tujuan Kunjungan',
                    'Tujuan Kunjungan Lainnya',
                    'Deskripsi/Keterangan',
                    
                    // TAMBAHKAN JENIS LAYANAN (dari tabel, bukan form)
                    'Jenis Layanan',
                    
                    // SECTION 4: STATUS BUKU TAMU (sesuai Section 4 di form)
                    'Status',
                    'Petugas PST',
                    
                    // TIMESTAMPS & LAINNYA (tambahan untuk tracking)
                    'Mulai Proses',
                    'Selesai',
                    'Durasi (detik)',
                    'Tanggal Pengisian',
                    'Terakhir Diperbarui'
                ], ';');
                
                // Data dengan sanitasi
                foreach ($guestBooks as $guest) {
                    // Tentukan nilai berdasarkan pekerjaan
                    $jurusan = '';
                    $asal_universitas = '';
                    $asal_instansi = '';
                    $asal_univ_lembaga = '';
                    $organisasi = '';
                    
                    if ($guest->pekerjaan === 'mahasiswa') {
                        $jurusan = self::cleanString($guest->jurusan);
                        $asal_universitas = self::cleanString($guest->asal_universitas);
                    } elseif ($guest->pekerjaan === 'dinas/instansi/opd') {
                        $asal_instansi = self::cleanString($guest->asal);
                    } elseif ($guest->pekerjaan === 'peneliti') {
                        $asal_univ_lembaga = self::cleanString($guest->asal_universitas_lembaga);
                    } elseif ($guest->pekerjaan === 'umum') {
                        $organisasi = self::cleanString($guest->organisasi_nama_perusahaan_kantor);
                    }
                    
                    fputcsv($file, [
                        // SECTION 1: IDENTITAS PRIBADI
                        $guest->id,
                        self::formatValue($guest->nomor_antrian),
                        self::formatTamuDari($guest->tamu_dari),
                        self::cleanString($guest->nama_lengkap),
                        self::formatJenisKelamin($guest->jenis_kelamin),
                        $guest->usia ?: '',
                        self::cleanString($guest->email),
                        self::formatNoHP($guest->no_hp),
                        self::cleanString(optional($guest->provinsi)->name),
                        self::cleanString(optional($guest->kota)->name),
                        self::cleanString($guest->alamat),
                        
                        // SECTION 2: PEKERJAAN
                        self::formatPekerjaan($guest->pekerjaan),
                        $jurusan,
                        $asal_universitas,
                        $asal_instansi,
                        $asal_univ_lembaga,
                        $organisasi,
                        
                        // SECTION 3: TUJUAN KUNJUNGAN
                        self::formatTujuanKunjungan($guest->tujuan_kunjungan),
                        self::cleanString($guest->tujuan_kunjungan_lainnya),
                        self::cleanString($guest->deskripsi, true),
                        
                        // JENIS LAYANAN (dari tabel)
                        self::formatJenisLayanan($guest->jenis_layanan),
                        
                        // SECTION 4: STATUS BUKU TAMU
                        self::formatStatus($guest->status),
                        self::cleanString(optional($guest->petugasPst)->name),
                        
                        // TIMESTAMPS & LAINNYA
                        $guest->in_progress_at ? $guest->in_progress_at->format('d-m-Y H:i:s') : '',
                        $guest->done_at ? $guest->done_at->format('d-m-Y H:i:s') : '',
                        $guest->duration ?: '',
                        $guest->created_at ? $guest->created_at->format('d-m-Y H:i:s') : '',
                        $guest->updated_at ? $guest->updated_at->format('d-m-Y H:i:s') : '',
                    ], ';');
                }
                
                fclose($file);
            };
            
            Log::info('CSV export successful: ' . $guestBooks->count() . ' records exported');
            
            return Response::stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('CSV export failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback ke export sederhana
            return self::exportSimple();
        }
    }
    
    /**
     * Format tamu dari
     */
    private static function formatTamuDari($value)
    {
        if ($value === 'wa') return 'WhatsApp';
        if ($value === 'web') return 'Web';
        return $value ?: '';
    }
    
    /**
     * Format jenis kelamin
     */
    private static function formatJenisKelamin($value)
    {
        if ($value === 'laki-laki') return 'Laki-laki';
        if ($value === 'perempuan') return 'Perempuan';
        return $value ?: '';
    }
    
    /**
     * Format pekerjaan
     */
    private static function formatPekerjaan($value)
    {
        switch ($value) {
            case 'mahasiswa': return 'Mahasiswa';
            case 'dinas/instansi/opd': return 'Dinas/Instansi/OPD';
            case 'peneliti': return 'Peneliti';
            case 'umum': return 'Umum';
            default: return $value ?: '';
        }
    }
    
    /**
     * Format tujuan kunjungan
     */
    private static function formatTujuanKunjungan($value)
    {
        if (is_array($value)) {
            $formatted = [];
            $map = [
                'permintaan_data/peta' => 'Permintaan Data/Peta',
                'konsultasi_statistik' => 'Konsultasi Statistik',
                'permintaan_data_mikro' => 'Permintaan Data Mikro',
                'romantik' => 'Romantik',
                'lainnya' => 'Lainnya'
            ];
            
            foreach ($value as $item) {
                $formatted[] = $map[$item] ?? $item;
            }
            
            return implode('; ', $formatted);
        }
        
        return $value ?: '';
    }
    
    /**
     * Format jenis layanan
     */
    private static function formatJenisLayanan($value)
    {
        if ($value === 'pst') return 'PST';
        if ($value === 'ppid') return 'PPID';
        return $value ?: '';
    }
    
    /**
     * Format status
     */
    private static function formatStatus($value)
    {
        switch ($value) {
            case 'pending': return 'Pending';
            case 'inProgress': return 'In Progress';
            case 'done': return 'Done';
            default: return $value ?: '';
        }
    }
    
    /**
     * Format nomor HP
     */
    private static function formatNoHP($value)
    {
        if (!$value) return '';
        
        // Format: 0812-3456-7890
        $value = preg_replace('/[^0-9]/', '', $value);
        if (strlen($value) >= 10) {
            return substr($value, 0, 4) . '-' . substr($value, 4, 4) . '-' . substr($value, 8);
        }
        
        return $value;
    }
    
    /**
     * Format nilai umum
     */
    private static function formatValue($value)
    {
        return $value ?: '';
    }
    
    /**
     * Bersihkan string dari karakter non-UTF-8
     */
    private static function cleanString($value, $allowNewlines = false)
    {
        if (!$value) return '';
        
        // Konversi ke UTF-8 jika perlu
        if (!mb_check_encoding($value, 'UTF-8')) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        }
        
        // Hapus karakter kontrol kecuali newline jika diizinkan
        if ($allowNewlines) {
            $value = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
        } else {
            $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
            $value = str_replace(["\r", "\n"], ' ', $value); // Ganti newline dengan spasi
        }
        
        // Hapus tab dan spasi berlebih
        $value = str_replace("\t", ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value);
        
        return trim($value);
    }
    
    /**
     * Export sederhana jika yang lengkap error
     */
    private static function exportSimple()
    {
        try {
            $guestBooks = GuestBook::select([
                'id',
                'nomor_antrian',
                'tamu_dari',
                'nama_lengkap',
                'email',
                'no_hp',
                'pekerjaan',
                'status',
                'created_at'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
            
            $filename = 'buku_tamu_simple_' . date('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];
            
            $callback = function() use ($guestBooks) {
                $file = fopen('php://output', 'w');
                fwrite($file, "\xEF\xBB\xBF");
                
                fputcsv($file, [
                    'ID', 'Nomor Antrian', 'Sumber Tamu', 'Nama Lengkap', 'Email', 'Nomor HP',
                    'Pekerjaan', 'Status', 'Tanggal Pengisian'
                ], ';');
                
                foreach ($guestBooks as $guest) {
                    fputcsv($file, [
                        $guest->id,
                        self::formatValue($guest->nomor_antrian),
                        self::formatTamuDari($guest->tamu_dari),
                        self::cleanString($guest->nama_lengkap),
                        self::cleanString($guest->email),
                        self::formatNoHP($guest->no_hp),
                        self::formatPekerjaan($guest->pekerjaan),
                        self::formatStatus($guest->status),
                        $guest->created_at ? $guest->created_at->format('d-m-Y H:i:s') : '',
                    ], ';');
                }
                
                fclose($file);
            };
            
            Log::info('Simple CSV export successful: ' . $guestBooks->count() . ' records exported');
            
            return Response::stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Simple CSV export also failed: ' . $e->getMessage());
            
            // Kirim file error message
            return self::exportErrorMessage();
        }
    }
    
    /**
     * Export pesan error jika semua gagal
     */
    private static function exportErrorMessage()
    {
        $filename = 'export_error_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            
            fputcsv($file, ['Status', 'Pesan', 'Waktu'], ';');
            fputcsv($file, [
                'ERROR',
                'Terjadi kesalahan saat mengekspor data. Silakan coba lagi atau hubungi administrator.',
                date('d-m-Y H:i:s')
            ], ';');
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}