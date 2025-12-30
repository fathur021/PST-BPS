<?php

namespace App\Filament\Exports;

use App\Models\GuestBook;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class GuestBookExporter extends Exporter
{
    protected static ?string $model = GuestBook::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nama_lengkap'),
            ExportColumn::make('jenis_kelamin'),
            ExportColumn::make('usia'),
            ExportColumn::make('pekerjaan'),
            ExportColumn::make('jurusan'),
            ExportColumn::make('asal_universitas'),
            ExportColumn::make('asal'),
            ExportColumn::make('asal_universitas_lembaga'),
            ExportColumn::make('organisasi_nama_perusahaan_kantor'),
            ExportColumn::make('no_hp'),
            ExportColumn::make('email'),
            ExportColumn::make('provinsi.name'),
            ExportColumn::make('kota.name'),
            ExportColumn::make('alamat'),
            ExportColumn::make('tujuan_kunjungan'),
            ExportColumn::make('tujuan_kunjungan_lainnya'),
            ExportColumn::make('status'),
            ExportColumn::make('petugasPst.name'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your guest book export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            Log::info('gagal');
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
