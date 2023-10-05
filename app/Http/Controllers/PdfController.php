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

        $urlParam = $request->segment(count($request->segments()));
        $packageName = '';
        if ($urlParam == 'specification-package') {
            $packageName = 'Specification Package';
        } elseif ($urlParam == 'submittal-package') {
            $packageName = 'Submittal Package';
        } elseif ($urlParam == 'record-drawing') {
            $packageName = 'Record Drawings';
        } else {
            $packageName = 'all';
        }

        $packagetypeId = PackageType::where('title', $packageName)->pluck('id');

        if ($packageInfoId) {
            $packageInfo = PackageInfo::where('id', $packageInfoId)->with('fixtures')->first();
            return view('pages.create-pdf', compact('packageTypes', 'packageInfo', 'packageName'));
        }
        return view('pages.create-pdf', compact('packageTypes', 'packageName', 'packagetypeId'));
    }

    // Preview PDF Function
    public function previewPdf(Request $request)
    {

        $package = json_decode($request->input('package'));


        if (!empty($package->pdfId)) {
            $packageType = PackageInfo::find($package->pdfId);
        } else {
            $packageType = new PackageInfo();
        }

        $packageType->package_name = $package->projectName;
        $packageType->vision_reference = $package->referenceNo;
        $packageType->package_type_id = $package->packageType;
        $packageType->summary = $package->summary;
        $packageType->user_id = auth()->user()->id;
        $packageType->save();


        $fixtures = $request->fixtures;

        Fixtures::where('package_info_id', $packageType->id)->delete();

        foreach ($fixtures as $fixture) {

            $filePath = $fixture['pdfFile'];
            if (gettype($filePath) != 'string') {
                $uploadedFile = $fixture['pdfFile'];
                $name = time() . '_' . $uploadedFile->getClientOriginalName();
                $path = public_path('/files');

                $uploadedFile->move($path, $name);
                $filePath = $path . '/' . $name;
            }

            if ($fixture['imageFile'] != 'undefined') {
                $image = $fixture['imageFile'];

                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $imagePath = public_path('/files');
                $image->move($imagePath, $imageName);
                $imagefilePath = $imagePath . '/' . $imageName;
            }


            $fixtureData = new Fixtures();
            $fixtureData->package_info_id = $packageType->id;
            $fixtureData->pdf_path = $filePath;
            $fixtureData->type = $fixture['fixtureType'];
            $fixtureData->part_number = $fixture['part_no'];
            $fixtureData->image_path = $imagefilePath ?? null;
            $fixtureData->save();
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
        $getFixture = Fixtures::where('package_info_id', $package->package_type_id)->get();

        if (empty($package)) {
            return response()->json(['status' => false, 'message' => 'Error: Package Id is Invalid!']);
        }

        $completePdfPath = [];
        $currentPage = [];

        foreach ($package->fixtures as $fixture) {

            $pdfImages = [];

            $pdfPath = $fixture['pdf_path'];

            $obj = [
                'type' => $fixture['type'],
                'part_number' => $fixture['part_number'],
                'image_path' => $fixture['image_path'],
                'project' => $package['package_name'],
                'summary' => $package['summary'],
                'vision_reference' => $package['vision_reference'],
                'created_at' => $package['created_at'],
            ];

            // path for ubuntu
            $outputPath = '/var/www/html/pdf-generator/public/files/';

            // path for window
            // $outputPath = 'C:\xampp\htdocs\pdf-generator\public\files';


            if (file_exists($pdfPath)) {

                // $extension = pathinfo($pdfPath, PATHINFO_EXTENSION);

                // if ($extension === 'pdf') {
                try {


                    // For Multiple Pages --------------------------------------------------------Start


                    $totalPages = $this->countPages($pdfPath);

                    // echo "Total Pages: $totoalPages<br>";
                    // die;

                    if ($is_view == false) {
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

                                $pdfImages[] = [
                                    'path' => asset('public/files/' . $outputFilename)
                                ];
                            } else {
                                echo "Error converting page $pageNumber to image.<br>";
                                print_r($output);
                                die;
                            }
                        }

                        Fixtures::where('id', $fixture['id'])->update([
                            'pdf_images' => $pdfImages
                        ]);
                    } else {

                        $jsonData = $fixture['pdf_images'];

                        $data = json_decode($jsonData, true);
                        // dd($data);

                        foreach ($data as $item) {
                            if (isset($item['path'])) {

                                $completePdfPath[] = [
                                    'path' => $item['path'],
                                    'fixture' => $obj
                                ];
                            }
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


        // dd($getFixture);
        $template =  view('pages.pdf-template', ['pdf_path' => $completePdfPath, 'getFixture' => $getFixture, 'packageTypeName' => $packageTypeName, 'typeId' => $typeId, 'is_view' => $is_view])->render();

        View::share('pdfTemplate', $template);

        return view('pages.pdf-cover')->with('pdfTemplate', $template);
    }
}
