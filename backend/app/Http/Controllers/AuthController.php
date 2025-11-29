<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin_login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $identity = $data['username'];
        $query = filter_var($identity, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $identity)
            : User::where('name', $identity);

        $user = $query->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
        }

        $request->session()->put('admin', true);
        return redirect()->route('admin');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        return redirect()->route('admin.login');
    }
}
