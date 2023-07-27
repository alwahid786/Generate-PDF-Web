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
                <h1>PDF Package Creator <span>14 Jul 2023</span></h1>
            </div>


        </div>

        <div class="create-pdf-uper-body">
            <div class="open-package-wrapper">
                <div class="section-heading">
                    <h1>Select:</h1>
                </div>
                <div class="open-package-type">
                    <div class="package-type">
                        <a href="#">New Package</a>
                    </div>
                    <div class="package-type">
                        <a href="#">Open Existing Package</a>
                    </div>
                </div>
            </div>
            <div class="package-type-dropdown">
                <div class="section-heading">
                    <h1>Package Type:</h1>
                </div>
                <div class="type-menu">
                    <select name="cars" id="cars">
                        <option value="volvo">Volvo</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mercedes</option>
                        <option value="audi">Audi</option>
                    </select>
                </div>
            </div>
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
        <div class="create-pdf-lower-body mt-5">
            <div class="lower-body-heading">
                <h1>Type</h1>
            </div>
            <div class="lower-body-input-wrapper">
                <div class="lower-body-input">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Type</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text">
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Part Number</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text">
                        </div>
                    </div>
                </div>
                <div class="drop-zone">
                    <span class="drop-zone__prompt">Add PDF</span>
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
            <div class="pdf-detail-bar">
                <ul>
                    <li>Reference #</li>
                    <li>#0000000000</li>
                    <li> <img src="{{asset('public/assets/images/pdf-icon.png')}}" alt="image"></li>
                    <li> <img src="{{asset('public/assets/images/delete.png')}}" alt="image"></li>
                </ul>
            </div>
            <div class="summary-wrapper">
                <img src="{{asset('public/assets/images/check-circle.png')}}" alt="image">
                <h1>Summary</h1>
            </div>
            <div class="pdf-action">
                <div class="action-type">
                    <a href="#">Preview</a>
                </div>
                <div class="action-type">
                    <a href="#">Create & Save Package</a>
                </div>
            </div>
            <?php
            $port = $_SERVER['SERVER_PORT'];
            echo "The server is running on port: " . $port;
            ?>
        </div>
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
    $(document).ready(function() {
        $('#detail-table').DataTable({
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "pageLength": 12,
            language: {
                'paginate': {
                    'previous': '<img class="my-1" src="{{asset("public/assets/images/rev.png")}}" alt="">',
                    'next': '<img class="my-1" src="{{asset("public/assets/images/for.png")}}" alt="">'
                }
            }
        });
    });
</script>
<script>
    $('.sidenav  li:nth-of-type(1)').addClass('active');
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

    /**
     * Updates the thumbnail on a drop zone element.
     *
     * @param {HTMLElement} dropZoneElement
     * @param {File} file
     */
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