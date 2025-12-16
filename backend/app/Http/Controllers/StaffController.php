<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::orderByDesc('id')->get();
        return view('admin_staff', compact('staff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:staffs,email',
            'username' => 'required|string|max:100|unique:staffs,username',
            'role' => 'required|string|in:Front Desk,Housekeeping,Maintenance,Manager',
        ]);
        $s = new Staff($data);
        $s->is_active = true;
        $s->save();
        return redirect()->back()->with('status', 'Staff created');
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'nullable|email|unique:staffs,email,' . $staff->id,
            'username' => 'nullable|string|max:100|unique:staffs,username,' . $staff->id,
            'role' => 'nullable|string|in:Front Desk,Housekeeping,Maintenance,Manager',
            'is_active' => 'nullable|boolean',
        ]);
        foreach ($data as $k => $v) {
            if ($v !== null && $v !== '') { $staff->$k = $v; }
        }
        $staff->save();
        return redirect()->back()->with('status', 'Staff updated');
    }

    public function deactivate(Staff $staff)
    {
        $staff->is_active = false;
        $staff->save();
        return redirect()->back()->with('status', 'Staff deactivated');
    }

    public function activate(Staff $staff)
    {
        $staff->is_active = true;
        $staff->save();
        return redirect()->back()->with('status', 'Staff activated');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->back()->with('status', 'Staff deleted');
    }
}
