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
                <h1>PDF Package Creator <span>{{date('d M Y')}}</span></h1>
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
                            @if(isset($packageTypes) && !empty($packageTypes))
                            @foreach($packageTypes as $type)
                            <option value="{{$type['id']}}">{{$type['title']}}</option>
                            @endforeach
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
                            <input type="text" name="project" id="projectName" class="typeValidation">
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Visionz Reference: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" id="referenceNo" class="typeValidation">
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
                            </div>
                        </div>
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Part Number</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text" name="part-number" id="partNo" class="typeValidation">
                            </div>
                        </div>
                    </div>
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">Add Image</span>
                        {{-- <span>Spec Sheet</span> --}}
                        <span>Drag+Drop</span>
                        <input type="file" name="image-file" id="pdfImage" class="drop-zone__input typeValidation" accept="image/jpeg, image/png, image/gif">
                    </div>
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">Add PDF</span>
                        <span>Spec Sheet</span>
                        <span>Drag+Drop</span>
                        <input type="file" name="pdf-file" id="pdfFile" class="drop-zone__input typeValidation" accept="application/pdf">
                    </div>
                    <div class="add-button">
                        <a href="javascript:void(0)" id="addTypeBtn">
                            <img src="{{asset('public/assets/images/plus-circle.png')}}">
                            <h1>Add Type</h1>
                        </a>
                    </div>
                </div>
                <div class="pdf-detail-bar">
                    <ul class="mt-4" data-id="${id}">
                        <li style="font-weight: bold;">Fixture Type</li>
                        <li style="font-weight: bold;">Part Number</li>
                        <li style="font-weight: bold;">Image</li>
                        <li style="font-weight: bold;">Spec Sheet</li>
                        <li style="font-weight: bold;">Edit</li>
                        <li style="font-weight: bold;">Delete</li>
                    </ul>
                    <!-- Append PDF Row Here -->
                </div>
                <div class="summary-wrapper">
                    <input type="checkbox" id="checkbox1" class="rounded-checkbox">
                    <label for="checkbox1">Summary</label>
                </div>
                <div class="pdf-action">
                    <div class="action-type">
                        <a id="previewPdf" href="javascript:void(0)">Preview</a>
                    </div>
                    <div class="action-type">
                        <a id="createPdf" href="javascript:void(0)">Create & Save Package</a>
                    </div>
                </div>

            </div>
        </form>
</main>
@endsection
@section('insertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>



<script>
    $('.sidenav  li:nth-of-type(1)').addClass('active');
</script>
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
<!-- DropZone Scripts -- END -- -->

<!-- Add Type Function  -->
<script>
    $(document).ready(function() {

    });
    var fixtures = [];
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

        // Get PDF FIle
        var pdfFileInput = document.getElementById('pdfFile');
        var selectedFiles = pdfFileInput.files;
        var pdfFile = selectedFiles[0];
        // Get Image File
        var ImageFileInput = document.getElementById('pdfImage');
        var selectedImageFiles = ImageFileInput.files;
        var ImageFile = selectedImageFiles[0];
        let ref = $("#referenceNo").val();
        let partNo = $("#partNo").val();
        let fixtureType = $("#fixtureType").val();
        let id = Math.floor(Math.random() * 90000) + 10000;
        pdfObject = {
            "pdfFile": pdfFile,
            'imageFile': ImageFile,
            "reference_no": ref,
            "part_no": partNo,
            "fixtureType": fixtureType,
            "id": id
        };
        fixtures.push(pdfObject);
        let pdfDiv = `<ul class="mt-4" data-id="${id}">
                        <li>${fixtureType}</li>
                        <li>#${partNo}</li>
                        <li> <img style="width: 36px;" src="{{asset('public/assets/images/png_icon.png')}}" alt="image"></li>
                        <li> <img src="{{asset('public/assets/images/pdf-icon.png')}}" alt="image"></li>
                        <li> <img style="cursor:pointer;" class="removePdfBtn" src="{{asset('public/assets/images/edit.png')}}" alt="image"></li>
                        <li> <img style="cursor:pointer;" class="removePdfBtn" src="{{asset('public/assets/images/delete.png')}}" alt="image"></li>
                    </ul>`;
        $(".pdf-detail-bar").append(pdfDiv);
        resetFixtures();
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
    // Reset Fields Function
    function resetFixtures() {
        let part = $("#partNo").val('');
        let fixtureType = $("#fixtureType").val('');
        let pdfFile = $("#pdfFile").val('');
        let dropImage = $(".drop-zone__thumb").remove();
    }
    // Preview PDF Function
    $("#previewPdf").click(function() {

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
        var packageObject = {
            packageType: packageType,
            projectName: projectName,
            referenceNo: referenceNo
        }

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
        }
        data.append('package', JSON.stringify(packageObject));
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        showLoading();
        // return false
        fetch(`{{url('/preview-pdf')}}`, {
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

                const controllerURL = `{{url('/pdf-cover')}}` + '?' + queryString;

                window.location.href = controllerURL;


            })
            .catch(error => {
                // Handle errors
                console.error(error);
            });
        // Fetch REQUEST END

    });

    function showLoading(){
        $('body').css('opacity', 0.5);
        $('button').prop('disabled', true);
        $("#loader").removeClass('d-none');
    }
    function hideLoading(){
        $('body').css('opacity', 1);
        $('button').prop('disabled', false);
        $("#loader").addClass('d-none');
    }
</script>

@endsection
