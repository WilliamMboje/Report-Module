<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Log;
use Sushi\Sushi;
use Illuminate\Support\Facades\Http;

class AwarenessReportProvider extends Model
{
    use Sushi;


    protected $schema = [
//        'id' => 'integer',        // just an index
//        'date' => 'string',       // e.g., case date
//        'mwananchi' => 'string',  // user/citizen
//        'mkoa' => 'string',       // region
//        'maelezo' => 'string',    // description
//        'aina' => 'string',       // type
//        'hali' => 'string',       // status

        'id' => 'integer',
        'Maelezo' => 'string',
        'Mkoa' => 'string',
        'Aina' => 'string',
        'Hali' => 'string',
        'Mwananchi' => 'string',
        'Date' => 'string',
    ];
//WITH JOBS
    public static function getFilteredRows(AwarenessReport $report)
    {
        $token = env('REPORTS_API_TOKEN');
        $payload = ["UserID" => 70];
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ];

        $url = env('MOCLA_API_BASE_URL_PRODUCTION') . config('api.urls.getLAPConflictByUserID');

        $response = \Illuminate\Support\Facades\Http::withHeaders($headers)
            ->withOptions(['curl' => [CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1]])
            ->timeout(200)
            ->post($url, $payload)
            ->json();

        if (!isset($response['Conflict']) || empty($response['Conflict'])) {
            return collect();
        }

        $data = collect($response['Conflict']);

        // Apply filters from DB
        $filters = $report->filters ?? [];
        foreach ($filters as $key => $value) {
            if (!is_null($value) && $value !== '') {
                $filterValue = strtoupper(trim($value));
                $data = $data->filter(fn($row) => strtoupper(trim($row[$key] ?? '')) === $filterValue)->values();
            }
        }

        return $data->map(function ($item, $index) {
            return (object)[
                'id'        => $index + 1,
                'Date'      => $item['Date'] ?? '',
                'Mwananchi' => $item['Mwananchi'] ?? '',
                'Mkoa'      => $item['Mkoa'] ?? '',
                'Maelezo'   => $item['Maelezo'] ?? '',
                'Aina'      => $item['Aina'] ?? '',
                'Hali'      => $item['Hali'] ?? '',
            ];
        });
    }

    //WITHOUT JOBS
//    public function getRows(): array
//    {
//        $token = env('REPORTS_API_TOKEN');
//        $payload = [
//            "UserID" => 70,
//        ];
//        $headers = [
//            'Authorization' => 'Bearer ' . $token,
//            'Accept'        => 'application/json',
//        ];
//        set_time_limit(300);
//        ini_set('memory_limit', '1024M');
//
//        $url = env('MOCLA_API_BASE_URL_PRODUCTION') . config('api.urls.getLAPConflictByUserID');
//
//        $response = Http::withHeaders($headers)->withOptions([
//        'curl' => [
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//        ],
//    ])->timeout(200)->post($url, $payload)->json();
//
//        if (!isset($response['Conflict']) || empty($response['Conflict'])) {
//            return [];
//        }
//        //  API DATA (THIS is what we filter)
//        $data = collect($response['Conflict']);
//
//        Log::info($data);
//
//        //  GET FILTERS FROM DB
//        $report  = AwarenessReport::latest()->first();
//        $filters = $report?->filters ?? [];
//
//        // APPLY FILTERS CORRECTLY
//        foreach ($filters as $key => $value) {
//            if (!is_null($value) && $value !== '') {
//                $filterValue = strtoupper(trim($value));
//
//                $data = $data->filter(function ($row) use ($key, $filterValue) {
//                    return strtoupper(trim($row[$key] ?? '')) === $filterValue;
//                })->values();
//            }
//        }
//
//        //  MAP FILTERED DATA TO SUSHI ROWS
//        return $data->map(function ($item, $index) {
//            return [
//                'id'        => $index + 1,
//                'Date'      => $item['Date'] ?? '',
//                'Mwananchi' => $item['Mwananchi'] ?? '',
//                'Mkoa'      => $item['Mkoa'] ?? '',
//                'Maelezo'   => $item['Maelezo'] ?? '',
//                'Aina'      => $item['Aina'] ?? '',
//                'Hali'      => $item['Hali'] ?? '',
//            ];
//        })->toArray();
//    }

}
