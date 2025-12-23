<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log slow database queries in local/dev to help diagnose performance issues
        if (config('app.debug') || app()->environment('local')) {
            DB::listen(function ($query) {
                // $query->sql, $query->bindings, $query->time (ms)
                $time = $query->time ?? 0;
                if ($time > 200) { // log queries slower than 200ms
                    Log::warning('Slow query detected', [
                        'sql' => $query->sql,
                        'bindings' => $query->bindings,
                        'time_ms' => $time,
                    ]);
                }
            });
        }
    }
}
