<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Component;
use App\Models\MainComponent;
use App\Models\SubComponent;
use App\Models\Sistem;
use App\Models\Subsistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'admin_users' => User::admins()->count(),
            'regular_users' => User::regularUsers()->count(),
            
            'total_components' => Component::count(),
            'active_components' => Component::aktif()->count(),
            
            'total_main_components' => MainComponent::count(),
            'total_sub_components' => SubComponent::count(),
            
            'total_sistem' => Sistem::count(),
            'active_sistem' => Sistem::active()->count(),
            
            'total_subsistem' => Subsistem::count(),
            'active_subsistem' => Subsistem::active()->count(),
        ];

        // Get recent users (last 5)
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        // Get user activity summary (components registered by each user)
        $userActivity = DB::table('users')
            ->leftJoin('components', 'components.created_at', '>=', DB::raw('users.created_at'))
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.role',
                DB::raw('COUNT(DISTINCT components.id) as total_components')
            )
            ->groupBy('users.id', 'users.name', 'users.username', 'users.role')
            ->orderBy('total_components', 'desc')
            ->take(10)
            ->get();

        // Get sistem statistics
        $sistemStats = Sistem::withCount('subsistems')->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'userActivity', 'sistemStats'));
    }

    /**
     * Get user activity details
     */
    public function userActivity()
    {
        // Get detailed component count per user
        $users = User::all()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role,
                'department' => $user->department,
                'is_active' => $user->is_active,
                'created_at' => $user->created_at,
                'last_login_at' => $user->last_login_at,
                // Count components - this is approximate based on created_at timestamps
                'total_components' => Component::where('created_at', '>=', $user->created_at)->count(),
            ];
        });

        return view('admin.user-activity', compact('users'));
    }

    /**
     * Show system statistics
     */
    public function systemStats()
    {
        // Component statistics by user
        $componentsByUser = User::select('users.*')
            ->selectRaw('(SELECT COUNT(*) FROM components WHERE components.created_at >= users.created_at) as components_count')
            ->orderBy('components_count', 'desc')
            ->get();

        // Components by month
        $componentsByMonth = Component::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->take(12)
            ->get();

        return view('admin.system-stats', compact('componentsByUser', 'componentsByMonth'));
    }
}