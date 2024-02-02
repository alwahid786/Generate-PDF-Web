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
            $inputImgPath = $image_path . '/' . $image_name;
            $uploadedImgFile->move($image_path, $image_name);
        }

        if ($fixtures['fixtures']['pdfFile']) {
            $uploadedFile = $fixtures['fixtures']['pdfFile'];
            $name = time() . '_' . $uploadedFile->getClientOriginalName();
            $name = str_replace(' ', '_', $name);
            $path = public_path('/files');
            $inputPdfPath = $path . '/' . $name;
            $uploadedFile->move($path, $name);
        }
        
        LibraryFixture::create([
            'type' => $fixtures['fixtures']['fixtureType'],
            'part_number' => $fixtures['fixtures']['part_no'],
            'pdf_path' => $inputPdfPath ?? null,
            'image_path' => $inputImgPath ?? null,
        ]);


        return response()->json(['status' => true, 'message' => 'Success', 'data' => []]);

    }
    
}
