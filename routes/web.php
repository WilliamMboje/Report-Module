<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/conflicts/export', function () {
    $data = app(\App\Filament\Pages\Conflicts::class)->getConflicts();
    $filename = "conflicts.csv";

    $handle = fopen($filename, 'w+');
    if ($data->isNotEmpty()) {
        fputcsv($handle, array_keys($data->first()));
    }

    foreach ($data as $row) {
        fputcsv($handle, $row);
    }

    fclose($handle);

    return response()->download($filename)->deleteFileAfterSend(true);
})->name('conflicts.export');
Route::get('/pdf-download', function (Illuminate\Http\Request $request) {
    $path = $request->query('path');
    
    if (!$path || !Illuminate\Support\Facades\Storage::disk('local')->exists($path)) {
        abort(404);
    }

    // Basic security: only allow downloads from 'reports' directory
    if (!str_starts_with($path, 'reports/')) {
        abort(403);
    }

    return Illuminate\Support\Facades\Storage::disk('local')->download($path);
})->middleware(['auth'])->name('pdf.download');
