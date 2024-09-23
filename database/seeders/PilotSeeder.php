<?php

namespace Database\Seeders;

use App\Models\Pilot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PilotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pilot::factory()->count(10)->create();
    }
}
