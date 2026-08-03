<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'SZPC Admin',
            'email' => 'admin@ugv.edu.bd',
            'password' => 'password',
        ]);

        foreach ([
            ['name' => 'Follow-up', 'color' => 'warning'],
            ['name' => 'Paid', 'color' => 'success'],
            ['name' => 'VIP', 'color' => 'info'],
            ['name' => 'Issue', 'color' => 'danger'],
        ] as $tag) {
            Tag::query()->firstOrCreate(['name' => $tag['name']], $tag);
        }
    }
}
