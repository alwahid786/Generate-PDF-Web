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
use Mpdf\Mpdf;
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
                // $path = public_path('/files');
                // dd($path);
                // if (!is_dir($path)) {
                //     mkdir($path, 0777, true);
                // }

                $uploadedFile->move(public_path('/files'), $name);
                $filePath = 'public/files/' . $name;
                $fileUrl = asset($filePath);
                // $uploadedFile->move($path, $name);
                // $filePath = $path . '/' . $name;
                // dd($fileUrl);
            } else {
                return response()->json(['status' => false, 'message' => 'Error: File is Invalid!']);
            }
            $fixtureData = new Fixtures();
            $fixtureData->package_info_id = $packageType->id;
            $fixtureData->pdf_path = $fileUrl;
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

            $pdfFilePath = $pdfPath;

            // Create an mPDF instance
            $mpdf = new Mpdf();

            // Load the PDF file
            $pageCount = $mpdf->SetSourceFile($pdfFilePath);
            // Add the first page to the mPDF instance
            $page = $mpdf->ImportPage(1);

            // Add the imported page to the output PDF
            $mpdf->AddPage();
            $mpdf->UseTemplate($page);

            // Output or save the modified PDF
            $modifiedPdfFilePath = 'public/files/modified.pdf';
            $mpdf->Output($modifiedPdfFilePath, 'F');
            // $pagesCount = $this->countPages($pdfPath);

            // // $pdf = PDF::loadFile($pdfPath);

            // for ($page = 1; $page <= $pagesCount; $page++) {

            // }

        }

        return view('pages.pdf-cover', ['pdf_path' => $pdfPath]);
    }
}
