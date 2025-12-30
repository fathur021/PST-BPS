<?php

namespace App\Filament\Resources\FeedbackPengaduanResource\Widgets;

use App\Models\FeedbackPengaduan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FeedbackPengaduanOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $stats = [];

        $totalRatingPelayananPengaduan = FeedbackPengaduan::avg('kepuasan_petugas_pengaduan');
        $totalRatingSaranaPrasaranaPengaduan = FeedbackPengaduan::avg('kepuasan_sarana_prasarana_pengaduan');

        $stats[] = Stat::make('Total Rating Pelayanan Pengaduan', $totalRatingPelayananPengaduan ? number_format($totalRatingPelayananPengaduan, 2) . '/5' : '0/5');
        $stats[] = Stat::make('Total Rating Sarana Prasarana Pengaduan', $totalRatingSaranaPrasaranaPengaduan ? number_format($totalRatingSaranaPrasaranaPengaduan, 2) . '/5' : '0/5');

        return $stats;
    }
}

