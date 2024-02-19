<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LibraryFixture;

class LibraryController extends Controller
{
    //

    public function libraryFixture(Request $request)
    {
        $libraryFixtures = LibraryFixture::get();
        return view('pages.library', compact('libraryFixtures'));
    }


    public function saveLibraryData(Request $request)
    {
       
        $fixtures = $request->all();

        $inputPdfPath = null;
        $inputImgPath = null;

        if (isset($fixtures['fixtures']['imageFile']) && !empty($fixtures['fixtures']['imageFile']) && $fixtures['fixtures']['imageFile'] != 'undefined') {
            $uploadedImgFile = $fixtures['fixtures']['imageFile'];
            $image_name = time() . '_' . $uploadedImgFile->getClientOriginalName();
            $image_name = str_replace(' ', '_', $image_name);
            $image_path = public_path('/files');
            // $inputImgPath = $image_path . '/' . $image_name;
            $inputImgPath = $image_name;
            $uploadedImgFile->move($image_path, $image_name);
        }

        // dd($fixtures['fixtures']['pdfFile']);

        if ($fixtures['fixtures']['pdfFile'] != "null") {
            $uploadedFile = $fixtures['fixtures']['pdfFile'];
            $name = time() . '_' . $uploadedFile->getClientOriginalName();
            $name = str_replace(' ', '_', $name);
            $path = public_path('/files');
            $inputPdfPath = $path . '/' . $name;
            $uploadedFile->move($path, $name);
        }
        
        LibraryFixture::create([
            'part_number' => $fixtures['fixtures']['part_no'],
            'pdf_path' => $inputPdfPath ?? null,
            'image_path' => $inputImgPath ?? null,
            'manufacturer' => $fixtures['fixtures']['manufacturer'],
            'lamp' => $fixtures['fixtures']['lamp'],
            'voltage' => $fixtures['fixtures']['voltage'],
            'dimming' => $fixtures['fixtures']['dimming'],
            'description' => $fixtures['fixtures']['description']
        ]);


        return response()->json(['status' => true, 'message' => 'Success', 'data' => []]);

    }

    public function deleteLibraryData(Request $request)
    {
        $id = $request->input('id');

        $libraryFixture = LibraryFixture::find($id);

        if ($libraryFixture) {
            $imagePath = $libraryFixture->image_path;

            if (!empty($imagePath)) {
                $absolutePath = $imagePath;

                if (file_exists($absolutePath)) {
                    unlink($absolutePath);
                }
            }

            $deleted = $libraryFixture->delete();

            if ($deleted) {
                return response()->json(['status' => 'success', 'message' => 'Fixture Deleted Successfully', 'data' => []]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Error deleting fixture', 'data' => []], 500);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Fixture not found', 'data' => []], 404);
        }
    }

    public function getLibraryData(Request $request)
    {

        $ids = $request->all();

        $getLibrarySelectedData = [];

        foreach ($ids as $key => $value) {
            
            $libraryData = libraryFixture::where('id', $value)->get();
            
            $getLibrarySelectedData = array_merge($getLibrarySelectedData, $libraryData->toArray());

        }

        return response()->json(['status' => 'success', 'message' => 'Fixture data', 'data' => $getLibrarySelectedData]);

    }

    public function getSpecificLibraryData(Request $request) 
    {
        $data = libraryFixture::where('id',  $request->id)->first();

        return response()->json(['status' => 'success', 'message' => 'Library data', 'data' => $data]);
    }

    
}
