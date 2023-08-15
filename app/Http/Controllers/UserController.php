<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageInfo;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        dd('coming');
    }
    public function dashboard(Request $request)
    {
        $packageInfo = PackageInfo::where('user_id', auth()->user()->id)->with('fixtures')->get();
        return view('pages.dashboard', compact('packageInfo'));
    }

    public function deletePackage(Request $request)
    {
        $package = PackageInfo::findOrFail($request->id);

        $package->fixtures()->delete();

        $package->delete();

        if($package)
        {
            return redirect()->back()->with('error', 'Delete Package Successfully.');
        }
    }

    public function getPackageData(Request $request)
    {
        $packageData = PackageInfo::where('id', $request->id)->with('fixtures')->get();

        return response()->json([
            'status' => 'success',
            'data' => $packageData,
            'message' => 'category data!'
        ], 200);
    }
}
