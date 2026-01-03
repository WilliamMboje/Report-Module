<?php

namespace App\Filament\Widgets\Simulation;

use Filament\Widgets\ChartWidget;

class SimulationAwarenessReachChart extends ChartWidget
{
    protected ?string $heading = 'Awareness Reach';
    protected static ?int $sort = 12;
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
                    'label' => 'Reach',
                    'data' => [80000, 95000, 120000, 110000, 135000, 150000, 140000, 125000, 120000, 110000, 115000, 123000],
                    'borderColor' => '#3b82f6',
                    'fill' => true,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
