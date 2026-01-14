<?php

namespace App\Filament\Exports;

use App\Models\FormPengaduan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class FormPengaduanCsvExporter
{
    /**
     * Export data FormPengaduan ke CSV dengan format yang rapi
     */
    public static function export()
    {
        try {
            // Ambil data dengan relasi jika ada
            $pengaduans = FormPengaduan::orderBy('created_at', 'desc')->get();
            
            $filename = 'pengaduan_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            
            $callback = function() use ($pengaduans) {
                $file = fopen('php://output', 'w');
                
                // Tambah BOM untuk UTF-8
                fwrite($file, "\xEF\xBB\xBF");
                
                // Header CSV sesuai urutan form
                fputcsv($file, [
                    'ID',
                    'Nama Lengkap',
                    'Alamat',
                    'Pekerjaan',
                    'Nomor HP',
                    'Email',
                    'Rincian Informasi',
                    'Tujuan Penggunaan Informasi',
                    'Cara Memperoleh Informasi',
                    'Cara Mendapatkan Salinan Informasi',
                    'Bukti Identitas (Path)',
                    'Dokumen Pernyataan (Path)',
                    'Dokumen Permintaan (Path)',
                    'Tanda Tangan',
                    'Tanggal Pengisian',
                    'Terakhir Diupdate'
                ], ';');
                
                // Data dengan sanitasi
                foreach ($pengaduans as $pengaduan) {
                    fputcsv($file, [
                        $pengaduan->id,
                        self::cleanString($pengaduan->nama_lengkap),
                        self::cleanString($pengaduan->alamat),
                        self::cleanString($pengaduan->pekerjaan),
                        self::cleanString($pengaduan->no_hp),
                        self::cleanString($pengaduan->email),
                        self::cleanString($pengaduan->rincian_informasi, true),
                        self::cleanString($pengaduan->tujuan_penggunaan_informasi, true),
                        self::cleanString($pengaduan->cara_memperoleh_informasi),
                        self::cleanString($pengaduan->cara_mendapatkan_salinan_informasi),
                        self::cleanString($pengaduan->bukti_identitas_diri_path),
                        self::cleanString($pengaduan->dokumen_pernyataan_keberatan_atas_permohonan_informasi_path),
                        self::cleanString($pengaduan->dokumen_permintaan_informasi_publik_path),
                        self::cleanString($pengaduan->tanda_tangan),
                        $pengaduan->created_at ? $pengaduan->created_at->format('d-m-Y H:i:s') : '',
                        $pengaduan->updated_at ? $pengaduan->updated_at->format('d-m-Y H:i:s') : '',
                    ], ';');
                }
                
                fclose($file);
            };
            
            Log::info('Pengaduan CSV export successful: ' . $pengaduans->count() . ' records exported');
            
            return Response::stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Pengaduan CSV export failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback ke export sederhana
            return self::exportSimple();
        }
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
            // Ganti newline dengan spasi ganda agar rapi di Excel
            $value = str_replace(["\r\n", "\n"], '  ', $value);
        } else {
            $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
            $value = str_replace(["\r", "\n"], ' ', $value);
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
            $pengaduans = FormPengaduan::select([
                'id',
                'nama_lengkap',
                'pekerjaan',
                'no_hp',
                'email',
                'created_at'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
            
            $filename = 'pengaduan_simple_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];
            
            $callback = function() use ($pengaduans) {
                $file = fopen('php://output', 'w');
                fwrite($file, "\xEF\xBB\xBF");
                
                fputcsv($file, [
                    'ID', 'Nama Lengkap', 'Pekerjaan', 'Nomor HP', 
                    'Email', 'Tanggal Pengisian'
                ], ';');
                
                foreach ($pengaduans as $pengaduan) {
                    fputcsv($file, [
                        $pengaduan->id,
                        self::cleanString($pengaduan->nama_lengkap),
                        self::cleanString($pengaduan->pekerjaan),
                        self::cleanString($pengaduan->no_hp),
                        self::cleanString($pengaduan->email),
                        $pengaduan->created_at ? $pengaduan->created_at->format('d-m-Y H:i:s') : '',
                    ], ';');
                }
                
                fclose($file);
            };
            
            Log::info('Simple Pengaduan CSV export successful: ' . $pengaduans->count() . ' records exported');
            
            return Response::stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Simple Pengaduan CSV export also failed: ' . $e->getMessage());
            
            // Kirim file error message
            return self::exportErrorMessage();
        }
    }
    
    /**
     * Export pesan error jika semua gagal
     */
    private static function exportErrorMessage()
    {
        $filename = 'pengaduan_export_error_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'Terjadi kesalahan saat mengekspor data pengaduan. Silakan coba lagi atau hubungi administrator.',
                date('d-m-Y H:i:s')
            ], ';');
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}