// dropzone

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

function resetFixtures() {
    let part = $("#partNo").val('');
    let fixtureType = $("#fixtureType").val('');
    let pdfFile = $("#pdfFile").val('');
    let imageFile = $("#imageFile").val('');
    let dropImage = $(".drop-zone__thumb").remove();
}

// validations
var fixtures = [];
// $(document).on('click', '#addTypeBtn', function() {


//     alert('all done')

//     // Get PDF FIle
//     var pdfFileInput = document.getElementById('pdfFile');
//     var selectedFiles = pdfFileInput.files;
//     var pdfFile = selectedFiles[0];
//     // Get Image File
//     var imageFileInput = document.getElementById('imageFile');
//     var selectedimageFiles = imageFileInput.files;
//     var imageFile = selectedimageFiles[0];

//     let partNo = $("#partNo").val();
//     let fixtureType = $("#fixtureType").val();
//     let id = Math.floor(Math.random() * 90000) + 10000;


//     // Check if it is edit case
//     let editedId = $("#editId").val();
//     if (editedId != '') {
//         // Update Array
//         fixtures = fixtures.map(obj => {
//             if (obj.id === parseInt(editedId)) {
//                 // console.log(obj.pdfFile);
//                 oldfile = obj.pdfFile;
//                 oldimageFile = obj.imageFile;
//                 editObj = {
//                     ...obj,
//                     reference_no: ref,
//                     part_no: partNo,
//                     fixtureType: fixtureType,
//                 };
//                 if ($("#pdfFile").val() != '') {
//                     editObj['pdfFile'] = pdfFile
//                 } else {
//                     editObj['pdfFile'] = oldfile
//                 }
//                 if ($("#imageFile").val() != '') {
//                     editObj['imageFile'] = imageFile
//                 } else {
//                     editObj['imageFile'] = oldimageFile
//                 }
//                 // Create a new object with the updated age
//                 return editObj;
//             }
//             return obj; // Return unchanged object
//         });
//         // Update Content Row which was appended
//         $(".row" + editedId).find('.fixType_append').text(fixtureType);
//         $(".row" + editedId).find('.fixPartNo_append').text(partNo);
//         // resetFixtures();


//         $("#editId").val('');
//         return;
//     }

//     pdfObject = {
//         "pdfFile": pdfFile,
//         'imageFile': imageFile,
//         "part_no": partNo,
//         "fixtureType": fixtureType,
//         "id": id,
//     };
//     // 
//     fixtures.push(pdfObject);
//     let pdfDiv = `<ul class="mt-4 row${id}" data-id="${id}">
//                 <li class="fixType_append">${fixtureType}</li>
//                 <li class="fixPartNo_append" style="max-width:200px; word-break: break-all">${partNo}</li>
//                 <li>${(imageFile ? `<img style="width: 45px" src="${baseUrl}/assets/images/png_icon.png" alt="image">` : '')}</li>
//                 <li> <img src="${baseUrl}/assets/images/pdf-icon.png" alt="image"></li>
//                 <li class="d-flex align-items-center justify-content-end"> 
//                     <img style="cursor:pointer; width:28px;height:28px;" class="editPdfBtn" src="${baseUrl}/assets/images/edit-icon.svg" alt="image">
//                     <img style="cursor:pointer;" class="removePdfBtn ml-2" src="${baseUrl}/assets/images/delete.png" alt="image">
//                 </li>
//             </ul>`;
//     $(".pdf-detail-bar").append(pdfDiv);

//     resetFixtures();


// });

// save fixture library

$('#addTypeBtn').on('click', function () {

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
    var url = saveLibraryDataUrl;
   
    var data = new FormData();

    // Get PDF FIle
    var pdfFileInput = document.getElementById('pdfFile');
    var selectedFiles = pdfFileInput.files;
    var pdfFile = selectedFiles[0];
    // Get Image File
    var imageFileInput = document.getElementById('imageFile');
    var selectedimageFiles = imageFileInput.files;
    var imageFile = selectedimageFiles[0];

    let partNo = $("#partNo").val();
    let fixtureType = $("#fixtureType").val();

    data.append('fixtures[pdfFile]', pdfFile);
    data.append('fixtures[imageFile]', imageFile);
    data.append('fixtures[part_no]', partNo);
    data.append('fixtures[fixtureType]', fixtureType);

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    fetch(url, {
        method: 'POST',
        body: data,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        // console.log(data?.message);
        if(data?.message == "Success") {
            Swal.fire({
                title: 'Add fixture',
                text: 'Add fixture successfully!',
                icon: 'success',
                confirmButtonColor: "#1D3F77"
            }).then(function() {
                location.reload();
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle errors
    });

});