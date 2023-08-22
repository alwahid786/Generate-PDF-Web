<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminDashboard(Request $request)
    {
        return view('pages.admin.dashboard');
    }
}
