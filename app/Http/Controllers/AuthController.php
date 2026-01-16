<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login request using USERNAME
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:6',
        ], [
            'username.required' => 'Username diperlukan',
            'password.required' => 'Kata laluan diperlukan',
            'password.min' => 'Kata laluan sekurang-kurangnya 6 aksara',
        ]);

        // Check if user exists by username
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return back()->withErrors([
                'username' => 'Username tidak dijumpai dalam sistem.',
            ])->withInput($request->only('username'));
        }

        // Check if account is active
        if (!$user->isActive()) {
            return back()->withErrors([
                'username' => 'Akaun anda tidak aktif. Sila hubungi pentadbir.',
            ])->withInput($request->only('username'));
        }

        // Attempt login using username
        $remember = $request->has('remember');
        
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();

            // Update last login
            Auth::user()->updateLastLogin();

            // Redirect based on role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
            } else {
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau kata laluan tidak tepat.',
        ])->withInput($request->only('username'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berjaya log keluar.');
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Handle change password request
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Kata laluan semasa diperlukan',
            'new_password.required' => 'Kata laluan baru diperlukan',
            'new_password.min' => 'Kata laluan baru sekurang-kurangnya 6 aksara',
            'new_password.confirmed' => 'Kata laluan baru tidak sepadan',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata laluan semasa tidak tepat.',
            ]);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('dashboard')
            ->with('success', 'Kata laluan berjaya dikemaskini!');
    }
}