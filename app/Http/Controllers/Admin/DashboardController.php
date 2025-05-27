<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'users' => User::count(),
                'revenue' => Order::sum('amount'),
            ]
        ]);
    }
}
