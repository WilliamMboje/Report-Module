<?php

namespace App\Filament\Widgets\Simulation;

use Filament\Widgets\Widget;

class SimulationFilterWidget extends Widget
{
    protected static ?int $sort = 10; # Below default widgets
    protected int | string | array $columnSpan = 'full'; # Full width 
    protected string $view = 'filament.widgets.simulation-filter-widget';

    public static function canView(): bool
    {
        // Change this to false to disable the widget
        return true;
    }
}
