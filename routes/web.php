<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('filament.staff.auth.login');
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
