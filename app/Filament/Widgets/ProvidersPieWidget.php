<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ProvidersPieWidget extends Widget
{
    protected string $view = 'filament.widgets.pie-providers';

    public array $labels = [];
    public array $data = [];

    protected function mount(): void
    {
        $stats = cache()->remember('providers_pie_stats', 300, function () {
            $total = \App\Models\LegalAidProvider::count();
            $paid = \App\Models\LegalAidProvider::where('paid', true)->count();
            $unpaid = max(0, $total - $paid);

            return compact('total', 'paid', 'unpaid');
        });

        $this->labels = ['Paid', 'Unpaid'];
        $this->data = [(int) $stats['paid'], (int) $stats['unpaid']];
    }
}
