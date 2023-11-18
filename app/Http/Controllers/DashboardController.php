<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = auth()->user();

        return inertia('Dashboard/Index', [
            'currentUser' => $currentUser,
        ]);
    }
}
