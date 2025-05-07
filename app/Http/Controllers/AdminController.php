<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('listings')
            ->filter(request(['search', 'user_role']))
            ->paginate(10)
            ->withQueryString();
        $msg = session('msg');

        return inertia('Admin/AdminDashboard', compact('users', 'msg'));
    }

    public function role(Request $request, User $user)
    {
        Gate::authorize('modifyRole', $user);
        $request->validate(['role' => 'string|required']);
        $user->update(['role' => $request->role]);

        return redirect()->route('admin.index')->with('msg', "User role chage to $request->role successfully!");
    }

    public function show(User $user)
    {
        $listings = $user
            ->listings()
            ->filter(request(['search', 'disapproved']))
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $msg = session('msg');

        return inertia('Admin/UserPage', compact('user', 'listings', 'msg'));
    }

    public function approve(Listing $listing)
    {
        Gate::authorize('approve', $listing);
        $listing->update(['approved' => !$listing->approved]);
        return redirect()->back()->with('msg', "Listing " . ($listing->approved ? "approved" : "unapproved") . " successfully!");
    }
}
