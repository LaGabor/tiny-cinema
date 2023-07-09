<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Seat::truncate();

        Seat::create([
            'id' => 1,
        ]);

        Seat::create([
            'id' => 2,
        ]);
    }
}
