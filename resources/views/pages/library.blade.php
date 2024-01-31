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
                                <input type="text" name="fixture-type" id="fixtureType" class="typeValidation">
                                <p style="color: red" id="warning-message-type"></p>
                            </div>
                        </div>
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Part Number</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text" name="part-number" id="partNo" class="typeValidation">
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
                        <input type="file" name="pdf-file" id="pdfFile" class="drop-zone__input typeValidation" accept=".pdf">
                    </div>
                    <input type="hidden" id="editId">
                    <div class="add-button">
                        <a href="javascript:void(0)" id="addTypeBtn">
                            <img src="{{ asset('public/assets/images/plus-circle.png') }}">
                            <h1>Save</h1>
                        </a>
                    </div>
                </div>
                <div class="pdf-detail-bar">
                    <ul class="mt-4">
                        <li style="font-weight: bold;">Fixture Type</li>
                        <li style="font-weight: bold;">Part Number</li>
                        <li style="font-weight: bold;">Image</li>
                        <li style="font-weight: bold;">Spec Sheet</li>
                        <li style="font-weight: bold;">Action</li>
                    </ul>

                    <ul class="mt-4 row">
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
                    </ul>
                    <ul class="mt-4 row">
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
                    </ul>
                    <ul class="mt-4 row">
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
                    </ul>

                    <!-- Append PDF Row Here -->
                </div>
            </div>
        </form>
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

<!-- DropZone Scripts -- START -- -->
<script>
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        dropZoneElement.addEventListener("click", (e) => {
            inputElement.click();
        });

        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {

                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        });

        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });

        dropZoneElement.addEventListener("drop", (e) => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
            }

            dropZoneElement.classList.remove("drop-zone--over");
        });
    });

    function hideFirstAndThirdSpans(dropZoneElement) {
        const spans = dropZoneElement.querySelectorAll("span");
        spans[0].style.display = "none"; // Hide the first span
        spans[2].style.display = "none"; // Hide the third span
    }

    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

        // First time - remove the prompt
        if (dropZoneElement.querySelector(".drop-zone__prompt")) {
            dropZoneElement.querySelector(".drop-zone__prompt").remove();
        }

        // First time - there is no thumbnail element, so lets create it
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("drop-zone__thumb");
            dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        // Show thumbnail for image files
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } else {
            thumbnailElement.style.backgroundImage = null;
        }
    }
</script>

<script>
    $(document).ready(function() {

        // $(".pdf-detail-bar").sortable();

        $('#projectName').on('keydown keyup change', function() {
            var char = $(this).val();
            var charLength = $(this).val().length;
            if (charLength > 35) {
                $(this).val($(this).val().substring(0, 35));
                $('#warning-message').text('Length is not valid, maximum ' + 35 + ' allowed.');
            } else {
                $('#warning-message').text('');
            }
        });

        $('#referenceNo').on('keydown keyup change', function() {
            var char = $(this).val();
            var charLength = $(this).val().length;
            if (charLength > 15) {
                $(this).val($(this).val().substring(0, 15));
                $('#warning-message-ref').text('Length is not valid, maximum ' + 15 + ' allowed.');
            } else {
                $('#warning-message-ref').text('');
            }
        });

        $('#fixtureType').on('keydown keyup change', function() {
            var char = $(this).val();
            var charLength = $(this).val().length;
            if (charLength > 10) {
                $(this).val($(this).val().substring(0, 10));
                $('#warning-message-type').text('Length is not valid, maximum ' + 10 + ' allowed.');
            } else {
                $('#warning-message-type').text('');
            }
        });

        $('#partNo').on('keydown keyup change', function() {
            // alert('coming');
            var char = $(this).val();
            var charLength = $(this).val().length;
            if (charLength > 60) {
                $(this).val($(this).val().substring(0, 60));
                $('#warning-message-partno').text('Length is not valid, maximum ' + 60 + ' allowed.');
            } else {
                $('#warning-message-partno').text('');
            }
        });
    });
</script>
@endsection