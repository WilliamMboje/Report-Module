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

class ViewAwarenessReport1 extends ViewRecord
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
                    // Dispatch queue job
                    GenerateConflictReportPdf::dispatch($record->id);
                    // Notify user
                    Notification::make()
                            ->title('PDF generation started')
                            ->success()
                            ->send();
                    //                });
//WITHOUt JOBS
//            Action::make('downloadPdf')
//                ->label('Download PDF')
//                ->icon('heroicon-o-document-text')
//                ->action(function () {
//                    $record = $this->record;
//                    $providers = \App\Models\AwarenessReportProvider::all();
////                    Log::info($providers);
//                    $columns = $record->columns;



//                    $orientation = count($columns) > 4 ? 'landscape' : 'portrait';

//                    $html = view('reports.htmltopdf', compact(
//                        'record',
//                        'providers',
//                        'columns'
//                    ))->render();
//
//                    $pdf = SnappyPdf::loadHTML($html)
//                        ->setPaper('a4', $orientation)
//                        ->setOption('margin-top', 10)
//                        ->setOption('margin-bottom', 10);
//
//                    return response()->streamDownload(
//                        fn () => print $pdf->output(),
//                        "report-{$record->id}.pdf"
//                    );
//dom pdf
//                    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
//                        'reports.pdf',
//                        compact('record', 'providers', 'columns')
//                    )->setPaper('a4', $orientation);
//                    return response()->streamDownload(
//                        fn() => print $pdf->output(),
//                        "report-{$record->id}.pdf"
//                    );



                }),
            //WITH JOBS ALSO
            Action::make('downloadReadyPdf')
                ->label('Download Ready PDF')
                ->color('success') //  makes the button green

                ->icon('heroicon-o-document-text')
                ->url(function () {
                    $record = $this->record;
                    $userId = 70; // Current user

                    $files = Storage::disk('local')->files('reports');
//                    Log::info($files);

                    // Find the latest file for this user and report
                    $pdfFile = collect($files)
                        ->filter(fn($f) => str_contains($f, "report-{$record->id}-user-{$userId}-"))
                        ->sortByDesc(fn($f) => Storage::disk('local')->lastModified($f))
                        ->first();

//                    if (!$pdfFile) {
//                        Notification::make()
//                            ->title('No PDF ready for download yet.')
//                            ->warning()
//                            ->send();
//                        return null;
//                    }
                    // Stream the PDF from private storage
//                    return response()->download(storage_path("app/{$pdfFile}"));
                })
                ->disabled(function () {
                    $record = $this->record;
                    $userId = 70;
                    $files = Storage::disk('local')->files('reports');
//Log::info($files);
                    return !collect($files)
                        ->contains(fn($f) => str_contains($f, "report-{$record->id}-user-{$userId}-"));
                })
                ->openUrlInNewTab()

        ];
    }
}
