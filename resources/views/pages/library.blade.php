@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style>
    body {
        background: #f6f6f6;
    }
</style>
@include('includes.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper">
            <div class="heading-top">
                <h1>Fixtures Library<span>31 Jan 2024</span></h1>
            </div>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="create-pdf-lower-body mt-2">
                <div class="lower-body-heading">
                    <h1>Fixture</h1>
                </div>
                <div class="lower-body-input-wrapper">
                    <div class="lower-body-input">
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Type</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text" name="fixture_type" id="fixtureType" class="typeValidation">
                                <p style="color: red" id="warning-message-type"></p>
                            </div>
                        </div>
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Part Number</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text" name="part_number" id="partNo" class="typeValidation">
                                <p style="color: red" id="warning-message-partno"></p>
                            </div>
                        </div>
                    </div>
                    <div class="drop-zone">
                        <span class="drop-zone__prompt"></span>
                        <span>Add Image</span>
                        <span>Drag+Drop</span>
                        <input type="file" name="image_path" id="imageFile" class="drop-zone__input" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">Add File</span>
                        <span>Spec Sheet</span>
                        <span>Drag + Drop</span>
                        <input type="file" name="pdf_file" id="pdfFile" class="drop-zone__input typeValidation" accept=".pdf">
                    </div>
                    <input type="hidden" id="editId">
                    <div class="add-button">
                        <a href="javascript:void(0)" id="addTypeBtn">
                            <img src="{{ asset('public/assets/images/plus-circle.png') }}">
                            <h1>Save</h1>
                        </a>
                    </div>
                </div>

            </form>
                <div class="pdf-detail-bar">
                    <ul class="mt-4">
                        <li style="font-weight: bold;">Fixture Type</li>
                        <li style="font-weight: bold;">Part Number</li>
                        <li style="font-weight: bold;">Image</li>
                        <li style="font-weight: bold;">Spec Sheet</li>
                        <li style="font-weight: bold;">Action</li>
                    </ul>

                    {{-- <ul class="mt-4 row">
                        <li class="fixType_append">fixed</li>
                        <li class="fixPartNo_append" style="max-width:200px;">766456</li>
                        <li style="width: 45px;">
                            <img style="width: 45px;" src="{{ asset('public/assets/images/png_icon.png') }}" alt="image">
                        </li>
                        <li> <img src=" {{ asset('public/assets/images/pdf-icon.png') }}" alt="image"></li>
                        <li class="d-flex align-items-center justify-content-end">
                            <img style="cursor:pointer; width:28px;height:28px;" class="editPdfBtn" src="{{ asset('public/assets/images/edit-icon.svg') }}" alt="image">
                            <img style="cursor:pointer;" class="removePdfBtn ml-2" src="{{ asset('public/assets/images/delete.png') }}" alt="image">
                        </li>
                    </ul> --}}

                </div>

                {{-- <div class="pdf-action">
                    <div class="action-type">
                        <a id="previewPdf" href="javascript:void(0)">Preview & Save</a> --}}
                        {{-- <button type="submit">Preview & Save</button> --}}
                    {{-- </div>
                   
                </div> --}}
                
            </div>
        
</main>
@endsection
@section('insertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('public/assets/js/common.js') }}"></script>
<script>
    var baseUrl = "{{ asset('public') }}"
    var saveLibraryDataUrl = "{{ route('saveLibraryData') }}"
</script>

@endsection