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
    public function getRows(): array
    {
        $cacheKey = 'awareness_report_api_data_user_70';
        
        return cache()->remember($cacheKey, 3600, function () {
            $token = env('REPORTS_API_TOKEN');
            $payload = ["UserID" => 70];
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];

            $url = env('MOCLA_API_BASE_URL_PRODUCTION') . config('api.urls.getLAPConflictByUserID');

            try {
                $response = Http::withHeaders($headers)
                    ->withOptions(['curl' => [CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1]])
                    ->timeout(200)
                    ->post($url, $payload);

                if ($response->failed()) {
                    Log::error('Awareness Report API failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                    return [];
                }

                $json = $response->json();
                
                if (!isset($json['Conflict']) || empty($json['Conflict'])) {
                    return [];
                }

                return collect($json['Conflict'])->map(function ($item, $index) {
                    return [
                        'id'        => $index + 1,
                        'Date'      => $item['Date'] ?? '',
                        'Mwananchi' => $item['Mwananchi'] ?? '',
                        'Mkoa'      => $item['Mkoa'] ?? '',
                        'Maelezo'   => $item['Maelezo'] ?? '',
                        'Aina'      => $item['Aina'] ?? '',
                        'Hali'      => $item['Hali'] ?? '',
                    ];
                })->toArray();

            } catch (\Exception $e) {
                Log::error('Awareness Report API Exception', ['message' => $e->getMessage()]);
                return [];
            }
        });
    }

    public static function getFilteredRows(AwarenessReport $report)
    {
        $data = static::all();

        // Apply filters from DB
        $filters = $report->filters ?? [];
        foreach ($filters as $key => $value) {
            if (!is_null($value) && $value !== '') {
                $filterValue = strtoupper(trim($value));
                $data = $data->filter(fn($row) => strtoupper(trim($row->{$key} ?? '')) === $filterValue)->values();
            }
        }

        return $data;
    }
}
