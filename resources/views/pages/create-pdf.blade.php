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

        @if(session('error_corrupted_file'))
        <div class="alert alert-danger">
            Your pdfs {{ session('error_corrupted_file') }} type is corrupted!
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <div class="header-wrapper">
            <div class="heading-top">
                <h1>PDF Package Creator <span>{{ date('d M Y') }}</span></h1>
            </div>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- -------------------Upper body------------------------ -->
            <div class="create-pdf-uper-body">
                <div class="package-type-dropdown">
                    <div class="section-heading">
                        <h1>Package Type:</h1>
                    </div>
                    <div class="type-menu">
                        <select name="package_type" id="packageType" class="typeValidation">

                            @if (isset($packageTypes) && !empty($packageTypes))
                            @if($packageName != 'all')
                            <option <?php if (isset($packageInfo) && $packageInfo->package_type_id == $packagetypeId[0]) {
                                        echo 'selected';
                                    } ?> value="{{ $packagetypeId[0] }}">{{ $packageName }}
                            </option>
                            @else
                            @foreach ($packageTypes as $type)
                            <option <?php if (isset($packageInfo) && $packageInfo->package_type_id == $type['id']) {
                                        echo 'selected';
                                    } ?> value="{{ $type['id'] }}">{{ $type['title'] }}
                            </option>
                            @endforeach
                            @endif

                            @else
                            <option selected="selected" disabled="disabled">--Select</option>
                            @endif

                        </select>
                    </div>
                </div>
                <div class="project-input-wrapper">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Project: * </h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="project" value="{{ $packageInfo->package_name ?? '' }}" id="projectName" class="typeValidation">
                            <p style="color: red" id="warning-message"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Visionz Reference: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" value="{{ $packageInfo->vision_reference ?? '' }}" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- -------------------Lower body------------------------ -->
            <div class="create-pdf-lower-body mt-5">
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
                    <div class="drop-zone image">
                        <span class="drop-zone__prompt"></span>
                        <span>Add Image</span>
                        <span>Drag+Drop</span>
                        <input type="file" name="image_path" id="imageFile" class="drop-zone__input" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="drop-zone pdf">
                        <span class="drop-zone__prompt">Add File</span>
                        <span>Spec Sheet</span>
                        <span>Drag + Drop</span>
                        <input type="file" name="pdf-file" id="pdfFile" class="drop-zone__input typeValidation" accept=".pdf">
                    </div>
                    <input type="hidden" id="editId">
                    <div class="add-button">

                        <div class="add-button" style="width: 180px;">
                            <a class="add-library-btn" data-toggle="modal" data-target="#fixtureModal">
                                <img src="{{ asset('public/assets/images/plus-circle.png') }}">
                                <h1 >Select From Library</h1>
                            </a>
                        </div>

                        <a class="mt-3" href="javascript:void(0)" id="addTypeBtn" style="width: 180px;">
                            <img src="{{ asset('public/assets/images/plus-circle.png') }}">
                            <h1>Save</h1>
                        </a>

                        
                        
                    </div>
                </div>
                <div class="pdf-detail-bar">
                    <ul class="mt-4" data-id="${id}">
                        <li style="font-weight: bold;">Fixture Type</li>
                        <li style="font-weight: bold;">Part Number</li>
                        <li style="font-weight: bold;">Image</li>
                        <li style="font-weight: bold;">Spec Sheet</li>
                        {{-- <li style="font-weight: bold;">Edit</li> --}}
                        <li style="font-weight: bold;">Action</li>
                    </ul>
                    @if (isset($packageInfo))
                    @foreach ($packageInfo->fixtures as $fixture)
                    <ul class="mt-4 row{{ $fixture['id'] }}" data-id="{{ $fixture['id'] }}">
                        <li class="fixType_append">{{ $fixture['type'] }}</li>
                        <li class="fixPartNo_append" style="max-width:200px;">{{ $fixture['part_number'] }}</li>
                        <li style="width: 45px;">
                            @if (!empty($fixture->image_path) && $fixture->image_path != 'undefined')
                            <img style="width: 45px;" src="{{ asset('public/assets/images/png_icon.png') }}" alt="image">
                            @endif
                        </li>
                        <li> <img src=" {{ asset('public/assets/images/pdf-icon.png') }}" alt="image"></li>
                        <li class="d-flex align-items-center justify-content-end">
                            <img style="cursor:pointer; width:28px;height:28px;" class="editPdfBtn" src="{{ asset('public/assets/images/edit-icon.svg') }}" alt="image">
                            <img style="cursor:pointer;" class="removePdfBtn ml-2" src="{{ asset('public/assets/images/delete.png') }}" alt="image">
                        </li>
                    </ul>
                    @endforeach
                    @endif
                    <!-- Append PDF Row Here -->
                </div>
                <div class="summary-wrapper">
                    <input type="checkbox" name="summary" id="checkbox_summary" class="rounded-checkbox">
                    <label for="checkbox_summary">Summary</label>
                </div>
                <div class="pdf-action">
                    <div class="action-type">
                        <a id="previewPdf" href="javascript:void(0)">Preview & Save</a>
                    </div>
                    <!-- <div class="action-type">
                                    <a id="createPdf" href="javascript:void(0)">Create & Save Package</a>
                                </div> -->
                </div>

            </div>
        </form>
</main>

<!-- Modal -->
<div class="modal fade" id="fixtureModal" tabindex="-1" role="dialog" aria-labelledby="fixtureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content py-3 px-2">
            <div class="modal-header">
                <h5 class="modal-title" id="fixtureModalLabel">Library Fixtures</h5>
                <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="fixture-modal-body">
                    <ul class="mt-4 fixture-detail-list">
                        <li style="font-weight: bold;">Select</li>
                        <li style="font-weight: bold;">Manufacturer </li>
                        <li style="font-weight: bold;">Part Number</li>
                        <li style="font-weight: bold;">Image</li>
                    </ul>

                    @if (isset($libraryFixtures))

                    @foreach ($libraryFixtures as $fixture)

                    <ul class="mt-4 row fixture-detail-list">

                        <li class="selected-fixture">
                            <div class="summary-wrapper d-flex align-items-center justify-content-center">
                                <input style="visibility: hidden;" type="radio" name="selected_fixture" id="radio{{$fixture->id}}" class="rounded-radio" value="{{ $fixture->id }}">
                                <label for="radio{{$fixture->id}}"></label>
                                <input type="hidden" class="fixId_append" value="{{ $fixture->id }}">
                            </div>
                        </li>


                        <li class="fixPartNo_append" style="max-width:200px;">{{ $fixture->manufacturer }}</li>
                        <li class="fixPartNo_append" style="max-width:200px;">{{ $fixture->part_number }}</li>

                        <li>
                            @if ($fixture->image_path != null)
                            <a href="{{ asset('/public/files/' . $fixture->image_path) }}" target="_blank">
                                <img data-src-img="{{ $fixture->image_path }}" style="width:45px" src="{{ asset('public/assets/images/png_icon.png') }}" alt="image">
                            </a>
                            @else
                            <h2>---</h2>
                            @endif
                        </li>

                        {{-- <li> 
                            @if ($fixture->pdf_path != null)
                                <?php
                                    // $baseName = basename($fixture->pdf_path);
                                ?>
                                <a href="{{ asset('/public/files/' . $baseName) }}" target="_blank">
                                    <img  data-src-pdf="{{ $fixture->pdf_path }}" src="{{ asset('public/assets/images/pdf-icon.png') }}" alt="image">
                                </a>
                            @endif
                        </li> --}}
                        
                    </ul>
                    @endforeach
                    @endif
                    
                    <input type="hidden" name="library_fixture_id" id="libraryFixtureId">

                </div>
                <div class="modal-footer">
                    <button type="button" class="fixture-modal-close" data-dismiss="modal">Close</button>
                    <button onclick="appendLibraryData()" type="button" class="fixture-save-btn">Add</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('insertjavascript')
    <script>
        $('body').addClass('bg-clr')
        var baseUrl = "{{ asset('public') }}"
        var getLibraryDataUrl = "{{ route('getLibraryData') }}"
    </script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('public/assets/js/common.js') }}"></script>


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
    <!-- DropZone Scripts -- END -- -->

    <!-- Add Type Function  -->
    <script>
        $(document).ready(function() {

            $(".pdf-detail-bar").sortable();

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
                var char = $(this).val();
                var charLength = $(this).val().length;
                if (charLength > 60) {
                    $(this).val($(this).val().substring(0, 60));
                    $('#warning-message-partno').text('Length is not valid, maximum ' + 60 + ' allowed.');
                } else {
                    $('#warning-message-partno').text('');
                }
            });

            $("#pdfFile").on('change', function() {
                if (!validatePDFFile(this)) {
                    Swal.fire({
                        title: 'File Error',
                        text: 'File must be a PDF',
                        icon: 'error',
                        confirmButtonColor: "#1D3F77"
                    });
                    // Clear the file input (optional)
                    $(this).val('');
                }
            });

            $('#imageFile').on('change', function() {
                var input = this;
                if (input.files.length > 0) {
                    var fileSize = input.files[0].size; // Get the file size in bytes
                    var maxSize = 5 * 1024 * 1024; // 5MB in bytes

                    if (fileSize > maxSize) {
                        Swal.fire({
                            title: 'Image Error',
                            text: 'Image must be less then 5mb',
                            icon: 'error',
                            confirmButtonColor: "#1D3F77"
                        });
                        $(this).val('');
                    }
                }
            });

            function validatePDFFile(fileInput) {
                const allowedExtensions = /(\.pdf)$/i;
                const fileName = fileInput.value;
                return allowedExtensions.test(fileName);
            }

        });


        var fixtures = [];
        <?php
        if (isset($packageInfo)) {
        ?>
            previous_data = <?= $packageInfo->fixtures ?>;

            $.each(previous_data, function(index, value) {
                new_obj = {
                    pdfFile: value.pdf_path,
                    imageFile: value.image_path,
                    reference_no: "dsds",
                    part_no: value.part_number,
                    fixtureType: value.type,
                    id: value.id
                }
                fixtures.push(new_obj);
            });
        <?php
        }
        ?>
        // console.log(fixtures)
        $(document).on('click', '#addTypeBtn', function() {
            let error = 0;
            let validate = $(".typeValidation").each(function() {
                if ($(this).val() == '') {
                    error++
                    if ($(this).prop('type') === 'file') {
                        $(this).parent().css('border', '2px dashed red');
                    } else {
                        $(this).css('border', '1px solid red');
                    }
                } else {
                    if ($(this).prop('type') === 'file') {
                        $(this).parent().css('border', '2px dashed #e2e2e2');
                    } else {
                        $(this).css('border', '1px solid #e2e2e2');
                    }
                }
            });
            if (error > 0) {
                Swal.fire({
                    title: 'Empty Fields',
                    text: 'All fields are required',
                    icon: 'error',
                    confirmButtonColor: "#1D3F77"
                })
                return;
            }
            $("#pdfFile").addClass('typeValidation');

            // Get PDF FIle
            var pdfFileInput = document.getElementById('pdfFile');
            var selectedFiles = pdfFileInput.files;
            var pdfFile = selectedFiles[0];
            // Get Image File
            var imageFileInput = document.getElementById('imageFile');
            var selectedimageFiles = imageFileInput.files;
            var imageFile = selectedimageFiles[0];
            // Get Image Preview Div
            // var imagePreview = $(".drop-zone__thumb:first").prop('outerHTML');
            // var pdfPreview = $(".drop-zone__thumb:eq(1)").prop('outerHTML');

            let ref = $("#referenceNo").val();
            let partNo = $("#partNo").val();
            let fixtureType = $("#fixtureType").val();
            let libraryFixtureId = $("#libraryFixtureId").val();
            let id = Math.floor(Math.random() * 90000) + 10000;

            // Check if it is edit case
            let editedId = $("#editId").val();
            if (editedId != '') {
                // Update Array
                fixtures = fixtures.map(obj => {
                    if (obj.id === parseInt(editedId)) {
                        // console.log(obj.pdfFile);
                        oldfile = obj.pdfFile;
                        oldimageFile = obj.imageFile;
                        editObj = {
                            ...obj,
                            reference_no: ref,
                            part_no: partNo,
                            fixtureType: fixtureType,
                        };
                        if ($("#pdfFile").val() != '') {
                            editObj['pdfFile'] = pdfFile
                        } else {
                            editObj['pdfFile'] = oldfile
                        }
                        if ($("#imageFile").val() != '') {
                            editObj['imageFile'] = imageFile
                        } else {
                            editObj['imageFile'] = oldimageFile
                        }
                        // Create a new object with the updated age
                        return editObj;
                    }
                    return obj; // Return unchanged object
                });
                // Update Content Row which was appended
                $(".row" + editedId).find('.fixType_append').text(fixtureType);
                $(".row" + editedId).find('.fixPartNo_append').text(partNo);
                resetFixtures();


                $("#editId").val('');
                return;
            }

            $(".pdf-detail-bar").sortable({
                update: function() {
                    updateFixturesArray();
                }
            });
            
           pdfLibObj = $(".drop-zone.pdf").find('.drop-zone__thumb');
            if(pdfLibObj.attr('data-lib') =='true' && pdfFile==undefined){
                pdfFile = pdfLibObj.attr('data-label')
            }
           imgLibObj = $(".drop-zone.image").find('.drop-zone__thumb');
            if(pdfLibObj.attr('data-lib') =='true' && imageFile==undefined){
                imageFile = imgLibObj.attr('data-label')
            }
            pdfObject = {
                "pdfFile": pdfFile,
                'imageFile': imageFile,
                "reference_no": ref,
                "part_no": partNo,
                "fixtureType": fixtureType,
                "id": id,
                'libraryFixtureId': libraryFixtureId
                // "new_edit": true
                // "imagePreview": imagePreview,
                // "pdfPreview": pdfPreview
            };
            fixtures.push(pdfObject);
            // console.log(fixtures);
            let pdfDiv = `<ul class="mt-4 row${id}" data-id="${id}">
                        <li class="fixType_append">${fixtureType}</li>
                        <li class="fixPartNo_append" style="max-width:200px; word-break: break-all">${partNo}</li>
                        <li>${(imageFile ? `<img style="width: 45px" src="{{ asset('public/assets/images/png_icon.png') }}" alt="image">` : '')}</li>
                        <li> <img src="{{ asset('public/assets/images/pdf-icon.png') }}" alt="image"></li>
                        <li class="d-flex align-items-center justify-content-end">
                            <img style="cursor:pointer; width:28px;height:28px;" class="editPdfBtn" src="{{ asset('public/assets/images/edit-icon.svg') }}" alt="image">
                            <img style="cursor:pointer;" class="removePdfBtn ml-2" src="{{ asset('public/assets/images/delete.png') }}" alt="image">
                        </li>
                    </ul>`;
            $(".pdf-detail-bar").append(pdfDiv);
            // $(".sortable").draggable({
            //     revert: true, // Automatically return to the original position when released
            // });
            // $(".sortable").draggable();
            $(".pdf-detail-bar").sortable();
            // $(".sortable").disableSelection();
            resetFixtures();
            // console.log(fixtures);
            // console.log('old')
            // console.log('old')
            $('#libraryFixtureId').val('')
        });
        // Remove PDF BTN Click function
        $(document).on('click', '.removePdfBtn', function() {
            let pdfDiv = $(this).closest('ul');
            let id = pdfDiv.data('id');
            let indexToRemove = fixtures.findIndex(entry => entry.id === id);
            if (indexToRemove !== -1) {
                fixtures.splice(indexToRemove, 1);
            }
            pdfDiv.remove();
        });
        // EDIT PDF BTN Click function
        $(document).on('click', '.editPdfBtn', function() {

            $(".drop-zone__prompt").remove();
            $("#pdfFile").removeClass('typeValidation');
            let pdfDiv = $(this).closest('ul');
            let id = pdfDiv.data('id');


            fixtures.map(obj => {
                if (obj.id === parseInt(id)) {
                    oldfile = obj.pdfFile;
                    if (typeof oldfile === 'string') {
                        var filename = oldfile.split('/').pop().split('\\').pop();
                        var exactName = filename.split('_').slice(1).join('_');
                    } else {
                        exactName = oldfile.name;
                    }
                    $(".drop-zone__thumb").remove();
                    $(".drop-zone").append(
                        `<div class="drop-zone__thumb" data-label="${exactName}"></div>`);
                }
            });


            let type = pdfDiv.find('.fixType_append').text();
            let part = pdfDiv.find('.fixPartNo_append').text();
            // let imagePre = pdfDiv.find('.imgPreview_append').html();
            // let pdfPre = pdfDiv.find('.pdfPreview_append').html();
            // console.log(imagePre);
            $("#fixtureType").val(type);
            $("#partNo").val(part);
            $("#editId").val(id);
            // $("#imageFile").after(imagePre);
            // $("#pdfFile").after(pdfPre);
            // let indexToRemove = fixtures.findIndex(entry => entry.id === id);
            // if (indexToRemove !== -1) {
            //     fixtures.splice(indexToRemove, 1);
            // }
            // pdfDiv.remove();
        });
        // Reset Fields Function
        function resetFixtures() {
            let part = $("#partNo").val('');
            let fixtureType = $("#fixtureType").val('');
            let pdfFile = $("#pdfFile").val('');
            let imageFile = $("#imageFile").val('');
            let dropImage = $(".drop-zone__thumb").remove();
        }

        function updateFixturesArray() {
            const sortedIds = $(".pdf-detail-bar ul").map(function() {
                return $(this).data("id");
            }).get();

            const newFixtures = [];
            for (const id of sortedIds) {
                const fixture = fixtures.find(f => f.id === id);
                if (fixture) {
                    newFixtures.push(fixture);
                }
            }

            fixtures = newFixtures;
        }
        // Preview PDF Function
        $("#previewPdf").click(function() {
            // console.log(fixtures);
            if (fixtures.length < 1) {
                Swal.fire({
                    title: 'No Data!',
                    text: 'Please add atleast one PDF file to preview.',
                    icon: 'error',
                    confirmButtonColor: "#1D3F77"
                })
                return;
            }
            let packageType = $("#packageType").val();
            let projectName = $("#projectName").val();
            let referenceNo = $("#referenceNo").val();
            let libraryFixtureId = $("#libraryFixtureId").val();
            let summaryCheckbox = document.getElementById("checkbox_summary");
            if (summaryCheckbox.checked) {
                summary = 1;
            } else {
                summary = 0;
            }
            var packageObject = {
                packageType: packageType,
                projectName: projectName,
                referenceNo: referenceNo,
                summary: summary,
                pdfId: '{{ $packageInfo->id ?? "" }}',
                libraryFixtureId: libraryFixtureId
            }

            updateFixturesArray();

            // Fetch REQUEST START
            var data = new FormData();

            for (let i = 0; i < fixtures.length; i++) {
                const fixture = fixtures[i];
                data.append(`fixtures[${i}][pdfFile]`, fixture.pdfFile);
                data.append(`fixtures[${i}][imageFile]`, fixture.imageFile);
                data.append(`fixtures[${i}][reference_no]`, fixture.reference_no);
                data.append(`fixtures[${i}][part_no]`, fixture.part_no);
                data.append(`fixtures[${i}][id]`, fixture.id);
                data.append(`fixtures[${i}][fixtureType]`, fixture.fixtureType);
                data.append(`fixtures[${i}][libraryFixtureId]`, fixture.libraryFixtureId);
            }
            data.append('package', JSON.stringify(packageObject));
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            showLoading();
            // return false
            fetch(`{{ url('/preview-pdf') }}`, {
                    method: 'POST',
                    body: data,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // console.log("qwe*^2456754", data.data);
                    // return
                    if (data.status == false) {
                        hideLoading();
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonColor: "#1D3F77"
                        })
                        return;
                    }
                    const responseData = {
                        packageTypeId: data.data
                    };

                    const queryString = new URLSearchParams(responseData).toString(); // 22=

                    const controllerURL = `{{ url('/pdf-cover') }}` + '?' + queryString;

                    window.location.href = controllerURL;


                })
                .catch(error => {
                    // Handle errors
                    console.error(error);
                });
            // Fetch REQUEST END

        });

        function showLoading() {
            $("#loader").removeClass('d-none');
        }

        function hideLoading() {
            $("#loader").addClass('d-none');
        }
    </script>
    @endsection