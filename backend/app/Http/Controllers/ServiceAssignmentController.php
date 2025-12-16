<?php

namespace App\Http\Controllers;

use App\Models\ServiceAssignment;
use App\Models\Staff;
use Illuminate\Http\Request;

class ServiceAssignmentController extends Controller
{
    public function index()
    {
        $assignments = ServiceAssignment::with(['guest','room','staff'])->orderByDesc('id')->paginate(20);
        $staff = Staff::orderBy('first_name')->get();
        return view('admin_staff_assignments', compact('assignments','staff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'request_type' => 'required|string|max:80',
        ]);
        $sa = new ServiceAssignment($data);
        $sa->status = 'open';
        $sa->save();
        return redirect()->back()->with('status','Service request created');
    }

    public function assign(Request $request, ServiceAssignment $assignment)
    {
        $data = $request->validate([
            'staff_id' => 'required|exists:staffs,id',
        ]);
        $staff = Staff::active()->find($data['staff_id']);
        if(!$staff){
            return redirect()->back()->with('status','Selected staff is inactive or not found');
        }
        $assignment->staff_id = $staff->id;
        $assignment->status = 'in_progress';
        $assignment->assigned_at = now();
        $assignment->save();
        return redirect()->back()->with('status','Request assigned');
    }

    public function updateStatus(Request $request, ServiceAssignment $assignment)
    {
        $data = $request->validate([
            'status' => 'required|string|in:open,in_progress,completed,cancelled',
        ]);
        $assignment->status = $data['status'];
        if($data['status']==='completed'){ $assignment->completed_at = now(); }
        $assignment->save();
        return redirect()->back()->with('status','Status updated');
    }
}

