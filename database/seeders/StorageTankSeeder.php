<?php

namespace Database\Seeders;

use App\Models\StorageTank;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StorageTankSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        StorageTank::factory(10)->create([
            'user_id' => $user->id
        ]);
    }
}
