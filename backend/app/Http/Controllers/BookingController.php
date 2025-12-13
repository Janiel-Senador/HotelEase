<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

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
            'payment_method' => 'nullable|string|max:50',
        ]);

        $booking = Booking::create($data);
        return response()->json($booking->load('room'), 201);
    }

    public function webCreate()
    {
        $rooms = Room::query()->orderByRaw("CASE type 
            WHEN 'Standard Room' THEN 0 
            WHEN 'Deluxe Room' THEN 1 
            WHEN 'Executive Suite' THEN 2 
            WHEN 'Premium Suite' THEN 3 
            WHEN 'Family Room' THEN 4 
            WHEN 'Penthouse Suite' THEN 5 
            ELSE 6 END")->get();
        return view('book', compact('rooms'));
    }

    public function webStore(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:100',
            'guest_email' => 'required|email',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_method' => 'required|string|in:card,arrival,ewallet',
            'notes' => 'nullable|string',
        ]);

        $data['status'] = 'pending';

        $booking = Booking::create($data);
        return response()->json(['id' => $booking->id]);
    }

    public function accept(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);
        return redirect()->route('admin')->with('status', 'Booking accepted');
    }

    public function cancel(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        return redirect()->route('admin')->with('status', 'Booking cancelled');
    }

    public function receipt(Booking $booking)
    {
        return view('receipt', ['booking' => $booking->load('room')]);
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'room_type' => 'nullable|string|max:50',
            'status' => 'nullable|string|in:pending,confirmed,cancelled,checked_in,checked_out',
            'guest_name' => 'nullable|string|max:100',
            'check_out_date' => 'nullable|date',
        ]);

        if (isset($data['status'])) {
            $booking->status = $data['status'];
        }
        if (isset($data['guest_name'])) {
            $booking->guest_name = $data['guest_name'];
        }
        if (isset($data['check_out_date'])) {
            $booking->check_out_date = $data['check_out_date'];
        }
        $booking->save();

        if (isset($data['room_type']) && $booking->room) {
            $booking->room->type = $data['room_type'];
            $booking->room->save();
        }

        return redirect()->route('admin.room_management');
    }

    public function adminDelete(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.room_management')->with('status', 'Deleted Successfully');
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

    public function exportHistoryDocx()
    {
        $accepted = Booking::whereIn('status', ['confirmed', 'checked_in'])->with('room')->orderByDesc('id')->limit(200)->get();
        $cancelled = Booking::where('status', 'cancelled')->with('room')->orderByDesc('id')->limit(200)->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addTitle('Booking History', 1);

        $section->addText('Accepted Bookings');
        $style = ['borderSize' => 6, 'borderColor' => '999999'];
        $table = $section->addTable($style);
        $table->addRow();
        foreach (['ID','Room Number','Room Type','Guest','Check-in','Check-out','Status'] as $h) { $table->addCell(2000)->addText($h); }
        foreach ($accepted as $b) {
            $table->addRow();
            $table->addCell()->addText((string)$b->id);
            $table->addCell()->addText((string)optional($b->room)->number);
            $table->addCell()->addText((string)optional($b->room)->type);
            $table->addCell()->addText((string)$b->guest_name);
            $table->addCell()->addText((string)$b->check_in_date);
            $table->addCell()->addText((string)$b->check_out_date);
            $table->addCell()->addText((string)$b->status);
        }

        $section->addTextBreak(1);
        $section->addText('Cancelled Bookings');
        $table2 = $section->addTable($style);
        $table2->addRow();
        foreach (['ID','Room Number','Room Type','Guest','Check-in','Check-out','Status'] as $h) { $table2->addCell(2000)->addText($h); }
        foreach ($cancelled as $b) {
            $table2->addRow();
            $table2->addCell()->addText((string)$b->id);
            $table2->addCell()->addText((string)optional($b->room)->number);
            $table2->addCell()->addText((string)optional($b->room)->type);
            $table2->addCell()->addText((string)$b->guest_name);
            $table2->addCell()->addText((string)$b->check_in_date);
            $table2->addCell()->addText((string)$b->check_out_date);
            $table2->addCell()->addText((string)$b->status);
        }

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $tmp = tempnam(sys_get_temp_dir(), 'history_');
        $file = $tmp . '.docx';
        $writer->save($file);
        $name = 'booking_history_' . now()->toDateString() . '.docx';
        return response()->download($file, $name)->deleteFileAfterSend(true);
    }

    public function exportHistoryDoc()
    {
        $accepted = Booking::whereIn('status', ['confirmed', 'checked_in'])->with('room')->orderByDesc('id')->limit(200)->get();
        $cancelled = Booking::where('status', 'cancelled')->with('room')->orderByDesc('id')->limit(200)->get();
        $html = '<html><head><meta charset="utf-8"><title>Booking History</title></head><body>';
        $html .= '<h1>Booking History</h1>';
        $html .= '<h2>Accepted Bookings</h2>';
        $html .= '<table border="1" cellpadding="6" cellspacing="0"><tr><th>ID</th><th>Room Number</th><th>Room Type</th><th>Guest</th><th>Check-in</th><th>Check-out</th><th>Status</th></tr>';
        foreach ($accepted as $b) {
            $html .= '<tr>'
                . '<td>' . e($b->id) . '</td>'
                . '<td>' . e(optional($b->room)->number) . '</td>'
                . '<td>' . e(optional($b->room)->type) . '</td>'
                . '<td>' . e($b->guest_name) . '</td>'
                . '<td>' . e($b->check_in_date) . '</td>'
                . '<td>' . e($b->check_out_date) . '</td>'
                . '<td>' . e($b->status) . '</td>'
                . '</tr>';
        }
        $html .= '</table>';
        $html .= '<h2>Cancelled Bookings</h2>';
        $html .= '<table border="1" cellpadding="6" cellspacing="0"><tr><th>ID</th><th>Room Number</th><th>Room Type</th><th>Guest</th><th>Check-in</th><th>Check-out</th><th>Status</th></tr>';
        foreach ($cancelled as $b) {
            $html .= '<tr>'
                . '<td>' . e($b->id) . '</td>'
                . '<td>' . e(optional($b->room)->number) . '</td>'
                . '<td>' . e(optional($b->room)->type) . '</td>'
                . '<td>' . e($b->guest_name) . '</td>'
                . '<td>' . e($b->check_in_date) . '</td>'
                . '<td>' . e($b->check_out_date) . '</td>'
                . '<td>' . e($b->status) . '</td>'
                . '</tr>';
        }
        $html .= '</table>';
        $html .= '</body></html>';
        $name = 'booking_history_' . now()->toDateString() . '.doc';
        return response($html, 200, [
            'Content-Type' => 'application/msword; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $name . '"'
        ]);
    }
}
