<?php

namespace App\Filament\Imports;

use App\Models\GuestBook;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class GuestBookImporter extends Importer
{
    protected static ?string $model = GuestBook::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama_lengkap')
                ->rules(['max:255']),
            ImportColumn::make('jenis_kelamin'),
            ImportColumn::make('usia')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('pekerjaan')
                ->rules(['max:255']),
            ImportColumn::make('jurusan')
                ->rules(['max:255']),
            ImportColumn::make('asal_universitas')
                ->rules(['max:255']),
            ImportColumn::make('asal')
                ->rules(['max:255']),
            ImportColumn::make('asal_universitas_lembaga')
                ->rules(['max:255']),
            ImportColumn::make('organisasi_nama_perusahaan_kantor')
                ->rules(['max:255']),
            ImportColumn::make('no_hp')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('tujuan_kunjungan'),
            ImportColumn::make('tujuan_kunjungan_lainnya')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?GuestBook
    {
        // return GuestBook::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new GuestBook();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your guest book import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
