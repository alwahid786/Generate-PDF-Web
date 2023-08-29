<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageInfo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Exception;

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

        $updateStatus = $this->adminRepository->updateStatus($request->id, $request->status);

        if($updateStatus) {
            return response()->json([
                'status' => true,
            ]);
        }
    }


    public function deleteUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);

            // Delete the fixtures associated with the user's packages
            $user->packages()->each(function ($package) {
                $package->fixtures()->delete();
            });
            $user->packages()->delete();

            $user->delete();

            if ($user) {
                return redirect()->back()->with('success', 'Profile Deleted Successfully.');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function updatePassword(Request $request){
        
        try {
            $user = User::findOrFail($request->u_id);
            $user->password = bcrypt($request->password);
            
            $user->save();
            return redirect()->back()->with('success', 'Password Updated Successfully.');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
