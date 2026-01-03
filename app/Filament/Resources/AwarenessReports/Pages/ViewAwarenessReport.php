<?php

namespace App\Filament\Resources\AwarenessReports\Pages;

use App\Filament\Resources\AwarenessReports\AwarenessReportResource;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\GenerateConflictReportPdf;
use Illuminate\Support\Facades\Storage;

class ViewAwarenessReport extends ViewRecord
{
    protected static string $resource = AwarenessReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadCsv')
                ->label('Download CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $record = $this->record; //AwarenessReport DB model
                    $providers = \App\Models\AwarenessReportProvider::all(); // Fetch all API data
                    $columns = $record->columns;
                    $csv = \League\Csv\Writer::createFromString('');
                    $csv->insertOne($columns);
                    foreach ($providers as $provider) {

                        $csv->insertOne(
                            collect($columns)->map(fn($col) => $provider->{$col} ?? '')->toArray()
                        );
                    }
                    return response()->streamDownload(
                        fn() => print $csv->toString(),
                        "report-{$record->id}.csv"
                    );
                }),
            //WITH JOBS
            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-text')
                ->action(function ()  {
                    $record = $this->record;

                    // Dispatch queue job with current user ID
                    GenerateConflictReportPdf::dispatch($record->id, auth()->id() ?? 70);

// Notify user
                        Notification::make()
                            ->title('PDF generation started')
                            ->success()
                            ->send();
                }),
            //WITH JOBS ALSO
            Action::make('downloadReadyPdf')
                ->label('Download Ready PDF')
                ->color('success') //  makes the button green
                ->icon('heroicon-o-document-text')
                ->url(function () {
                    $record = $this->record;
                    $userId = auth()->id() ?? 70;

                    $files = Storage::disk('local')->files('reports');

                    // Find the latest file for this user and report
                    $pdfFile = collect($files)
                        ->filter(fn($f) => str_contains($f, "report-{$record->id}-user-{$userId}-"))
                        ->sortByDesc(fn($f) => Storage::disk('local')->lastModified($f))
                        ->first();

                    if (!$pdfFile) {
                        return null;
                    }
                    
                    return route('pdf.download', ['path' => $pdfFile]);
                })
                ->visible(function () {
                    $record = $this->record;
                    $userId = auth()->id() ?? 70;
                    $files = Storage::disk('local')->files('reports');

                    return collect($files)
                        ->contains(fn($f) => str_contains($f, "report-{$record->id}-user-{$userId}-"));
                })
                ->openUrlInNewTab()
        ];
    }
}
