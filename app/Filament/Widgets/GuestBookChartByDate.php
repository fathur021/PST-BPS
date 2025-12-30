<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\GuestBook;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;


class GuestBookChartByDate extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Total Kunjungan PST per Bulan';
    protected function getData(): array
    {
        $start = $this->filters['startDate'];
        $end = $this->filters['endDate'];

        $data = Trend::model(GuestBook::class)
            ->between(
                start: $start ? Carbon::parse($start) : now()->subMonths(6),
                end: $end ? Carbon::parse($end) : now(),
            )
            ->perMonth()
            ->count();
            
        return [
            'datasets' => [
                [ 
                    'label' => 'Jumlah buku tamu',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
