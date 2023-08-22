<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AdminController extends Controller
{
    public function adminDashboard(Request $request)
    {
        return view('pages.admin.dashboard');
    }

    public function userRequest(Request $request)
    {

        return view('pages.admin.user_request');
    }
}
