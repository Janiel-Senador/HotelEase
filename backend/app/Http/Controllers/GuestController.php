<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuestController extends Controller
{
    public function showLogin()
    {
        return view('guest_login');
    }

    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $request->session()->regenerate();
                return redirect()->intended(route('home'))->with('status', 'Signed in');
            }

            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        } catch (\Throwable $e) {
            return back()->withErrors(['email' => 'Authentication unavailable: database driver missing'])->withInput();
        }
    }

    public function showRegister()
    {
        return view('guest_register');
    }

    public function register(Request $request)
    {
        $default = config('database.default');
        $hasDriver = false;
        if ($default === 'sqlite') { $hasDriver = \extension_loaded('pdo_sqlite'); }
        elseif ($default === 'mysql' || $default === 'mariadb') { $hasDriver = \extension_loaded('pdo_mysql'); }
        elseif ($default === 'pgsql') { $hasDriver = \extension_loaded('pdo_pgsql'); }
        elseif ($default === 'sqlsrv') { $hasDriver = \extension_loaded('pdo_sqlsrv'); }

        $emailRule = $hasDriver ? 'required|email|unique:users,email|unique:guests,email' : 'required|email';

        try {
            $data = $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => $emailRule,
                'password' => ['required','string','min:6','regex:/^(?=.*[^A-Za-z0-9])(?=(?:.*\\d){4,}).{6,}$/'],
                'phone_number' => 'nullable|string|max:50',
                'address' => 'nullable|string|max:255',
            ], [
                'password.regex' => 'Password must include at least one special character and at least 4 digits',
            ]);

            if (!$hasDriver) {
                return back()->withErrors(['email' => 'Database driver not installed. Enable pdo_sqlite or pdo_mysql.'])->withInput();
            }

            $user = User::create([
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $username = strstr($data['email'], '@', true) ?: ($data['first_name'] . $data['last_name']);

            \App\Models\Guest::create([
                'user_id' => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'] ?? null,
                'address' => $data['address'] ?? null,
                'username' => $username,
                'password' => Hash::make($data['password']),
                'is_active' => true,
            ]);

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('home')->with('status', 'Account created');
        } catch (\Throwable $e) {
            return back()->withErrors(['email' => 'Registration unavailable: database driver missing'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function myBookings(Request $request)
    {
        $email = Auth::user()->email;
        $bookings = Booking::query()->where('guest_email', $email)->with('room')->orderByDesc('id')->paginate(20);
        return view('my_bookings', compact('bookings'));
    }
}
