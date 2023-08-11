@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    body {
        background: #f6f6f6;
    }

    .comingDiv {
        height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .comingDiv h1 {
        height: 100% !important;
        display: flex;
        align-items: center;
        color: #003f77;
    }
</style>
@include('includes.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3 ">
        <div class="comingDiv">
            <h1 class=""><i class="fas fa-hourglass-half mr-3"></i>COMING SOON...</h1>
        </div>
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
    $('.sidenav  li:nth-of-type(1)').removeClass('active');
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
    // $(document).ready(function() {
    //     const data = {
    //         packageTypeId: 'name'
    //     };
    //     const queryString = new URLSearchParams(data).toString();
    //     const controllerURL = `{{url('/pdf-cover')}}` + '?' + queryString;
    //     console.log(controllerURL);
    // });
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
        let ref = $("#referenceNo").val();
        let partNo = $("#partNo").val();
        let fixtureType = $("#fixtureType").val();
        let id = Math.floor(Math.random() * 90000) + 10000;
        pdfObject = {
            "pdfFile": pdfFile,
            "reference_no": ref,
            "part_no": partNo,
            "fixtureType": fixtureType,
            "id": id
        };
        fixtures.push(pdfObject);
        let pdfDiv = `<ul class="mt-4" data-id="${id}">
                        <li>Reference #${ref}</li>
                        <li>#${partNo}</li>
                        <li> <img src="{{asset('public/assets/images/pdf-icon.png')}}" alt="image"></li>
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
        console.log(fixtures)
        console.log(packageObject)
        // data.append('fixtures', fixtures);
        for (let i = 0; i < fixtures.length; i++) {
            const fixture = fixtures[i];
            data.append(`fixtures[${i}][pdfFile]`, fixture.pdfFile);
            data.append(`fixtures[${i}][reference_no]`, fixture.reference_no);
            data.append(`fixtures[${i}][part_no]`, fixture.part_no);
            data.append(`fixtures[${i}][id]`, fixture.id);
            data.append(`fixtures[${i}][fixtureType]`, fixture.fixtureType);
        }
        data.append('package', JSON.stringify(packageObject));
        // console.log(data);
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

    function showLoading() {
        $('body').css('opacity', 0.5);
        $('button').prop('disabled', true);
        $("#loader").removeClass('d-none');
    }

    function hideLoading() {
        $('body').css('opacity', 1);
        $('button').prop('disabled', false);
        $("#loader").addClass('d-none');
    }
</script>

@endsection