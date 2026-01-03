<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use App\Models\Report;
use App\Models\LegalAidProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GenerateReportPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600; // 10 minutes

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
        Log::info("Starting background PDF generation for report {$this->reportId} (User: {$this->userId})");

        $report = Report::findOrFail($this->reportId);
        $columns = $report->columns ?? ['name'];
        
        // Fetch data using the same filtered logic
        $providers = LegalAidProvider::query()
            ->filtered($report->filters ?? [])
            ->select(array_merge(['id'], $columns))
            ->get();

        $orientation = count($columns) > 4 ? 'landscape' : 'portrait';

        $snappyBinary = config('snappy.pdf.binary');
        
        if ($snappyBinary && file_exists($snappyBinary)) {
            Log::info("Using Snappy (wkhtmltopdf) for report {$this->reportId}");
            $pdf = PDF::loadView('reports.pdf', [
                'record' => $report,
                'providers' => $providers,
                'columns' => $columns,
            ])->setPaper('a4', $orientation)
              ->setOption('margin-top', 10)
              ->setOption('margin-bottom', 10);
            $output = $pdf->output();
        } else {
            Log::warning("Snappy binary not found or not configured. Falling back to DomPDF for report {$this->reportId}. Note: This may be slow for large datasets.");
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', [
                'record' => $report,
                'providers' => $providers,
                'columns' => $columns,
            ])->setPaper('a4', $orientation);
            $output = $pdf->output();
        }

        $filename = "reports/report-{$report->id}-user-{$this->userId}.pdf";
        
        // Ensure directory exists
        if (!Storage::disk('local')->exists('reports')) {
            Storage::disk('local')->makeDirectory('reports');
        }

        Storage::disk('local')->put($filename, $output);

        Log::info("Finished background PDF generation for report {$this->reportId}. Saved to {$filename}");
    }
}
