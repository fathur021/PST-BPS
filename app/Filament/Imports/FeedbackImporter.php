<?php

namespace App\Filament\Imports;

use App\Models\Feedback;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class FeedbackImporter extends Importer
{
    protected static ?string $model = Feedback::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama_lengkap')
                ->rules(['max:255']),
            ImportColumn::make('petugasPst.name'),
            ImportColumn::make('frontOffice.name'),
            ImportColumn::make('kepuasan_petugas_pst')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('kepuasan_petugas_front_office')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('kepuasan_sarana_prasarana')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('kritik_saran'),
        ];
    }

    public function resolveRecord(): ?Feedback
    {
        // return Feedback::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Feedback();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your feedback import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
