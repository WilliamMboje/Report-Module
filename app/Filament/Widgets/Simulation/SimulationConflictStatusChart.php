<?php

namespace App\Filament\Widgets\Simulation;

use Filament\Widgets\ChartWidget;

class SimulationConflictStatusChart extends ChartWidget
{
    protected ?string $heading = 'Conflict Status';
    protected static ?int $sort = 13;
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
                    'data' => [69.2, 24.8],
                    'backgroundColor' => ['#22c55e', '#f97316'],
                ],
            ],
            'labels' => ['Closed', 'Ongoing'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
