<?php

namespace App\Filament\Widgets\Simulation;

use Filament\Widgets\ChartWidget;

class SimulationConflictsByTypeChart extends ChartWidget
{
    protected ?string $heading = 'Conflicts by Type';
    protected static ?int $sort = 11;
    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        // Change this to false to disable the widget
        return true;
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Conflicts',
                    'data' => [12500, 21000, 15000, 26000, 18000, 22000],
                    'backgroundColor' => [
                        '#3b82f6', // Land
                        '#22c55e', // Domestic
                        '#6366f1', // Business
                        '#eab308', // Labor
                        '#ec4899', // Malezi
                        '#a855f7', // Mirathi
                    ],
                ],
            ],
            'labels' => ['Land', 'Domestic', 'Business', 'Labor', 'Malezi ya Watoto', 'Mirathi'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
