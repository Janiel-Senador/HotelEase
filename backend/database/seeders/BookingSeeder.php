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

        $room = Room::first();
        if ($room) {
            Booking::create([
                'room_id' => $room->id,
                'guest_name' => 'John Doe',
                'guest_email' => 'john@example.com',
                'check_in_date' => Carbon::today()->addDays(3),
                'check_out_date' => Carbon::today()->addDays(6),
                'status' => 'confirmed',
                'notes' => 'Late arrival',
            ]);
        }
    }
}
