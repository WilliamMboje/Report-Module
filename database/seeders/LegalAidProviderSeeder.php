<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalAidProvider;

class LegalAidProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 50000;
        $batch = 1000; // create in batches to avoid memory/time spikes
        $iterations = (int) ceil($total / $batch);

        for ($i = 0; $i < $iterations; $i++) {
            $count = min($batch, $total - $i * $batch);
            LegalAidProvider::factory()->count($count)->create();
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LegalAidProvider;

class LegalAidProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LegalAidProvider::factory()->count(200)->create();
    }
}
