<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Carlist;
class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display admin dashboard
     */
//     public function dashboard()
// {
//     if (!auth()->user()->is_admin) {
//         abort(403, 'Unauthorized action.');
//     }
//     return view('admin.dashboard');
// }
    public function dashboard()
    {
        return view('admin.dashboard', [
            'userCount' => User::count(),
            'adminCount' => User::where('is_admin', true)->count(),
            'recentUsers' => User::latest()->take(5)->get(),
                'cars' => Carlist::all() // Get all cars

        ]);
    }

    /**
     * Display list of users
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user edit form
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)],
            'is_admin' => ['boolean'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
               ->with('success', 'User updated successfully');
    }

    /**
     * Delete user
     */
    public function destroyUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself!');
        }

        $user->delete();
        return redirect()->route('admin.users')
               ->with('success', 'User deleted successfully');
    }

    /**
     * Show admin settings
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update admin settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'maintenance_mode' => ['boolean'],
        ]);

        // If you're using the 'qcod/laravel-app-settings' package
        if (function_exists('setting')) {
            setting()->set($validated);
            setting()->save();
        } else {
            // Alternative storage method (database, config, etc.)
            // For example, using the database:
            \App\Models\Setting::updateOrCreate(
                ['key' => 'site_name'],
                ['value' => $validated['site_name']]
            );
            
            \App\Models\Setting::updateOrCreate(
                ['key' => 'maintenance_mode'],
                ['value' => $validated['maintenance_mode']]
            );
        }

        return back()->with('success', 'Settings updated successfully');
    }
}