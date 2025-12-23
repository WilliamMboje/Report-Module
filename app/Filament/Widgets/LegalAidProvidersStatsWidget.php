<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LegalAidProvidersStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return cache()->remember('dashboard_stats', 600, function () {
            $total = \App\Models\LegalAidProvider::count();
            $paid = \App\Models\LegalAidProvider::where('paid', true)->count();
            $unpaid = \App\Models\LegalAidProvider::where('paid', false)->count();

            return [
                Stat::make('Total Providers', $total)
                    ->description('Total legal aid providers registered')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('primary'),
                Stat::make('Paid', $paid)
                    ->description('Providers who have paid')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),
                Stat::make('Unpaid', $unpaid)
                    ->description('Providers who have not paid')
                    ->descriptionIcon('heroicon-m-x-circle')
                    ->color('danger'),
            ];
        });
    }
}
