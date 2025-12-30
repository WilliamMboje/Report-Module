<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Log;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {

        return [
            EditAction::make(),
            \Filament\Actions\Action::make('download')
                ->label('Download CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function (\App\Models\Report $record) {
                    Log::info($record);
                    $providers = $record->providers;
                    $columns = $record->columns ?? [];

                    $csv = \League\Csv\Writer::createFromString('');
                    $csv->insertOne($columns);

                    foreach ($providers as $provider) {
                        Log::info($provider);
                        $row = [];
                        foreach ($columns as $column) {
                            $row[] = $provider->$column;
                        }
                        $csv->insertOne($row);
                    }

                    return response()->streamDownload(function () use ($csv) {
                        echo $csv->toString();
                    }, "report-{$record->id}.csv");
                }),
            \Filament\Actions\Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-text')
                ->action(function (\App\Models\Report $record) {
                    $providers = $record->providers;
                    $columns = $record->columns ?? [];
                    
                    if (empty($columns)) {
                        $columns = ['name']; // Default
                    }

                    // Use landscape orientation if more than 4 columns
                    $orientation = count($columns) > 4 ? 'landscape' : 'portrait';

                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', [
                        'record' => $record,
                        'providers' => $providers,
                        'columns' => $columns,
                    ])->setPaper('a4', $orientation);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, "report-{$record->id}.pdf");
                }),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            \App\Filament\Resources\Reports\Widgets\ReportProvidersTable::class,
        ];
    }

    public function getFooterWidgetsColumns(): int|array
    {
        return 1;
    }
}
