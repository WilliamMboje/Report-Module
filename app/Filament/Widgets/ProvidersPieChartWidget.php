<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ProvidersPieChartWidget extends Widget
{
    protected string $view = 'filament.widgets.providers-pie-chart';

    public array $labels = [];
    public array $data = [];

    public function mount(): void
    {
        $stats = cache()->remember('dashboard_stats', 600, function () {
            $total = \App\Models\LegalAidProvider::count();
            $paid = \App\Models\LegalAidProvider::where('paid', true)->count();
            $unpaid = max(0, $total - $paid);

            return compact('total', 'paid', 'unpaid');
        });

        $this->labels = ['Paid', 'Unpaid'];
        $this->data = [(int) $stats['paid'], (int) $stats['unpaid']];
    }
}
