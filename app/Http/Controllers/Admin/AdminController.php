<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageInfo;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class AdminController extends Controller
{

    private $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {

        $this->adminRepository = $adminRepository;

    }

    public function adminDashboard(Request $request)
    {

        $packageInfo = PackageInfo::with('fixtures')->with('user')->get();
        return view('pages.admin.dashboard', compact('packageInfo'));
    }

    public function userRequest(Request $request)
    {

        $users = $this->adminRepository->getUser();

        return view('pages.admin.user_request', ['users' => $users]);

    }

    public function updateStatus(Request $request)
    {

        $updateStatus = $this->adminRepository->updateStatus($request->id);

        if($updateStatus) {
            return response()->json([
                'status' => true,
            ]);
        }
    }
}
