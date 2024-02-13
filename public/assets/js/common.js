function resetFixtures() {
    let part = $("#partNo").val('');
    let fixtureType = $("#fixtureType").val('');
    let pdfFile = $("#pdfFile").val('');
    let imageFile = $("#imageFile").val('');
    let dropImage = $(".drop-zone__thumb").remove();
}

// validations
var fixtures = [];

// save fixture library

$('#addLibraryTypeBtn').on('click', function () {

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

    let manufacturer = $("#manufacturer").val();
    let description = $("#description").val();
    let part_number = $("#part_number").val();
    let lamp = $("#lamp").val();
    let voltage = $("#voltage").val();
    let dimming = $("#dimming").val();

    data.append('fixtures[pdfFile]', pdfFile);
    data.append('fixtures[imageFile]', imageFile);
    data.append('fixtures[part_no]', part_number);
    data.append('fixtures[manufacturer]', manufacturer);
    data.append('fixtures[lamp]', lamp);
    data.append('fixtures[voltage]', voltage);
    data.append('fixtures[dimming]', dimming);
    data.append('fixtures[description]', description);

    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $("#loader").removeClass('d-none');
    fetch(url, {
        method: 'POST',
        body: data,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        $("#loader").addClass('d-none');
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


// delete Library fixtures

function deleteLibraryFixtures(id)
{

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        var delete_library_url = deleteLibraryDataUrl;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({

            url: delete_library_url,
            type: "POST",
            data: {id : id},
            dataType: 'json',

            success: function(data) {

                    Swal.fire({
                        title: 'Delete fixture',
                        text: data?.message,
                        icon: data?.status,
                        confirmButtonColor: "#1D3F77"
                    }).then(function() {
                        location.reload();
                    });

            },

            error: function(data) {

            }

        });

    });
    
}

function appendLibraryData() {

    let fixtureIds = [];

    $('input[type="checkbox"]:checked').each(function() {
        let fixtureRow = $(this).closest('ul.row');
        let fixtureId = fixtureRow.find('.fixId_append').val();
        fixtureIds.push(fixtureId);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({

        url: getLibraryDataUrl,
        type: "POST",
        data: JSON.stringify(fixtureIds),
        contentType: 'application/json', 
        dataType: 'json',

        success: function(data) {

            var libraryData = data?.data
            if(libraryData)
            {

                $(".drop-zone__prompt").remove();
                $("#pdfFile").removeClass('typeValidation');

                let id = Math.floor(Math.random() * 90000) + 10000;
                
                
                pdfObject = {
                    "pdfFile": libraryData[0]['pdf_path'],
                    'imageFile': libraryData[0]['image_path'],
                    "part_no": libraryData[0]['part_number'],
                    "id": id,
                };

                const pdfCompletePath = pdfObject?.pdfFile;

                const basename = pdfCompletePath.split('\\').pop();
                alert(basename)

                $('#partNo').val(pdfObject?.part_no)  


                $('.drop-zone.image').prepend(`<div class="drop-zone__thumb" data-lib="true" data-label="${pdfObject?.imageFile}"> <img style="width: 100%; height: 100%; object-fit: cover;" src="${baseUrl}/files/${pdfObject?.imageFile}"> </div>`);
                $('.drop-zone.pdf').prepend(`<div class="drop-zone__thumb"  data-lib="true" data-label="${pdfObject?.pdfFile}"><img style="width: 100%; height: 100%; object-fit: cover;" src="${baseUrl}/assets/images/pdf-icon.png" alt="image"></div>`);


                // $('#imageFile').src = pdfObject?.imageFile
                // drop-zone__thumb:first

                // $(".drop-zone__thumb").remove();
                    
                // $(".drop-zone").append(
                //     `<div class="drop-zone__thumb" data-label="${pdfObject?.pdfFile}"></div>`);

                // Append image thumbnail
                // $(".drop-zone:nth-child(1)").append(
                //     `<div class="drop-zone__thumb" data-label="${pdfObject.imageFile}">
                //         <img src="${pdfObject.imageFile}" alt="Image">
                //     </div>`
                // );

                // Append PDF thumbnail
                // $(".drop-zone:nth-child(1)").append(
                //     `<div class="drop-zone__thumb" data-label="${pdfObject.pdfFile}">
                //         <img src="${pdfObject.pdfFile}" alt="PDF">
                //     </div>`
                // );
                
                console.log('selected data of libray', pdfObject?.part_no)
                
                // $.each(libraryData, function(index, fixture) {

                //     let id = Math.floor(Math.random() * 90000) + 10000;

                //     pdfObject = {
                //         "pdfFile": fixture.pdf_path,
                //         'imageFile': fixture.image_path,
                //         "part_no": fixture.part_number,
                //         "fixtureType": fixture.type,
                //         "id": id,
                //     };

                //     fixtures.push(pdfObject);

                //     // append library data

                    


                //     // old data append

                //     // let pdfDiv = `<ul class="mt-4 row${pdfObject?.id}" data-id="${pdfObject?.id}">
                //     //     <li class="fixType_append">${pdfObject?.fixtureType}</li>
                //     //     <li class="fixPartNo_append" style="max-width:200px; word-break: break-all">${pdfObject?.part_no}</li>
                //     //     <li><img style="width: 45px" src="${baseUrl}/assets/images/png_icon.png" alt="image"></li>
                //     //     <li> <img src="${baseUrl}/assets/images/pdf-icon.png" alt="image"></li>
                //     //     <li class="d-flex align-items-center justify-content-end">
                //     //         <img style="cursor:pointer; width:28px;height:28px;" class="editPdfBtn" src="${baseUrl}/assets/images/edit-icon.svg" alt="image">
                //     //         <img style="cursor:pointer;" class="removePdfBtn ml-2" src="${baseUrl}/assets/images/delete.png" alt="image">
                //     //     </li>
                //     // </ul>`;

                //     // $(".pdf-detail-bar").append(pdfDiv);

                //     // $('#fixtureModal').modal('hide');
                //     // $('input[type="checkbox"]').prop('checked', false);


                //     // Swal.fire({
                //     //     title: 'Library fixture',
                //     //     text: 'Library fixture added!',
                //     //     icon: 'success',
                //     //     confirmButtonColor: "#1D3F77"
                //     // })


                // });
            }
        },

        error: function(data) {
            
        }
    });

    

}

