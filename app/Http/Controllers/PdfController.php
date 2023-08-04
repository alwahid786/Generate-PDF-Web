<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageType;
use App\Models\PackageInfo;
use Spatie\PdfToImage\Pdf;
use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
use Exception;
use Imagick;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

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
            $uploadedFile = $fixture['pdfFile'];
            if ($uploadedFile && $uploadedFile->isValid()) {
                try {
                    $name = time() . $uploadedFile->getClientOriginalName();
                    $path = public_path('/files');
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
                    $uploadedFile->move($path, $name);
                    $file = $path . '/' . $name;

                    // Generate the output image path and filename
                    $outputImagePath = $path . '/' . pathinfo($name, PATHINFO_FILENAME);

                    // Update the command to use pdftoppm
                    // $pageNumber = 1; // Replace with the desired page number to convert
                    // $command = "pdftoppm -singlefile -png -f $pageNumber -l $pageNumber \"$file\" \"$outputImagePath\"";

                    // // Execute the shell command using shell_exec
                    // shell_exec($command);
                    // // The output image file will have .png extension, not .jpg
                    $outputImageFile = $outputImagePath . '.png';
                    // dd($outputImageFile);

                    // // Check if the conversion was successful and the output image exists
                    // if (file_exists($outputImageFile)) {
                    //     // Do whatever you need to do with the converted image here
                    //     // For example, you can save the path in the database or display it to the user.
                    //     dd("PDF page $pageNumber converted to image: $outputImageFile");
                    // } else {
                    //     dump("Error: Image conversion failed.");
                    // }
                    // $image = new Imagick();
                    // $image->pingImage($file);
                    // dd($image->getNumberImages());

                    $pdf = new Pdf($file);
                    $pdf->setPage(1); // Optional: Set image quality (100 is highest)
                    $pdf->saveImage($outputImageFile);
                    dd('done');
                } catch (FileNotFoundException $e) {
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
