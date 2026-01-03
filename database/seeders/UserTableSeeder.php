<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Designation;
use App\Models\Employee;
use App\Models\Institution;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Administrator',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'email' => 'supports@sheria.go.tz',
            'remember_token' => Str::random(10),
        ]);

    }
}
