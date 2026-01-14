<?php

namespace App\Filament\Exports;

use App\Models\FeedbackPengaduan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class FeedbackPengaduanCsvExporter
{
    /**
     * Export data FeedbackPengaduan ke CSV
     */
    public static function export()
    {
        try {
            // Ambil data dengan relasi
            $feedbacks = FeedbackPengaduan::with(['petugasPengaduan'])
                ->orderBy('created_at', 'desc')
                ->get();
            
            $filename = 'feedback_pengaduan_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0',
            ];
            
            $callback = function() use ($feedbacks) {
                $file = fopen('php://output', 'w');
                
                // Tambah BOM untuk UTF-8
                fwrite($file, "\xEF\xBB\xBF");
                
                // Header CSV
                fputcsv($file, [
                    'ID',
                    'Nama Lengkap',
                    'Petugas Pengaduan',
                    'Rating Petugas (1-5)',
                    'Rating Sarana Prasarana (1-5)',
                    'Kritik & Saran',
                    'Tanggal Pengisian',
                    'Terakhir Diupdate'
                ], ';');
                
                // Data dengan sanitasi
                foreach ($feedbacks as $feedback) {
                    fputcsv($file, [
                        $feedback->id,
                        self::cleanString($feedback->nama_lengkap),
                        self::cleanString(optional($feedback->petugasPengaduan)->name),
                        $feedback->kepuasan_petugas_pengaduan,
                        $feedback->kepuasan_sarana_prasarana_pengaduan,
                        self::cleanString($feedback->kritik_saran, true),
                        $feedback->created_at ? $feedback->created_at->format('d-m-Y H:i:s') : '',
                        $feedback->updated_at ? $feedback->updated_at->format('d-m-Y H:i:s') : '',
                    ], ';');
                }
                
                fclose($file);
            };
            
            Log::info('Feedback Pengaduan CSV export successful: ' . $feedbacks->count() . ' records exported');
            
            return Response::stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Feedback Pengaduan CSV export failed: ' . $e->getMessage(), [
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
            $feedbacks = FeedbackPengaduan::select([
                'id',
                'nama_lengkap',
                'kepuasan_petugas_pengaduan',
                'kepuasan_sarana_prasarana_pengaduan',
                'created_at'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
            
            $filename = 'feedback_pengaduan_simple_' . date('Y-m-d_H-i-s') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];
            
            $callback = function() use ($feedbacks) {
                $file = fopen('php://output', 'w');
                fwrite($file, "\xEF\xBB\xBF");
                
                fputcsv($file, [
                    'ID', 'Nama Lengkap', 'Rating Petugas', 
                    'Rating Sarana Prasarana', 'Tanggal Pengisian'
                ], ';');
                
                foreach ($feedbacks as $feedback) {
                    fputcsv($file, [
                        $feedback->id,
                        self::cleanString($feedback->nama_lengkap),
                        $feedback->kepuasan_petugas_pengaduan,
                        $feedback->kepuasan_sarana_prasarana_pengaduan,
                        $feedback->created_at ? $feedback->created_at->format('d-m-Y H:i:s') : '',
                    ], ';');
                }
                
                fclose($file);
            };
            
            Log::info('Simple Feedback Pengaduan CSV export successful: ' . $feedbacks->count() . ' records exported');
            
            return Response::stream($callback, 200, $headers);
            
        } catch (\Exception $e) {
            Log::error('Simple Feedback Pengaduan CSV export also failed: ' . $e->getMessage());
            
            // Kirim file error message
            return self::exportErrorMessage();
        }
    }
    
    /**
     * Export pesan error jika semua gagal
     */
    private static function exportErrorMessage()
    {
        $filename = 'feedback_pengaduan_export_error_' . date('Y-m-d_H-i-s') . '.csv';
        
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
                'Terjadi kesalahan saat mengekspor data feedback pengaduan. Silakan coba lagi atau hubungi administrator.',
                date('d-m-Y H:i:s')
            ], ';');
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}