<?php

namespace App\Filament\Exports;

use App\Models\FormPengaduan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class FormPengaduanExporter extends Exporter
{
    protected static ?string $model = FormPengaduan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nama_lengkap'),
            ExportColumn::make('alamat'),
            ExportColumn::make('pekerjaan'),
            ExportColumn::make('no_hp'),
            ExportColumn::make('email'),
            ExportColumn::make('rincian_informasi'),
            ExportColumn::make('tujuan_penggunaan_informasi'),
            ExportColumn::make('cara_memperoleh_informasi'),
            ExportColumn::make('cara_mendapatkan_salinan_informasi'),
            ExportColumn::make('bukti_identitas_diri_path'),
            ExportColumn::make('dokumen_pernyataan_keberatan_atas_permohonan_informasi_path'),
            ExportColumn::make('dokumen_permintaan_informasi_publik_path'),
            ExportColumn::make('tanda_tangan'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your form pengaduan export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
