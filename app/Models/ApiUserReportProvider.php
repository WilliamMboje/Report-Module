<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Sushi\Sushi;

class ApiUserReportProvider extends Model
{
    use Sushi;
    protected $schema = [
        'id' => 'integer',
        'FirstName' => 'string',
        'LastName' => 'string',
        'Phone' => 'string',
        'Email' => 'string',
        'RoleName' => 'string',
        'isBlocked' => 'string',
    ];



    //WITHOUT JOBS
    public function getRows(): array
    {
        // Fetch data from stored procedure
        $results = DB::connection('sqlsrv_lsms')->select('EXEC uspGetUserListWithRolePortal');

        // Convert objects to arrays for easier filtering
        $data = collect(array_map(fn($item) => (array) $item, $results));

        Log::info($data);

        // Get filters from latest AwarenessReport
        $report  = AwarenessReport::latest()->first();
        $filters = $report?->filters ?? [];

        // Apply filters
        foreach ($filters as $key => $value) {
            if (!is_null($value) && $value !== '') {
                $filterValue = strtoupper(trim($value));

                $data = $data->filter(function ($row) use ($key, $filterValue) {
                    return strtoupper(trim($row[$key] ?? '')) === $filterValue;
                })->values();
            }
        }

        // Map filtered data to rows
        return $data->map(function ($item, $index) {
            return [
                'id'        => $index + 1,
                'FirstName' => $item['FirstName'] ?? '',
                'LastName'  => $item['LastName'] ?? '',
                'Phone'     => $item['Phone'] ?? '',
                'Email'     => $item['Email'] ?? '',
                'RoleName'  => $item['RoleName'] ?? '',
                'isBlocked' => $item['isBlocked'] ?? '',
                'Hali'      => $item['Hali'] ?? '',
            ];
        })->toArray();
    }

}
