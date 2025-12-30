<?php

namespace App\Filament\Resources\FeedbackResource\Widgets;

use App\Models\Feedback;
use App\Models\Role;
use App\Models\RoleUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FeedbackOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        $stats = [];

        if ($user->hasRole('pst')) {
            // Calculate the average rating for the logged-in 'petugas pst'
            $myRatingPelayanan = Feedback::where('petugas_pst', $user->id)->avg('kepuasan_petugas_pst');
            $stats[] = Stat::make('Rating Pelayanan Petugas PST', $myRatingPelayanan ? number_format($myRatingPelayanan, 2) . '/5' : '0/5');
        } elseif ($user->hasRole('front-office')) {
            $myRatingPelayanan = Feedback::where('front_office', $user->id)->avg('kepuasan_petugas_front_office');
            $stats[] = Stat::make('Rating Pelayanan Petugas Front Office', $myRatingPelayanan ? number_format($myRatingPelayanan, 2) . '/5' : '0/5');
        }

        // Calculate the average ratings for all feedbacks
        $totalRatingPelayananPST = Feedback::avg('kepuasan_petugas_pst');
        $totalRatingPelayananFrontOffice = Feedback::avg('kepuasan_petugas_front_office');
        $totalRatingSaranaPrasarana = Feedback::avg('kepuasan_sarana_prasarana');

        $stats[] = Stat::make('Total Rating Pelayanan Petugas PST', $totalRatingPelayananPST ? number_format($totalRatingPelayananPST, 2) . '/5' : '0/5');
        $stats[] = Stat::make('Total Rating Pelayanan Petugas Front Office', $totalRatingPelayananFrontOffice ? number_format($totalRatingPelayananFrontOffice, 2) . '/5' : '0/5');
        $stats[] = Stat::make('Total Rating Sarana Prasarana', $totalRatingSaranaPrasarana ? number_format($totalRatingSaranaPrasarana, 2) . '/5' : '0/5');

        return $stats;
    }
}

