<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::query()->with('room')->orderByDesc('id')->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:100',
            'guest_email' => 'required|email',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'status' => 'nullable|string|in:confirmed,cancelled,checked_in,checked_out',
            'notes' => 'nullable|string',
        ]);

        $booking = Booking::create($data);
        return response()->json($booking->load('room'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return $booking->load('room');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'room_id' => 'sometimes|required|exists:rooms,id',
            'guest_name' => 'sometimes|required|string|max:100',
            'guest_email' => 'sometimes|required|email',
            'check_in_date' => 'sometimes|required|date',
            'check_out_date' => 'sometimes|required|date|after:check_in_date',
            'status' => 'sometimes|nullable|string|in:confirmed,cancelled,checked_in,checked_out',
            'notes' => 'nullable|string',
        ]);

        $booking->update($data);
        return response()->json($booking->load('room'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->noContent();
    }
}
