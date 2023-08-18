<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageType;
use App\Models\PackageInfo;
use App\Models\Fixtures;
// use Spatie\PdfToImage\Exceptions\PdfDoesNotExist;
// use Spatie\PdfToImage\Pdf;
use Exception;
use Imagick;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
// use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PDF;

class PdfController extends Controller
{
    // Create PDF Page View
    public function createPdfPage(Request $request)
    {
        $packageTypes = PackageType::get();
        $packageInfoId = $request->query('packageInfoId');
        if($packageInfoId){
            $packageInfo = PackageInfo::where('id', $packageInfoId)->with('fixtures')->first();
            return view('pages.create-pdf', compact('packageTypes', 'packageInfo'));
        }
        return view('pages.create-pdf', compact('packageTypes'));
    }

    // Preview PDF Function
    public function previewPdf(Request $request)
    {

        $package = json_decode($request->input('package'));

        // dd($_GET['packageInfoId'])

        // $existingPackageType = PackageInfo::where('id', $package->referenceNo)->first();

        // if ($existingPackageType) {

        //     $existingPackageType->package_name = $package->projectName;
        //     $existingPackageType->package_type_id = $package->packageType;
        //     $existingPackageType->save();
        //     $packageType = $existingPackageType;

        // } else {
            if(!empty($package->pdfId)){
               $packageType = PackageInfo::find($package->pdfId);
            }else{
            $packageType = new PackageInfo();
            }
            $packageType->package_name = $package->projectName;
            $packageType->vision_reference = $package->referenceNo;
            $packageType->package_type_id = $package->packageType;
            $packageType->user_id = auth()->user()->id;
            $packageType->save();
        // }


        $fixtures = $request->fixtures;

        Fixtures::where('package_info_id', $packageType->id)->delete();

        // dd($fixtures);
        foreach ($fixtures as $fixture) {

            // if($existingPackageType)
            // {
            //     if ($fixture['fixtureType'] != null && $fixture['fixtureType'] != 'undefined')
            //     {

            //         if($fixture['id'] != null && $fixture['id'] != 'undefined' ){

            //             $existingFixture = Fixtures::where('id', $fixture['id'])->first();

            //         } else {

            //             $existingFixture = new Fixtures();
            //             $existingFixture->package_info_id = $packageType->id;
            //             $existingFixture->image_path = null;

            //         }


            //         $uploadedFile = $fixture['pdfFile'];

            //         $name = time() . $uploadedFile->getClientOriginalName();
            //         $path = public_path('/files');

            //         $uploadedFile->move($path, $name);
            //         $filePath = $path . '/' . $name;


            //         $existingFixture->pdf_path = $filePath;
            //         $existingFixture->type = $fixture['fixtureType'];
            //         $existingFixture->part_number = $fixture['part_no'];
            //         $existingFixture->save();

            //     }

            // } else {
                $filePath = $fixture['pdfFile'];
                if(gettype($filePath) != 'string'){
                $uploadedFile = $fixture['pdfFile'];
                $name = time() .'_'. $uploadedFile->getClientOriginalName();
                $path = public_path('/files');

                $uploadedFile->move($path, $name);
                $filePath = $path . '/' . $name;

            }
                $fixtureData = new Fixtures();
                $fixtureData->package_info_id = $packageType->id;
                $fixtureData->pdf_path = $filePath;
                $fixtureData->type = $fixture['fixtureType'];
                $fixtureData->part_number = $fixture['part_no'];
                $fixtureData->image_path = null;
                $fixtureData->save();

            // }

        }

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
        $is_view = $request->is_view ?? false;
        $package = PackageInfo::where('id', $typeId)->with('fixtures')->first();

        $packageTypeName = PackageType::where('id', $package->package_type_id)->pluck('title');

        if (empty($package)) {
            return response()->json(['status' => false, 'message' => 'Error: Package Id is Invalid!']);
        }

        $completePdfPath = [];
        $currentPage = [];
        // $obj = [];
        foreach ($package->fixtures as $fixture) {

            $pdfPath = $fixture['pdf_path'];

            $obj = [
                'type' => $fixture['type'],
                'part_number' => $fixture['part_number'],
                'project' => $package['package_name'],
                'vision_reference' => $package['vision_reference'],
                'created_at' => $package['created_at'],
            ];

            // path for ubuntu
            $outputPath = '/var/www/html/pdf-generator/public/files/';

            // path for window
            // $outputPath = 'C:\xampp\htdocs\pdf-generator\public\files';


            if (file_exists($pdfPath) ) {

                // $extension = pathinfo($pdfPath, PATHINFO_EXTENSION);

                // if ($extension === 'pdf') {
                    try {


                        // For Multiple Pages --------------------------------------------------------Start


                        $totalPages = $this->countPages($pdfPath);

                        // echo "Total Pages: $totoalPages<br>";
                        // die;

                        for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++) {

                            $randomString = Str::random(6);
                            $randomNumber = mt_rand(100000, 999999);
                            $time = time();

                            $outputFilename = "/$time.$randomString.$randomNumber.png";

                            // command for window
                            // $command = "gswin64c.exe -sDEVICE=pngalpha -r300 -o \"$outputPath$outputFilename\" -dFirstPage=$pageNumber -dLastPage=$pageNumber \"$pdfPath\"";

                            // command for ubuntu
                            $command = "gs -sDEVICE=pngalpha -r600 -o \"$outputPath$outputFilename\" -dFirstPage=$pageNumber -dLastPage=$pageNumber \"$pdfPath\"";


                            exec($command, $output, $returnCode);

                            if ($returnCode === 0) {

                                $completePdfPath[] = [
                                    'path' => asset('public/files/' . $outputFilename),
                                    'fixture' => $obj
                                ];
                            } else {
                                echo "Error converting page $pageNumber to image.<br>";
                                print_r($output);
                                die;
                            }
                        }

                        // For Multiple Pages --------------------------------------------------------End


                    } catch (PdfDoesNotExist $exception) {

                        dd($exception->getMessage());
                    }
                // } else {
                //     $completePdfPath[] = $pdfPath;
                //     $pageNumber = 1;
                // }


            } else {

                dd("PDF file does not exist at the specified path: $pdfPath");
            }
        }

        $template =  view('pages.pdf-template', ['pdf_path' => $completePdfPath, 'pageNumber' => $pageNumber, 'packageTypeName' => $packageTypeName, 'typeId' => $typeId, 'is_view' => $is_view])->render();

        View::share('pdfTemplate', $template);

        return view('pages.pdf-cover')->with('pdfTemplate', $template);
    }
}
