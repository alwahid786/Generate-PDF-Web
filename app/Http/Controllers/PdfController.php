<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackageType;
use App\Models\PackageInfo;
use App\Models\Fixtures;
use App\Models\LighteningLegend;
use App\Models\LighteningLegendInfo;
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
use App\Models\LibraryFixture;

class PdfController extends Controller
{
    // Create PDF Page View
    public function createPdfPage(Request $request)
    {
        $packageTypes = PackageType::get();
        $libraryFixtures = LibraryFixture::get();
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
            return view('pages.create-pdf', compact('packageTypes', 'packageInfo', 'packageName', 'libraryFixtures'));
        }
        return view('pages.create-pdf', compact('packageTypes', 'packageName', 'packagetypeId', 'packageInfoId', 'libraryFixtures'));
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

        $getAllFixturesId = Fixtures::where('package_info_id', $packageType->id)->pluck('id')->toArray();

        $counts = 0;
        
        $fixtureCount = 0;

        foreach ($fixtures as $index => $fixture) {

            $filePath = $fixture['pdfFile'];
            if (gettype($filePath) != 'string') {

                $uploadedFile = $fixture['pdfFile'];
                $name = time() . '_' . $uploadedFile->getClientOriginalName();
                $path = public_path('/files');
                $inputPdfPath = $path . '/' . $name;
                
                $uploadedFile->move($path, $name);
                
                // New output path for the converted PDF file
                $outputPdfPath = $path . '/converted_' . $name;

                // Ghostscript command to convert PDF
                $command = "gs -o \"$outputPdfPath\" -sDEVICE=pdfwrite \"$inputPdfPath\"";

                // $command = "gswin64c.exe -o \"$outputPdfPath\" -sDEVICE=pdfwrite \"$inputPdfPath\"";
                exec($command, $output, $returnCode);

                // After conversion, update $filePath to the new PDF path
                $filePath = $outputPdfPath;
            }

            $imageFilePath = $fixture['imageFile'];

            if (!empty($imageFilePath) && gettype($imageFilePath) != 'string') {
                $image = $fixture['imageFile'];

                $imageName = $counts++ . time() . '.' . $image->getClientOriginalExtension();

                $imagePath = public_path('/files');
                $image->move($imagePath, $imageName);
                $fixture['imageFile'] = $imageName;
            }

            $existingFixture = Fixtures::find($fixture['id']);

            if ($existingFixture) {

                foreach ($existingFixture as $unlink_media) {

                    if (!empty($unlink_media->pdf_images)) {
        
                        $images = json_decode($unlink_media->pdf_images);
        
                        
                        foreach ($images as $image) {
                            $filename = basename($image->path);
                            $absolutePath = public_path('files/' . $filename);
                
                            if (file_exists($absolutePath)) {
                                unlink($absolutePath);
                            }
                        }
        
                    }
        
                    if (!empty($unlink_media->image_path)) {
        
                        $absoluteImagePath = public_path('files/'.$unlink_media->image_path);
        
                        if (file_exists($absoluteImagePath)) {
                            unlink($absoluteImagePath);
                        }
        
                    }
        
                    if (!empty($unlink_media->pdf_path)) {
        
                        $absolutePdfPath = $unlink_media->pdf_path;
                
                        if (file_exists($absolutePdfPath)) {
                            unlink($absolutePdfPath);
                        }
        
                    }
        
                }

                $existingFixture->package_info_id = $packageType['id'];
                $existingFixture->pdf_path = $filePath;
                $existingFixture->type = $fixture['fixtureType'];
                $existingFixture->part_number = $fixture['part_no'];
                $existingFixture->image_path = $fixture['imageFile'];
                $existingFixture->order_by = $index + 1;
                $existingFixture->save();
            } else {
                $fixtureCount++;
                $newFixture = new Fixtures();
                $newFixture->package_info_id = $packageType['id'];
                $newFixture->pdf_path = $filePath;
                $newFixture->type = $fixture['fixtureType'];
                $newFixture->part_number = $fixture['part_no'];
                $newFixture->image_path = $fixture['imageFile'];
                $newFixture->order_by = $fixtureCount;
                $newFixture->save();

                // dd($fixture['libraryFixtureId']);

                if (isset($fixture['libraryFixtureId']) && $fixture['libraryFixtureId'] != null) {
                    $libraryFixtureId = $fixture['libraryFixtureId'];

                    $liteningData = LibraryFixture::where('id', $libraryFixtureId)->first();

                    if (null != $liteningData || count($liteningData) > 0) {

                        LighteningLegendInfo::create([
                            'manufacturer' => $liteningData->manufacturer,
                            'description' => $liteningData->description,
                            'part_number' => $liteningData->part_number,
                            'lamp' => $liteningData->lamp,
                            'voltage' => $liteningData->voltage,
                            'dimming' => $liteningData->dimming,
                            'fixture_id' => $newFixture->id,
                            'pakage_info_id' => $packageType->id,
                        ]);

                    }

                    
                }
            }
        }

        $fixturesToRemove = array_diff($getAllFixturesId, array_column($fixtures, 'id'));

        Fixtures::whereIn('id', $fixturesToRemove)->delete();

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
        $getFixture = Fixtures::where('package_info_id', $package->id)->get();

        if (empty($package)) {
            return response()->json(['status' => false, 'message' => 'Error: Package Id is Invalid!']);
        }

        $completePdfPath = [];
        $currentPage = [];
        $errorMessages = [];

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

                try {


                    // For Multiple Pages --------------------------------------------------------Start


                    $totalPages = $this->countPages($pdfPath);

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


                        $fixtureId = $fixture['id'];
                        $pdfImages = $pdfImages;


                        Fixtures::where('id', $fixtureId)->update([
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

            } else {

                dd("PDF file does not exist at the specified path: $pdfPath");
            }
        }


        $template =  view('pages.pdf-template', ['pdf_path' => $completePdfPath, 'getFixture' => $getFixture, 'packageTypeName' => $packageTypeName, 'typeId' => $typeId, 'is_view' => $is_view])->render();

        View::share('pdfTemplate', $template);

        $corruptedData = Fixtures::where('package_info_id', $typeId)
            ->whereJsonLength('pdf_images', '=', 0)
            ->get();

        if (count($corruptedData) > 0) {
           
            $errorType = $corruptedData->first()->type;

            $corruptedData = Fixtures::where('package_info_id', $typeId)
                ->whereJsonLength('pdf_images', '=', 0)
                ->delete();



            return redirect()->back()->with('error_corrupted_file', $errorType);
        }

        return view('pages.pdf-cover')->with('pdfTemplate', $template);
    }

    public function createlighteningLegends(Request $request)
    {
        return view('pages.create-legends');
    }

    public function lighteningLegend(Request $request)
    {

        $packageInfoId = $request->query('packageInfoId');

        $fixtureTypes = Fixtures::where('package_info_id', $packageInfoId)->with('legends')->get();

        // dd($fixtureTypes);

        return view('pages.lightening-legend', ['fixtureTypes' => $fixtureTypes, 'packageInfoId' => $packageInfoId]);
    }

    public function lighteningLegendPost(Request $request)
    {

        foreach ($request->type as $key => $data) {

            $lighteningLegendInfoData = [
                'fixture_id' => $request->fixture_id[$key],
                'pakage_info_id' => $request->pakage_info_id,
                'manufacturer' => $request->manufacturer[$key],
                'description' => $request->description[$key],
                'part_number' => $request->part_number[$key],
                'lamp' => $request->lamp[$key],
                'voltage' => $request->voltage[$key],
                'dimming' => $request->dimming[$key],
            ];

            LighteningLegendInfo::updateOrCreate(['fixture_id' => $request->fixture_id[$key]], $lighteningLegendInfoData);

        }

        return redirect()->back();
    }

    public function generateLighteningPdf(Request $request)
    {
        $packageInfoId = $request->query('packageInfoId');

        $fixtureTypes = Fixtures::where('package_info_id', $packageInfoId)->with('legends')->get();

        $projectName = PackageInfo::where('id', $packageInfoId)->first();

        return view('pages.legend-cover', ['fixtureTypes' => $fixtureTypes, 'packageInfoId' => $packageInfoId, 'projectName' => $projectName]);
    }

    public function repairPdf(Request $request)
    {
        return view('pages.repair-pdf');
    }

    public function testController(Request $request)
    {
        $inputPdfPath = 'C:\xampp\htdocs\pdf-generator\public\files\test\one.pdf';
        $outputPdfPath = 'C:\xampp\htdocs\pdf-generator\public\files\test\final.pdf';

        $command = "gswin64c.exe -o \"$outputPdfPath\" -sDEVICE=pdfwrite \"$inputPdfPath\"";
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            return "Conversion failed with error code: $returnCode";
        }

        return "PDF converted successfully!";
    }
}
