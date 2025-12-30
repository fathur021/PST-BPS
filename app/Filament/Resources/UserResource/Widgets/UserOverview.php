<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends BaseWidget
{
    
    protected function getStats(): array
    {
        return [
            Stat::make('Admin', User::role('admin')->count()),
            Stat::make('Petugas PST', User::role('pst')->count()),
            Stat::make('Front Office', User::role('front-office')->count()),
        ];
    }
}