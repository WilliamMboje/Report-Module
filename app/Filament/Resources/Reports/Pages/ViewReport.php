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
                    $columns = $record->columns ?? [];
                    $csv = \League\Csv\Writer::createFromString('');
                    $csv->insertOne($columns);

                    // Use chunking if possible, but since we are using relationship/attribute it's already a collection.
                    // For better optimization, we could query directly here with chunking.
                    \App\Models\LegalAidProvider::query()
                        ->filtered($record->filters ?? [])
                        ->select(array_merge(['id'], $columns))
                        ->chunk(100, function ($providers) use ($csv, $columns) {
                            foreach ($providers as $provider) {
                                $row = [];
                                foreach ($columns as $column) {
                                    $row[] = $provider->$column;
                                }
                                $csv->insertOne($row);
                            }
                        });

                    return response()->streamDownload(function () use ($csv) {
                        echo $csv->toString();
                    }, "report-{$record->id}.csv");
                }),
            \Filament\Actions\Action::make('generatePdf')
                ->label('Generate PDF (Pro)')
                ->icon('heroicon-o-cpu-chip')
                ->color('info')
                ->action(function (\App\Models\Report $record) {
                    \App\Jobs\GenerateReportPdf::dispatch($record->id, auth()->id() ?? 0);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('PDF generation started')
                        ->body('This may take a few minutes for large reports. You will see the download button when it is ready.')
                        ->success()
                        ->send();
                }),
            \Filament\Actions\Action::make('downloadReadyPdf')
                ->label('Download Ready PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->visible(function (\App\Models\Report $record) {
                    $userId = auth()->id() ?? 0;
                    return \Illuminate\Support\Facades\Storage::disk('local')->exists("reports/report-{$record->id}-user-{$userId}.pdf");
                })
                ->url(function (\App\Models\Report $record) {
                    $userId = auth()->id() ?? 0;
                    $filename = "reports/report-{$record->id}-user-{$userId}.pdf";
                    return route('pdf.download', ['path' => $filename]);
                })
                ->openUrlInNewTab(),
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
