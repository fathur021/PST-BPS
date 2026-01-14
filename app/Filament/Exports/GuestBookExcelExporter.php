<?php

namespace App\Filament\Exports;

use App\Models\GuestBook;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;

class GuestBookExcelExporter
{
    public static function export()
    {
        $guestBooks = GuestBook::query()
            ->select([
                'id',
                'nomor_antrian',
                'nama_lengkap',
                'email',
                'no_hp',
                'pekerjaan',
                'status',
                'created_at'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $filename = 'buku_tamu_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        $writer = new Writer();
        
        // Headers untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->openToBrowser($filename);
        
        // Header style
        $headerStyle = (new Style())->setFontBold();
        
        // Header row
        $headerRow = Row::fromValues([
            'ID', 'No Antrian', 'Nama Lengkap', 'Email', 'No HP',
            'Pekerjaan', 'Status', 'Tanggal Dibuat'
        ], $headerStyle);
        
        $writer->addRow($headerRow);
        
        // Data rows
        foreach ($guestBooks as $guest) {
            $row = Row::fromValues([
                $guest->id,
                $guest->nomor_antrian ?? '',
                $guest->nama_lengkap ?? '',
                $guest->email ?? '',
                $guest->no_hp ?? '',
                $guest->pekerjaan ?? '',
                $guest->status ?? '',
                $guest->created_at ? $guest->created_at->format('d/m/Y H:i:s') : ''
            ]);
            
            $writer->addRow($row);
        }
        
        $writer->close();
        exit;
    }
}