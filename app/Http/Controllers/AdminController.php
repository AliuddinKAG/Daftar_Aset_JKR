<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Component;
use App\Models\MainComponent;
use App\Models\SubComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Dashboard Overview
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_components' => Component::count(),
            'total_main_components' => MainComponent::count(),
            'total_sub_components' => SubComponent::count(),
        ];

        // Get user activity - users with component counts
        $userActivity = User::withCount([
            'components',
            'mainComponents', 
            'subComponents'
        ])->get();

        // Recent registrations
        $recentUsers = User::latest()->take(5)->get();
        $recentComponents = Component::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'userActivity', 'recentUsers', 'recentComponents'));
    }

    // ========== USER MANAGEMENT ==========
    
    public function users()
    {
        $users = User::withCount([
            'components',
            'mainComponents',
            'subComponents'
        ])->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,user',
            'is_active' => 'boolean',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimum 6 karakter',
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User berjaya ditambah!');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,user',
            'is_active' => 'boolean',
        ]);

        $data = [
            'username' => $request->username,
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
            ->with('success', 'User berjaya dikemaskini!');
    }

    public function deleteUser(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak boleh delete akaun sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User berjaya dihapuskan!');
    }

    // View user's components
    public function viewUserComponents(User $user)
    {
        $components = Component::where('user_id', $user->id)
            ->with('mainComponents.subComponents')
            ->paginate(10);

        return view('admin.users.components', compact('user', 'components'));
    }
}