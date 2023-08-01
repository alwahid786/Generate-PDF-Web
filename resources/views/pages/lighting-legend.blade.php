@extends('layouts.layout-default')
@section('content')
<style>
    body {
        background: #f6f6f6;
    }

    .pdf-info-input-wrapper {
        width: 100%;
    }

    .lower-body-input-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 1rem;
        column-gap: 1rem;
        width: 100%;
    }

    .lower-body-input-wrapper .row .type-menu select {
        width: 100%;
    }

    .drop-zone-wrapper .drop-zone {
        width: 100%;
        max-width: 1414px;

    }

    .drop-zone-wrapper {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: center;
        row-gap: 1rem;
        width: 100%;
    }
</style>
@include('includes.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper pb-3">
            <div class="heading-top">
                <h1>Lighting Legend <span>14 Jul 2023</span></h1>
            </div>
        </div>

        <div class="create-pdf-uper-body">
            <div class="project-input-wrapper">
                <div class="pdf-info-input-wrapper">
                    <div class="section-heading">
                        <h1>Project: * </h1>
                    </div>
                    <div class="pdf-info-input">
                        <input type="text">
                    </div>
                </div>
                <div class="pdf-info-input-wrapper">
                    <div class="section-heading">
                        <h1>Visionz Reference: *</h1>
                    </div>
                    <div class="pdf-info-input">
                        <input type="text">
                    </div>
                </div>

            </div>

        </div>
        <!-- -------------------Lower body------------------------ -->
        <div class="create-pdf-lower-body mt-4">
            <div class="lower-body-heading">
                <h1>Fixture</h1>
            </div>
            <div class="lower-body-input-wrapper">
                <div class="row">
                    <div class="col-md-6">
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Type</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Manufacturer</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Description</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Part Number</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Lamping</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="package-type-dropdown">
                            <div class="section-heading">
                                <h1>Voltage</h1>
                            </div>
                            <div class="type-menu">
                                <select name="cars" id="cars">
                                    <option value="120V">120V</option>
                                    <option value="347">347</option>
                                    <option value="12V/120V Remote">12V/120V Remote</option>
                                    <option value="24V/120V Remote">24V/120V Remote</option>
                                    <option value="48V/120V Remote">48V/120V Remote</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="package-type-dropdown">
                            <div class="section-heading">
                                <h1>Dimming</h1>
                            </div>
                            <div class="type-menu">
                                <select name="cars" id="cars">
                                    <option value="No Dimming">No Dimming</option>
                                    <option value="ELV">ELV</option>
                                    <option value="0-10V">0-10V</option>
                                    <option value="DALI">DALI</option>
                                    <option value="DMX">DMX</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="drop-zone-wrapper">
                    <div class="drop-zone">
                        <span class="drop-zone__prompt">Add JPEG</span>
                        <span>Product Image</span>
                        <span>Drag+Drop</span>
                        <input type="file" name="myFile" class="drop-zone__input">
                    </div>
                    <div class="add-button">
                        <a href="#">
                            <img src="{{asset('public/assets/images/plus-circle.png')}}">
                            <h1>Add Type</h1>
                        </a>
                    </div>
                </div>

            </div>
            <div class="pdf-detail-bar">
                <ul class="mt-4">
                    <li>Reference #</li>
                    <li>#0000000000</li>
                    <li> <img src="{{asset('public/assets/images/pdf-icon.png')}}" alt="image"></li>
                    <li> <img src="{{asset('public/assets/images/delete.png')}}" alt="image"></li>
                </ul>
                <ul class="mt-4">
                    <li>Reference #</li>
                    <li>#0000000000</li>
                    <li> <img src="{{asset('public/assets/images/pdf-icon.png')}}" alt="image"></li>
                    <li> <img src="{{asset('public/assets/images/delete.png')}}" alt="image"></li>
                </ul>
            </div>
            <div class="summary-wrapper">
                <input type="checkbox" id="checkbox1" class="rounded-checkbox">
                <label for="checkbox1">Summary</label>
            </div>
            <div class="pdf-action">
                <div class="action-type">
                    <a href="{{(url('pdf-cover'))}}">Preview</a>
                </div>
                <div class="action-type">
                    <a href="#">Create & Save Package</a>
                </div>
            </div>

        </div>
</main>
@endsection
@section('insertjavascript')

<script>
    $('.sidenav  li:nth-of-type(3)').addClass('active');
</script>
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
@endsection