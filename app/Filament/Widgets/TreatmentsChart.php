<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TreatmentsChart extends ChartWidget
{
    protected static ?string $heading = 'Treatments 🐶';

    protected function getData(): array
    {
        $data = Trend::model(\App\Models\Treatment::class)
            ->between(
                start: now()->subYear(),
                end: now()
            )->perMonth()->count();
        return [
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
            'datasets' => [
                [
                    'label' => 'Treatments',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
