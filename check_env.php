<?php
ob_start();
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Loaded Extensions: " . implode(', ', get_loaded_extensions()) . "\n";
echo "Sqlite3 Extension: " . (extension_loaded('sqlite3') ? 'Enabled' : 'Disabled') . "\n";
echo "PDO Sqlite: " . (extension_loaded('pdo_sqlite') ? 'Enabled' : 'Disabled') . "\n";

$binary = getenv('WKHTML_PDF_BINARY');
echo "WKHTML_PDF_BINARY: " . ($binary ?: 'Not defined') . "\n";
if ($binary && file_exists($binary)) {
    echo "Binary exists at: $binary\n";
} elseif ($binary) {
    echo "Binary NOT FOUND at: $binary\n";
}

$commonPaths = [
    'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe',
    'C:\Program Files (x86)\wkhtmltopdf\bin\wkhtmltopdf.exe',
    'C:\xampp\wkhtmltopdf\bin\wkhtmltopdf.exe',
];

foreach ($commonPaths as $path) {
    if (file_exists($path)) {
        echo "Found potential binary at: $path\n";
    }
}
$output = ob_get_clean();
echo $output;
file_put_contents('check_results.txt', $output);
