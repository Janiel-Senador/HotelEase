<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::query()->delete();

        $rooms = Room::all();
        $names = [
            ['Alice Smith','alice@example.com'],
            ['Bob Johnson','bob@example.com'],
            ['Carol Lee','carol@example.com'],
            ['David Kim','david@example.com'],
            ['Eva Brown','eva@example.com'],
        ];

        $i = 0;
        foreach ($rooms as $room) {
            for ($j = 0; $j < 2; $j++) {
                $n = $names[$i % count($names)];
                $checkIn = Carbon::today()->addDays($i + $j + 1);
                $checkOut = (clone $checkIn)->addDays(2 + ($j % 2));
                Booking::create([
                    'room_id' => $room->id,
                    'guest_name' => $n[0],
                    'guest_email' => $n[1],
                    'check_in_date' => $checkIn,
                    'check_out_date' => $checkOut,
                    'status' => 'confirmed',
                    'notes' => null,
                ]);
                $i++;
            }
        }
    }
}
