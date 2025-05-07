<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $listings = $request->user()->role !== 'suspended' ? $request->user()->listings()->latest()->paginate(10) : null;
        $msg = session('msg');
        return inertia('Dashboard', compact('listings', 'msg'));
    }
}
