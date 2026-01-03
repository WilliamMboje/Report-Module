<?php

//namespace App\Jobs;

//use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Foundation\Queue\Queueable;
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Models\AwarenessReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateConflictReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reportId;
    protected $userId;

    public function __construct($reportId, $userId)
    {
        $this->reportId = $reportId;
        $this->userId = $userId;
    }

    public function handle()
    {
        ini_set('memory_limit', '1G');
        set_time_limit(600);
        Log::info("Generating PDF for report {$this->reportId} and user ");

        $report = AwarenessReport::findOrFail($this->reportId);

        // Get filtered data
        $providers = \App\Models\AwarenessReportProvider::getFilteredRows($report);

        $columns = $report->columns ?? ['Date', 'Mwananchi', 'Mkoa', 'Maelezo', 'Aina', 'Hali'];

        $snappyBinary = config('snappy.pdf.binary');
        $orientation = count($columns) > 4 ? 'landscape' : 'portrait';

        if ($snappyBinary && file_exists($snappyBinary)) {
            Log::info("Using Snappy for conflict report {$this->reportId}");
            $pdf = PDF::loadView('reports.htmltopdf', compact('report', 'providers', 'columns'))
                ->setPaper('a4', $orientation);
            $output = $pdf->output();
        } else {
            Log::warning("Snappy binary not found. Falling back to DomPDF for conflict report {$this->reportId}");
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.htmltopdf', compact('report', 'providers', 'columns'))
                ->setPaper('a4', $orientation);
            $output = $pdf->output();
        }

        $filename = "reports/report-{$report->id}-user-{$this->userId}-" . now()->timestamp . ".pdf";

        Storage::disk('local')->put($filename, $output);

        // Save path to DB
//        $report->pdf_path = $filename;
//        $report->save();
    }
}
