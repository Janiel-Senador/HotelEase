<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::where('is_staff', true)->orderByDesc('id')->get();
        return view('admin_staff', compact('staff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->is_staff = true;
        $user->is_active = true;
        $user->save();
        return redirect()->back()->with('status', 'Staff created');
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'nullable|string|max:100',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'is_active' => 'nullable|boolean',
        ]);
        if (isset($data['name'])) $user->name = $data['name'];
        if (isset($data['email'])) $user->email = $data['email'];
        if (!empty($data['password'])) $user->password = Hash::make($data['password']);
        if (isset($data['is_active'])) $user->is_active = (bool) $data['is_active'];
        $user->is_staff = true;
        $user->save();
        return redirect()->back()->with('status', 'Staff updated');
    }

    public function deactivate(User $user)
    {
        // prevent deactivating default admin account
        if (strtolower($user->name) === 'admin') {
            return redirect()->back()->with('status', 'Cannot deactivate admin');
        }
        $user->is_active = false;
        $user->save();
        return redirect()->back()->with('status', 'Staff deactivated');
    }

    public function activate(User $user)
    {
        $user->is_active = true;
        $user->save();
        return redirect()->back()->with('status', 'Staff activated');
    }

    public function destroy(User $user)
    {
        if (strtolower($user->name) === 'admin') {
            return redirect()->back()->with('status', 'Cannot delete admin');
        }
        $user->delete();
        return redirect()->back()->with('status', 'Staff deleted');
    }
}
