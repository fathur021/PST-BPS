<?php

namespace App\Filament\Widgets;

use App\Models\Feedback;
use App\Models\User;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TopStaffWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static string $view = 'filament.widgets.top-staff-widget';

    public function getViewData(): array
    {
        $start = $this->filters['startDate'] ?? now()->subMonths(3);
        $end = $this->filters['endDate'] ?? now();

        $topRatingPetugasPst = Feedback::query()
            ->select('petugas_pst', DB::raw('AVG(kepuasan_petugas_pst) as average_kepuasan'))
            ->whereBetween('updated_at', [Carbon::parse($start), Carbon::parse($end)])
            ->whereNotNull('kepuasan_petugas_pst')
            ->groupBy('petugas_pst')
            ->orderByDesc('average_kepuasan')
            ->first();

        $topPetugasPST = $topRatingPetugasPst ? User::find($topRatingPetugasPst->petugas_pst) : null;
        Log::info($topPetugasPST);
        $topRatingFrontOffice = Feedback::query()
            ->select('front_office', DB::raw('AVG(kepuasan_petugas_front_office) as average_kepuasan'))
            ->whereBetween('updated_at', [Carbon::parse($start), Carbon::parse($end)])
            ->whereNotNull('kepuasan_petugas_front_office')
            ->groupBy('front_office')
            ->orderByDesc('average_kepuasan')
            ->first();

        $topFrontOffice = $topRatingFrontOffice ? User::find($topRatingFrontOffice->front_office) : null;

        return [
            'topPetugasPST' => $topPetugasPST,
            'ratingTopPST' => $topRatingPetugasPst,
            'topFrontOffice' => $topFrontOffice,
            'ratingTopFrontOffice' => $topRatingFrontOffice,
        ];
    }
 
}

