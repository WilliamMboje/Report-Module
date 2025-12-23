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
        // Use a dedicated cache key to avoid colliding with other widgets
        $stats = cache()->get('providers_pie_stats');

        if (! is_array($stats) || ! array_key_exists('paid', $stats)) {
            $total = \App\Models\LegalAidProvider::count();
            $paid = \App\Models\LegalAidProvider::where('paid', true)->count();
            $unpaid = max(0, $total - $paid);

            $stats = compact('total', 'paid', 'unpaid');
            cache()->put('providers_pie_stats', $stats, 300);
        }

        $this->labels = ['Paid', 'Unpaid'];
        $this->data = [(int) ($stats['paid'] ?? 0), (int) ($stats['unpaid'] ?? 0)];
    }
}
