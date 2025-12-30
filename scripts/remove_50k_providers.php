<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\LegalAidProvider;
use Illuminate\Support\Facades\DB;

echo "Counting providers...\n";
$total = LegalAidProvider::count();
echo "Total before: $total\n";

$ids = LegalAidProvider::orderBy('id','desc')->limit(50000)->pluck('id')->toArray();
echo "Will delete: " . count($ids) . "\n";

if (count($ids) > 0) {
    // delete in chunks to avoid long queries
    $chunks = array_chunk($ids, 1000);
    $deleted = 0;
    foreach ($chunks as $chunk) {
        LegalAidProvider::whereIn('id', $chunk)->delete();
        $deleted += count($chunk);
        echo "Deleted chunk, total deleted: $deleted\n";
    }
}

echo "Done.\n";
echo "Total after: " . LegalAidProvider::count() . "\n";
