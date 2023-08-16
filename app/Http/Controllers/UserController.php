<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageInfo;
use App\Models\User;
use Str;

class UserController extends Controller
{
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
            return redirect()->back()->with('success', 'Delete Package Successfully.');
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

    public function updateProfile(Request $request)
    {
        if($request->isMethod('post'))
        {

            $uploadedImageFile = $request->profile_img;

            if ($uploadedImageFile) {

                $randomString = Str::random(20);

                $name = $randomString.'.'.$uploadedImageFile->getClientOriginalExtension();

                $uploadedImageFile->move(public_path('user_images'), $name);
                $imagePath = asset('public/user_images') . '/' . $name;
            }

            $updateData = [
                'name' => $request->name,
            ];

            if (!empty($request->password)) {
                $updateData['password'] = bcrypt($request->password);
            }

            if (!empty($imagePath)) {
                $updateData['profile_img'] = $imagePath;
            }

            $updateUser = User::where('id', auth()->user()->id)->update($updateData);

            if($updateUser)
            {
                return redirect()->back()->with('success', 'Update profile successfully.');
            }
        }

        return view('pages.profile');
    }
}
