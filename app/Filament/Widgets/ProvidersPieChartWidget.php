<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ProvidersPieChartWidget extends Widget
{
    protected string $view = 'filament.widgets.providers-pie-chart';

    public static function canView(): bool
    {
        return false;
    }

    public array $labels = [];
    public array $data = [];
    public int $total = 0;
    public int $paid = 0;
    public int $unpaid = 0;

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

        $this->total = (int) ($stats['total'] ?? ($this->data[0] + $this->data[1]));
        $this->paid = (int) ($stats['paid'] ?? $this->data[0]);
        $this->unpaid = (int) ($stats['unpaid'] ?? $this->data[1]);
    }
}
