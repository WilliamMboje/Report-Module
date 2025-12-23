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
