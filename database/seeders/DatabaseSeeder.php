<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminEmail = trim((string) config('seeding.admin.email', ''));
        $adminPassword = (string) config('seeding.admin.password', '');

        if ($adminEmail === '' || trim($adminPassword) === '') {
            $this->command?->warn(
                'Admin account was not seeded. Set ADMIN_EMAIL and ADMIN_PASSWORD to create it.'
            );
        } elseif (filter_var($adminEmail, FILTER_VALIDATE_EMAIL) === false) {
            $this->command?->warn(
                'Admin account was not seeded. ADMIN_EMAIL must be a valid email address.'
            );
        } else {
            User::query()->firstOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => 'admin',
                    'password' => Hash::make($adminPassword),
                    'role' => 'admin',
                ]
            );
        }

        // Tambahkan pemanggilan BukuSeeder di sini
        $this->call([
            BukuSeeder::class,
        ]);
    }
}
