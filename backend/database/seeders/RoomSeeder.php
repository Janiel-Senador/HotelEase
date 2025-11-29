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
            ['number' => '101', 'type' => 'standard', 'capacity' => 2, 'price' => 79.99, 'status' => 'available'],
            ['number' => '102', 'type' => 'standard', 'capacity' => 2, 'price' => 79.99, 'status' => 'available'],
            ['number' => '201', 'type' => 'deluxe', 'capacity' => 3, 'price' => 119.99, 'status' => 'available'],
            ['number' => '301', 'type' => 'suite', 'capacity' => 4, 'price' => 199.99, 'status' => 'maintenance'],
        ];

        foreach ($rooms as $r) {
            Room::create($r);
        }
    }
}
