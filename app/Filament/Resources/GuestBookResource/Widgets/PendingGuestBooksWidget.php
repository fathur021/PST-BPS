<?php

namespace App\Filament\Resources\GuestBookResource\Widgets;

use App\Models\GuestBook;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use App\Repositories\Interface\GuestbookRepositoryInterface;

class PendingGuestBooksWidget extends BaseWidget
{
    // use CanSpanColumns;
    protected static ?string $heading = 'Buku Tamu Menunggu Persetujuan';
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return GuestBook::query()->where('status', 'pending');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label('ID'),
            TextColumn::make('nama_lengkap')->label('Name'),
            TextColumn::make('email')->label('Email'),
            TextColumn::make('created_at')->label('Tanggal Pengisian')->date(),
            TextColumn::make('tujuan_kunjungan')->label('Tujuan Kunjungan'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('accept')
                ->label('Accept')
                ->action(function (GuestBook $record) {
                    $this->accept($record->id);
                })
                ->color('success'),
        ];
    }

    public function accept($id)
    {
        $userId = Auth::id();
        $guestbookRepository = app(GuestbookRepositoryInterface::class);
        
        return $guestbookRepository->accept($id, $userId);

        $this->emit('guestBookAccepted');
    }

    protected function getListeners(): array
    {
        return [
            'guestBookAccepted' => 'refreshTable',
        ];
    }

    public function refreshTable()
    {
        $this->emit('refreshWidget');
    }
    
}
