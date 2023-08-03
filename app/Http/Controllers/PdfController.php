<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageType;
use App\Models\PackageInfo;
use Spatie\PdfToImage\Pdf;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Exception;
use Imagick;

class PdfController extends Controller
{
    // Create PDF Page View 
    public function createPdfPage(Request $request)
    {
        $packageTypes = PackageType::get();
        return view('pages.create-pdf', compact('packageTypes'));
    }

    // Preview PDF Function 
    public function previewPdf(Request $request)
    {
        $fixtures = $request->fixtures;
        foreach ($fixtures as $fixture) {
            $uploadedFile  = $fixture['pdfFile'];
            if ($uploadedFile && $uploadedFile->isValid()) {
                try {
                    $name = time() . $uploadedFile->getClientOriginalName();
                    $path = public_path('/files');
                    if (!is_dir($path)) {
                        mkdir($path, 777, true);
                    }
                    $uploadedFile->move($path, $name);
                    $file = public_path('/files') . '/' .  $name;
                    $image = new Imagick();
                    $image->pingImage($file);
                    // echo $image->getNumberImages();

                    dd($image->getNumberImages());
                } catch (PdfDoesNotExist $e) {
                    dump("Error: PDF does not exist or is not accessible.");
                } catch (Exception $e) {
                    dump("Error processing PDF: " . $e->getMessage());
                }
            }
        }
        dd($request->all());
        $package = json_decode($request->input('package'));

        // First Create Package Info 
        $packageType = new PackageInfo();
        $packageType->package_name = $package->projectName;
        $packageType->vision_reference = $package->referenceNo;
        $packageType->package_type_id = $package->packageType;
        $packageType->save();

        // Get Fixtures 
    }
    private function countPages($path)
    {
        $pdftext = file_get_contents($path);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        return $num;
    }
}
