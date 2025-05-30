<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\seed;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'peserta']);
        Role::create(['name' => 'pimpinan']);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123')
        ])->assignRole('admin');

         $this->call([
             AdministrativeAreaSeeder::class
         ]);
    }
}
