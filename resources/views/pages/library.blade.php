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
                <div class="lower-body-input-wrapper lower-body-input-container">
                    <div class="lower-body-input-wrapper-inner-fields">
                        <div class="lower-body-input">
                            <div class="pdf-info-input-wrapper">
                                <div class="section-heading">
                                    <h1>Manufacturer</h1>
                                </div>
                                <div class="pdf-info-input">
                                    <input type="text" name="manufacturer" id="manufacturer" class="typeValidation">
                                    <p style="color: red" id="warning-message-type"></p>
                                </div>
                            </div>
                            <input type="hidden" id="libraryIdUpdate">
                            <div class="pdf-info-input-wrapper">
                                <div class="section-heading">
                                    <h1>Description </h1>
                                </div>
                                <div class="pdf-info-input">
                                    <input type="text" name="description" id="description" class="typeValidation">
                                    <p style="color: red" id="warning-message-partno"></p>
                                </div>
                            </div>
                        </div>
                        <div class="lower-body-input">
                            <div class="pdf-info-input-wrapper">
                                <div class="section-heading">
                                    <h1>Part Number</h1>
                                </div>
                                <div class="pdf-info-input">
                                    <input type="text" name="part_number" id="part_number" class="typeValidation">
                                    <p style="color: red" id="warning-message-type"></p>
                                </div>
                            </div>
                            <div class="pdf-info-input-wrapper">
                                <div class="section-heading">
                                    <h1>Lamp</h1>
                                </div>
                                <div class="pdf-info-input">
                                    <input type="text" name="lamp" id="lamp" class="">
                                    <p style="color: red" id="warning-message-partno"></p>
                                </div>
                            </div>
                        </div>
                        <div class="lower-body-input">
                            <div class="pdf-info-input-wrapper">
                                <div class="section-heading">
                                    <h1>Voltage </h1>
                                </div>
                                <div class="pdf-info-input">
                                    <input type="text" name="voltage" id="voltage" class="">
                                    <p style="color: red" id="warning-message-type"></p>
                                </div>
                            </div>
                            <div class="pdf-info-input-wrapper">
                                <div class="section-heading">
                                    <h1>Dimming </h1>
                                </div>
                                <div class="pdf-info-input">
                                    <input type="text" name="dimming" id="dimming" class="">
                                    <p style="color: red" id="warning-message-partno"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="lower-body-input-wrapper-inner-file">
                    <div class="lower-body-input-wrapper-inner-file-header">
                        <div class="drop-zone drop-zone-image">
                            <span class="drop-zone__prompt"></span>
                            <span>Add Image</span>
                            <span>Drag+Drop</span>
                            <input type="file" name="image_path" id="imageFile" class="drop-zone__input" accept="image/jpeg, image/png, image/gif">
                        </div>
                        <div class="drop-zone drop-zone-pdf">
                            <span class="drop-zone__prompt">Add File</span>
                            <span>Spec Sheet</span>
                            <span>Drag + Drop</span>
                            <input type="file" name="pdf_file" id="pdfFile" class="drop-zone__input typeValidation" accept=".pdf">
                        </div>
                    </div>
                    <div class="lower-body-input-wrapper-inner-file-footer">
                        <input type="hidden" id="editId">
                        <div class="add-button">
                            <a href="javascript:void(0)" id="addLibraryTypeBtn">
                                <img src="{{ asset('public/assets/images/plus-circle.png') }}">
                                <h1>Save</h1>
                            </a>
                        </div>
                    </div>
                   
                  
                  </div>
                   
                </div>

            </form>
                <div class="pdf-detail-bar">
                    <ul class="mt-4">
                        <li style="font-weight: bold;">Manufacturer</li>
                        <li style="font-weight: bold;">Part Number</li>
                        <li style="font-weight: bold;">Description </li>
                        <li style="font-weight: bold;">Action</li>
                    </ul>

                    @if (isset($libraryFixtures))

                    @foreach ($libraryFixtures as $fixture)

                    <ul class="mt-4 row">
                        <li class="fixPartNo_append" style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; ">{{ $fixture->manufacturer }}</li>
                        <li class="fixPartNo_append" style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; ">{{ $fixture->part_number }}</li>
                        <li class="fixPartNo_append" style="width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; ">{{ $fixture->description }}</li>
                        {{-- <li style="width: 45px;"> --}}
                            {{-- @if ($fixture->image_path != null) --}}
                                {{-- <a href="{{ asset('/public/files/' . $fixture->image_path) }}" target="_blank">
                                    <img style="width: 45px;" src="{{ asset('public/assets/images/png_icon.png') }}" alt="image">
                                </a> --}}
                            {{-- @endif --}}
                        {{-- </li> --}}
                        {{-- <li> 
                            @if ($fixture->pdf_path != null)
                                <?php
                                    // $baseName = basename($fixture->pdf_path);
                                ?>
                                <a href="{{ asset('/public/files/' . $baseName) }}" target="_blank">
                                    <img src="{{ asset('public/assets/images/pdf-icon.png') }}" alt="image">
                                </a>
                            @endif
                        </li> --}}
                        <li class="d-flex align-items-center justify-content-end">
                            <img style="cursor:pointer; width:28px;height:28px;" onclick="showLibrarydataForEdit({{$fixture->id}})" src="{{ asset('public/assets/images/edit-icon.svg') }}" alt="image">
                            {{-- <img onclick="deleteLibraryFixtures({{$fixture->id}})" style="cursor:pointer;" class="removePdfBtn ml-2" src="{{ asset('public/assets/images/delete.png') }}" alt="image"> --}}
                            <img onclick="showLibrarydata({{$fixture->id}})" style="cursor:pointer;" class="removePdfBtn ml-2" src="{{asset('public/assets/images/view.png')}}" alt="image">
                        </li>
                    </ul>
                    
                        
                    @endforeach
                    
                    @endif

                </div>

            </div>
        
</main>

{{-- modal --}}

<div class="modal fade" id="libraryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <form id="cities-form" action="#" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="pdf-info-input-wrapper form-field">
                        <div class="section-heading">
                            <h1>Manufacturer </h1>
                        </div>
                        <div class="pdf-info-input">
                            <input style="font-size: 14px;" type="text" name="lib_manufacturer" id="lib_manufacturer" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pdf-info-input-wrapper form-field">
                        <div class="section-heading">
                            <h1>Part Number</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input style="font-size: 14px;" type="text" name="lib_partno" id="lib_partno" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pdf-info-input-wrapper form-field">
                        <div class="section-heading">
                            <h1>Voltage </h1>
                        </div>
                        <div class="pdf-info-input">
                            <input style="font-size: 14px;" type="text" name="lib_voltage" id="lib_voltage" class="" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pdf-info-input-wrapper form-field">
                        <div class="section-heading">
                            <h1>Description </h1>
                        </div>
                        <div class="pdf-info-input">
                            <input style="font-size: 14px;" type="text" name="lib_description" id="lib_description" class="" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pdf-info-input-wrapper form-field">
                        <div class="section-heading">
                            <h1>Lamp </h1>
                        </div>
                        <div class="pdf-info-input">
                            <input style="font-size: 14px;" type="text" name="lib_lamp" id="lib_lamp" class="" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pdf-info-input-wrapper form-field">
                        <div class="section-heading">
                            <h1>Dimming </h1>
                        </div>
                        <div class="pdf-info-input">
                            <input style="font-size: 14px;" type="text" name="lib_dimming" id="lib_dimming" class="" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pdf-info-input-wrapper form-field">

                        <div class="d-flex mt-5">

                            <a class="pdfLink" href="" target="_blank">
                                <img style="width: 60px; border-radius: 10px;" src="{{ asset('public/assets/images/pdf-icon.png') }}" alt="image">
                            </a>
    
                            <a class="imageLink" href="" target="_blank">
                                <img style="width: 75px; border-radius: 10px;" src="{{ asset('public/assets/images/png_icon.png') }}" alt="image">
                            </a>

                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        

          
       </form>
      </div>
      <div class="">
          <button style="margin: 20px;" id="submit" type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



@endsection
@section('insertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('public/assets/js/common.js') }}"></script>
<script>
    var baseUrl = "{{ asset('public') }}"
    var saveLibraryDataUrl = "{{ route('saveLibraryData') }}"
    var deleteLibraryDataUrl = "{{ route('deleteLibraryData') }}"
    var getSpecificLibraryDataUrl = "{{ route('getSpecificLibraryData') }}"
    var assetUrl = "{{asset('public/files/')}}"


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