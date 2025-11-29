<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::query()->delete();

        $rooms = [
            ['number' => 'STD-001', 'type' => 'Standard Room', 'capacity' => 2, 'price' => 1500, 'status' => 'available'],
            ['number' => 'DLX-001', 'type' => 'Deluxe Room', 'capacity' => 2, 'price' => 1760, 'status' => 'available'],
            ['number' => 'EXE-001', 'type' => 'Executive Suite', 'capacity' => 3, 'price' => 6000, 'status' => 'available'],
            ['number' => 'PRM-001', 'type' => 'Premium Suite', 'capacity' => 3, 'price' => 3700, 'status' => 'available'],
            ['number' => 'FAM-001', 'type' => 'Family Room', 'capacity' => 4, 'price' => 1100, 'status' => 'available'],
            ['number' => 'PNT-001', 'type' => 'Penthouse Suite', 'capacity' => 4, 'price' => 9800, 'status' => 'available'],
        ];

        foreach ($rooms as $r) {
            Room::create($r);
        }
    }
}
