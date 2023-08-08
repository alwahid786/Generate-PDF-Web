<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageType;
use App\Models\PackageInfo;
use App\Models\Fixtures;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Exception;
use Imagick;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        // Save Package First
        $package = json_decode($request->input('package'));

        // First Create Package Info
        $packageType = new PackageInfo();
        $packageType->package_name = $package->projectName;
        $packageType->vision_reference = $package->referenceNo;
        $packageType->package_type_id = $package->packageType;
        $packageType->save();

        // Then Loop Through Every Fixture to Save()
        $fixtures = $request->fixtures;
        foreach ($fixtures as $fixture) {
            $uploadedFile = $fixture['pdfFile'];
            if ($uploadedFile && $uploadedFile->isValid()) {
                $name = time() . $uploadedFile->getClientOriginalName();
                $path = public_path('/files');
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $uploadedFile->move($path, $name);
                $filePath = $path . '/' . $name;
            } else {
                return response()->json(['status' => false, 'message' => 'Error: File is Invalid!']);
            }
            $fixtureData = new Fixtures();
            $fixtureData->package_type_id = $packageType->id;
            $fixtureData->pdf_path = $filePath;
            $fixtureData->type = $fixture['fixtureType'];
            $fixtureData->part_number = $fixture['part_no'];
            $fixtureData->save();
        }

        // Prevent Data at last for response
        return response()->json(['status' => true, 'message' => 'Success', 'data' => $packageType->id]);
    }
    private function countPages($path)
    {
        $pdftext = file_get_contents($path);
        $num = preg_match_all("/\/Page\W/", $pdftext, $dummy);
        return $num;
    }

    public function pdfCover(Request $request)
    {
        $typeId = $request->query('packageTypeId');
        $package = PackageInfo::where('id', $typeId)->with('fixtures')->first();

        if (empty($package)) {
            return response()->json(['status' => false, 'message' => 'Error: Package Id is Invalid!']);
        }
        foreach ($package->fixtures as $fixture) {
            $pdfPath = $fixture['pdf_path'];
            $pagesCount = $this->countPages($pdfPath);
            dd($pagesCount);
            $pdf = PDF::loadFile($pdfPath);

            for ($page = 1; $page <= $pagesCount; $page++) {

            }
        }




        return view('pages.pdf-cover');
    }
}
