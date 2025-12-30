<?php

namespace App\Filament\Resources\GuestBookResource\Widgets;

use App\Models\GuestBook;
use App\Models\Role;
use App\Models\RoleUser;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class GuestBookOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        
        if ($user->hasRole('pst')) {
            // Get GuestBooks for the logged-in 'petugas pst'
            $query = GuestBook::where('petugas_pst', $user->id);
            $doneGuestBooks = $query->count();
        } else {
            // Get all GuestBooks
            $query = GuestBook::query();
            $doneGuestBooks = GuestBook::where('status', 'done')->count();
        }

        // Get the counts
        $totalGuestBooks = $query->count();
        $inProgressGuestBooks = $query->where('status', 'inProgress')->count();
        $doneGuestBooks = GuestBook::where('status', 'done')->count();

        // bug ketika $query->where('status', 'done')->count(); menghasilkan nilai 1

        return [
            Stat::make('Total', $totalGuestBooks)
                ->color('primary'),
            Stat::make('In Progress', $inProgressGuestBooks)
                ->color('warning'),
            Stat::make('Done', $doneGuestBooks)
                ->color('success'),
        ];
    }
}
