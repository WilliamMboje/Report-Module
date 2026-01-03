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
        Log::info("Generating PDF for report {$this->reportId} and user ");

        $report = AwarenessReport::findOrFail($this->reportId);
        // Get filtered data
        $providers = \App\Models\AwarenessReportProvider::getFilteredRows($report);
        $columns = $report->columns ?? ['Date', 'Mwananchi', 'Mkoa', 'Maelezo', 'Aina', 'Hali'];

        $pdf = PDF::loadView('reports.htmltopdf', compact('report', 'providers', 'columns'))
            ->setPaper('a4', count($columns) > 4 ? 'landscape' : 'portrait');

        // Unique filename per report & user
        $userId = 70 ?? 0; // if dispatching via queue, pass userId when dispatching

        $filename = "reports/report-{$report->id}-user-{$userId}-" . now()->timestamp . ".pdf";
//        Log::info("Generating PDF for report {$report->id} and user {$userId}");

        Storage::disk('local')->put($filename, $pdf->output());

        // Save path to DB
//        $report->pdf_path = $filename;
//        $report->save();
    }
}
