<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Room::query()->orderBy('number')->paginate(20);
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
        $limit = (int) config('hotel.room_limit', 50);
        if (Room::count() >= $limit) {
            return response()->json([
                'message' => 'Room limit reached',
                'limit' => $limit,
            ], 422);
        }
        $data = $request->validate([
            'number' => ['required','regex:/^\\d+$/','unique:rooms,number'],
            'type' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $room = Room::create($data);
        if ($request->expectsJson()) {
            return response()->json($room, 201);
        }
        return redirect()->back()->with('status', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return $room->load('bookings');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'number' => ['sometimes','required','regex:/^\\d+$/','unique:rooms,number,' . $room->id],
            'type' => 'sometimes|required|string|max:50',
            'capacity' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|nullable|string|in:available,occupied,maintenance',
            'description' => 'nullable|string',
        ]);

        $room->update($data);
        if ($request->expectsJson()) {
            return response()->json($room);
        }
        return redirect()->back()->with('status', 'Saved');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->back()->with('status', 'Deleted Successfully');
    }
}
