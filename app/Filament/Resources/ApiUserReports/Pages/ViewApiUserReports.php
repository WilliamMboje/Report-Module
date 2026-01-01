<?php

namespace App\Filament\Resources\ApiUserReports\Pages;

use App\Filament\Resources\ApiUserReports\ApiUserReportResource;
use App\Jobs\GenerateConflictReportPdf;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewApiUserReports extends ViewRecord
{
    protected static string $resource = ApiUserReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadCsv')
                ->label('Download CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    $record = $this->record; //AwarenessReport DB model
                    $providers = \App\Models\ApiUserReportProvider::all(); // Fetch all API data
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

            Action::make('downloadPdf')
                ->label('Download PDF')
                ->icon('heroicon-o-document-text')
                ->action(function () {
                    $record = $this->record;
                    $providers = \App\Models\ApiUserReportProvider::all();
//                    Log::info($providers);
                    $columns = $record->columns;

                    $orientation = count($columns) > 4 ? 'landscape' : 'portrait';

                    $html = view('reports.htmltopdf', compact(
                        'record',
                        'providers',
                        'columns'
                    ))->render();
//
                    $pdf = SnappyPdf::loadHTML($html)
                        ->setPaper('a4', $orientation)
                        ->setOption('margin-top', 10)
                        ->setOption('margin-bottom', 10);

                    return response()->streamDownload(
                        fn () => print $pdf->output(),
                        "report-{$record->id}.pdf"
                    );
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
        ];
    }

}
