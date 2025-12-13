<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestAdminController extends Controller
{
    public function activate(Guest $guest)
    {
        $guest->update(['is_active' => true]);
        return redirect()->route('admin')->with('status', 'Guest activated');
    }

    public function deactivate(Guest $guest)
    {
        $guest->update(['is_active' => false]);
        return redirect()->route('admin')->with('status', 'Guest deactivated');
    }

    public function update(Request $request, Guest $guest)
    {
        $data = $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'nullable|email',
            'phone_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
        ]);
        $guest->fill($data)->save();
        return redirect()->route('admin')->with('status', 'Guest updated');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('admin')->with('status', 'Guest deleted');
    }
}

