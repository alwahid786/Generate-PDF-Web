@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style>
    body {
        background: #f6f6f6;
    }

    iframe {
        width: 100%;
        height: 100vh;

    }

    table,
    th,
    td {
        border-bottom: 1px solid #a9a9a9;
        border-right: 1px solid #a9a9a9;
        border-collapse: collapse;
    }

    th {
        text-align: center;
        background-color: rgb(207, 207, 207);
        padding: 0.3rem;
        font-size: 0.9rem;
    }

    td {
        padding: 0.3rem;
        word-break: break-all;
        font-size: 0.8rem;
    }

    .table-wrapper {
        border: 1px solid #a9a9a9;
    }

    .table-inner-wrapper {
        height: 650px;
    }

    table {
        border-left: none;
        border-right: none;
    }

    tr th:nth-of-type(1),
    tr td:nth-of-type(1) {
        border-left: none;
    }

    tr td:nth-of-type(8),
    tr th:nth-of-type(8) {
        border-right: none;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 1rem;
        height: 60px;
        border-bottom: 1px solid #a9a9a9;
    }

    .table-header h1 {
        font-size: 1.1rem;
        margin: 0;
    }

    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;

        padding: 0rem 1rem;
        height: 40px;
    }

    .page-number {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        column-gap: 1rem;
        width: 33%;
    }

    .page-number h1 {
        font-size: 0.9rem;
        margin: 0;
        font-weight: 400;
    }

    .table-footer a {
        text-decoration: none;
        color: black;
        font-size: 0.9rem;
    }

    .vision-logo-wrapper {
        width: 33%;
        text-align: right;
    }

    .vision-logo-wrapper img {
        width: 100px;
    }
</style>
@if(auth()->user()->is_admin==1)
@include('includes.admin.navbar')
@else
@include('includes.navbar')
@endif
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper">
            <div class="heading-top">
                <h1>Lighting Legend Creator <span>{{ date("F j, Y") }}</span></h1>
            </div>
        </div>
        <div id="content" style="
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 0 auto;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
        Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue',
        sans-serif;
    ">
            <div id="inner-content" style="position: relative; width: 1056px">
                <div style="
          height: 816px;
          width: 1056px;
          padding: 2rem;
          background-color: rgb(255, 255, 255);
        " class="body-page-wrapper">
                    <div class="table-wrapper" style="height: 100%; width: 100%">
                        <div class="table-header">
                            <h1>Project: <span class="projectTitle">{{ $projectName->package_name }}</span></h1>
                            <h1>Lighting Legend</h1>
                        </div>
                        <div class="table-inner-wrapper">
                            <table style="width: 100%">

                                <tr>
                                    <th style="width: 10%">Type</th>
                                    <th style="width: 10%">Image</th>
                                    <th style="width: 10%">Manufacturer</th>
                                    <th style="width: 20%">Description</th>
                                    <th style="width: 20%">Part Number</th>
                                    <th style="width: 10%">Lamp</th>
                                    <th style="width: 10%">Voltage</th>
                                    <th style="width: 10%">Diming</th>
                                </tr>
                                @foreach ($fixtureTypes as $data)
                                <tr>
                                    <td>{{ $data->type ?? ''}}</td>
                                    <td>
                                        @if ($data->image_path != NULL)
                                        <img style="width: 100%; max-height: 70px" src="{{ asset('public/files/'.$data->image_path) }}" alt="image" />
                                        @else
                                        <img style="width: 100%; max-height: 70px" src="{{ asset('public/assets/images/empty_image.jpg') }}" alt="">
                                        @endif
                                        {{-- <img style="width: 100%; max-height: 70px" src="{{asset('public/assets/images/dummy.jpg')}}" alt="" /> --}}
                                    </td>
                                    <td>{{ $data->legends->manufacturer ?? '' }}</td>
                                    <td>{{ $data->legends->description ?? '' }}</td>
                                    <td>{{ $data->part_number ?? '' }}</td>
                                    <td>{{ $data->legends->lamp ?? '' }}</td>
                                    <td>{{ $data->legends->voltage ?? '' }}</td>
                                    <td>{{ $data->legends->dimming ?? '' }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="table-footer">
                            <div class="page-number">
                                {{-- <h1>Page 2 of 10:</h1> --}}
                                <h1>Date : 10/18/2023</h1>
                            </div>
                            <a href="mailto:project@visionz.ca">project@visionz.ca</a>
                            <div class="vision-logo-wrapper">
                                <img src="{{asset('public/assets/images/logo-icon.png')}}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="d-flex flex-column justify-content-center align-items-center" style="position: fixed; bottom: 10px; right: 5px">
    <button style="
      background: #5757c8;
      color: white;
      width: 180px;
      height: 60px;
      border-style: none;
      border-radius: 5px;
      margin-bottom: 5px;
    " id="convertBtn">
        Download to PDF
    </button>
    <a href="#"><button style="
        background: black;
        color: white;
        width: 180px;
        height: 60px;
        border-style: none;
        border-radius: 5px;
      ">
            Go back to Edit
        </button></a>
</div>

@endsection
@section('insertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    const convertBtn = document.getElementById("convertBtn");
    const contentDiv = document.getElementById("content");

    var projectTitles = document.getElementsByClassName("projectTitle");
    var projectName = document.getElementsByClassName("projectTypeName");
    if (projectTitles.length > 0) {
        var fileName = projectTitles[0].innerHTML;
    }

    if (projectName.length > 0) {
        var fileTypeName = projectName[0].innerHTML;
    }

    const pdfOptions = {
        image: {
            type: "jpeg",
            quality: 1,
        },
        filename: `${fileName} - Lighting Legend.pdf`,
        html2canvas: {
            scale: 3,
        },
        jsPDF: {
            unit: "mm",
            format: "letter",
            orientation: "landscape",
        },
    };
    convertBtn.addEventListener("click", () => {
        html2pdf().set(pdfOptions).from(contentDiv).save();
    });
</script>

<script>
    $('.sidenav  li:nth-of-type(2)').addClass('active');
</script>


@endsection