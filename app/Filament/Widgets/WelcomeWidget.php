<?php

namespace App\Filament\Widgets;

use App\Models\GuestBook;
use App\Models\Feedback;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class WelcomeWidget extends Widget
{
    use InteractsWithPageFilters;
    protected static string $view = 'filament.widgets.welcome-widget';
    protected static ?int $navigationSort = 1;


    public function getViewData(): array
    {
        $user = auth()->user();
        $userId = $user->id;
        $userRole = $user->getRoleNames()->first();

        // Define the date range
        $start = $this->filters['startDate'] ?? now()->subMonths(3);
        $end = $this->filters['endDate'] ?? now();

        // Fetch done guest books within the date range
        $doneGuestBooks = GuestBook::where('petugas_pst', $userId)
            ->where('status', 'done')
            ->whereBetween('updated_at', [Carbon::parse($start), Carbon::parse($end)])
            ->count();

        // Fetch feedback rating within the date range
        $feedbackRating = Feedback::where('petugas_pst', $userId)
        ->whereBetween('updated_at', [Carbon::parse($start), Carbon::parse($end)])
            ->avg('kepuasan_petugas_pst');

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $userRole,
            'doneGuestBooks' => $doneGuestBooks,
            'feedbackRating' => number_format($feedbackRating, 2),
        ];

        return $data;
    }
}

