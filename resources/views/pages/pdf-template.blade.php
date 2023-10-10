<body style="background-color: #f6f6f6;">
    <div id="content" style="
        display:flex;
        flex-direction:column;
        align-items:center;
    margin: 0 auto;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
          Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue',
          sans-serif;
      ">

        <div class="controls" id="control-wrapper" style="display:block;
        position: fixed;
        right:0;top: 52%;
    transform: translateY(-50%);">
            <div class="edit-options-wrapper" style="
                background-color: rgb(255, 255, 255);
                box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px,
                  rgba(17, 17, 26, 0.1) 0px 0px 8px;
                border-radius: 10px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                position: relative;
                width: 80px;
              ">

                <label class="edit-option" style="
                  display: flex;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                  row-gap: 0.5rem;
                  cursor: pointer;
                  width: 100%;
                  border-bottom:1px solid #00000014;
                  margin:0px;
                  padding-top:1.5rem;
                  border-top-left-radius:10px;
                  border-top-right-radius:10px;
                ">
                    <input type="radio" name="shape" value="line" style="display: none" />
                    <img style="width: 35px" src="{{ asset('public/assets/images/marker.png') }}" />
                    <p style="margin: 0">Highlight</p>
                </label>
                <label class="edit-option" style="
                 display: flex;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                  row-gap: 0.5rem;
                  padding-top:1.5rem;
                  cursor: pointer;
                  width: 100%;
                  border-bottom:1px solid #00000014;
                  margin:0px;
                ">
                    <input type="radio" name="shape" value="comm" id="comment-option" style="display: none" />
                    <img style="width: 35px" src="{{ asset('public/assets/images/add-text.png') }}" />
                    <p style="margin: 0">Add Test</p>
                </label>
                <label class="edit-option" style="
                    display: flex;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                  row-gap: 0.5rem;
                  padding-top:1.5rem;
                  cursor: pointer;
                  width: 100%;
                  border-bottom:1px solid #00000014;
                  margin:0px;
                ">
                    <input type="radio" name="shape" value="rect" style="display: none" />
                    <img style="width: 35px" src="{{ asset('public/assets/images/rectangle.png') }}" />
                    <p style="margin: 0">Add Box</p>
                </label>
                <label class="edit-option" style="
                    display: flex;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                  row-gap: 0.5rem;
                  padding-top:1.5rem;
                  cursor: pointer;
                  width: 100%;
                  border-bottom:1px solid #00000014;
                  margin:0px;
                ">
                    <input type="radio" name="shape" value="arrow" style="display: none" />
                    <img style="width: 35px" src="{{ asset('public/assets/images/right-arrow.png') }}" />
                    <p style="margin: 0">Arrow</p>
                </label>
                <div id="clearCanvas" class="edit-option" style="
                    display: flex;
                  flex-direction: column;
                  justify-content: center;
                  align-items: center;
                  row-gap: 0.5rem;
                  cursor: pointer;
                  width: 100%;
                  padding-top:1.5rem;
                  padding-bottom:0.5rem;
                  border-bottom-left-radius:10px;
                  border-bottom-right-radius:10px;

                ">
                    <img style="width: 35px" src="{{ asset('public/assets/images/eraser.png') }}" />
                    <p style="margin: 0">Clear All</p>
                </div>
            </div>
        </div>
        <div id="inner-content" style="position: relative; width: 816px">
            <canvas id="canvas" style="position: absolute; top: 0; left: 0; z-index: 1"></canvas>
            <div class="text-modal" id="comment-modal" style="display: none">
                <div>
                    <img src="{{ asset('public/assets/images/delete-button.png') }}" style="width: 15px; cursor: pointer" id="comment-modal-close" />
                </div>
                <textarea placeholder="Enter comment" id="comment-content" type="text" rows="3" style="
                  border-radius: 10px;
                  border: 1px solid #dbdbdb;
                  padding: 0.375rem 0.75rem;
                  outline: none;
                  resize: none;
                  width: 100%;
                "></textarea>
                <button id="comment-btn" style="
                  background-color: #003f77;
                  color: white;
                  border-radius: 10px;
                  border: none;
                  height: 30px;
                  width: 50px;
                  cursor: pointer;
                ">
                    Add
                </button>
            </div>

            <div style="height: 1056px;width:816px;background-color: rgb(255, 255, 255);padding: 2rem;" class="main-page-wrapper">
                <div style="height: 50%; position: relative">
                    <img src="{{ asset('public/assets/images/logo-icon.png') }}" style="
              position: absolute;
              right: -150px;
              top: 50%;
              transform: translateY(-50%) rotate(-90deg);
              width: 500px;" />
                </div>
                <div style="height: 50%;display: flex;flex-direction: column;justify-content: space-between;padding: 0 2rem;">
                    <?php
                    $date = new DateTime($pdf_path[0]['fixture']['created_at']);
                    $formattedDate = $date->format('d F Y');
                    ?>
                    <div>
                        <h1 style="font-size: 2.8rem; margin: 0" class="projectTitle">{{ $pdf_path[0]['fixture']['project'] }}</h1>
                        <h3 style="font-size: 17px;margin-top: 6px;margin-bottom: 4px;font-weight: bold;" class="projectTypeName">{{ $packageTypeName[0] }}</h3>
                        <p style="font-size: 14px;padding-top: 12px;">Test</p>
                    </div>
                    <div style="
              display: flex;
              align-items: center;
              justify-content: space-between;">
                        <div><img src="{{ asset('public/assets/images/logo-icon.png') }}" style="width: 170px" />
                        </div>
                        <div>
                            <a href="https://visionz.ca/" style="text-decoration: none; color: black; font-size: 17px">visionz.ca</a>
                        </div>
                        <div>
                            <p style="font-size: 17px; margin: 0">437-886-9837</p>
                        </div>
                        <div>
                            <a href="mailto:projects@visionz.ca" style="text-decoration: none; color: black; font-size: 17px">projects@visionz.ca</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- start summary page -->
            @if ($pdf_path[0]['fixture']['summary'] == 1)
            <div style="height: 1056px;width:816px;background-color: rgb(255, 255, 255);padding: 2rem;" class="main-page-wrapper">
                <div style="display:flex; justify-content:space-between; align-items:center">
                    <img style="width:140px; height:100%" src="{{ asset('public/assets/images/logo-icon.png') }}" <h1 style="font-size:1.2rem;margin:0px">Project</h1>
                    <h1 style="font-size:1.2rem ;margin:0px"> Visionz #</h1>
                    <h1 style="font-size:1.5rem ;margin:0px">Package</br> Summary</h1>
                </div>
                <div style="height: 890px; padding-top: 15px">
                    <table style="width: 100%">
                        <tr>
                            <th style="padding: 0.8rem 0; width: 15%; text-align:center">Type</th>
                            <th style="padding: 0.8rem 0; width: 30%;text-align:center">Image</th>
                            <th style="padding: 0.8rem 0; width: 40%;text-align:center">Part Number</th>
                        </tr>
                        @foreach ($getFixture as $data)
                        <tr>
                            <td style="
                        border-bottom: 1px solid rgb(226, 226, 226);
                        border-collapse: collapse;
                        text-align: center;
                      ">
                                {{ $data['type'] }}
                            </td>

                            <td style="
                        border-bottom: 1px solid rgb(226, 226, 226);
                        border-collapse: collapse;
                        text-align: center;
                      ">

                                <img style="height: 90px" src="{{asset('public/files/'.$data['image_path'])}}" alt="">

                            </td>
                            <td style="
                        border-bottom: 1px solid rgb(226, 226, 226);
                        border-collapse: collapse;
                        text-align: center;
                      ">
                                {{ $data['part_number'] }}
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div style="display: flex;align-items: center;justify-content: space-between;">
                    <div><img src="{{ asset('public/assets/images/logo-icon.png') }}" style="width: 170px" />
                    </div>
                    <div>
                        <a href="https://visionz.ca/" style="text-decoration: none; color: black; font-size: 17px">visionz.ca</a>
                    </div>
                    <div>
                        <p style="font-size: 17px; margin: 0">437-886-9837</p>
                    </div>
                    <div>
                        <a href="mailto:projects@visionz.ca" style="text-decoration: none; color: black; font-size: 17px">projects@visionz.ca</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- end summary page -->

            @foreach ($pdf_path as $index => $path)
            @php
            $currentPage = $index + 1;
            @endphp
            <div style="height: 1056px; width:816px; padding: 2rem; background-color: rgb(255, 255, 255);" class="body-page-wrapper">
                <div class="table-wrapper" style="border: 1px solid; ">
                    <div class="table-header" style="height: 70px; display: flex; border-bottom: 1px solid black">
                        <div style="width: 20%;border-right: 1px solid black;text-align: center;padding: 10px 0px;">
                            <img style="width: 120px; margin: 0 auto" src="{{ asset('public/assets/images/side-logo.png') }}" alt="" />
                        </div>
                        <div style="width: 25%; border-right: 1px solid black; padding: 2px 0px">
                            <h1 style="margin: 0; font-size: 1.2rem; text-align: center">
                                Project
                            </h1>
                            <p style="margin: 0; text-align: center; font-size: 0.9rem; word-break:break-all; padding:0 0.5rem">
                                {{ $path['fixture']['project'] }}
                            </p>
                        </div>
                        <div style="width: 30%; border-right: 1px solid black; padding: 2px 0px">
                            <h1 style="margin: 0; font-size: 1.2rem; text-align: center;">
                                Part Number
                            </h1>
                            <p style="margin: 0; text-align: center; font-size: 0.9rem; word-break:break-all; padding:0 0.5rem">
                                {{ $path['fixture']['part_number'] }}
                            </p>
                            {{-- <p style="margin: 0; text-align: center; font-size: 0.9rem">
                                <strong>Visionz #</strong> {{ $path['fixture']['vision_reference'] }}
                            </p> --}}
                        </div>
                        <div style="width: 25%; padding: 2px 0px">
                            <h1 style="margin: 0; text-align: center; font-size: 1.2rem">
                                Type
                            </h1>
                            <h1 style="margin: 0; text-align: center; font-size: 1.8rem; word-break:break-all">
                                {{ $path['fixture']['type'] }}
                            </h1>
                        </div>
                    </div>

                    <div class="pdf-content" style="height: 890px; width:100%; display:flex; justify-content:center; align-items:center">
                        <img class="body-images" style="width:100%; height:100%" src="{{ $path['path'] }}" alt="">
                        {{-- <img src="{{asset('public/assets/images/Capture.png')}}" alt="" style="width: 100%" /> --}}
                    </div>

                    <div class="table-footer" style="height: 37px; display: flex; border-top: 1px solid black; padding: 8px 0px">
                        <div style="width: 25%; text-align: center">
                            <p style="margin: 0; font-size: 0.9rem">
                                <strong>Date</strong> {{ $formattedDate }}
                            </p>
                        </div>
                        <div style="width: 50%;display: flex;column-gap: 1.5rem;justify-content: center;">
                            <p style="margin: 0; font-size: 0.9rem">projects@visionz.ca</p>
                            <p style="margin: 0; font-size: 0.9rem">437-886-9837</p>
                        </div>
                        <div style="width: 25%; text-align: center">
                            <p style="margin: 0; font-size: 0.9rem">Page {{ $currentPage }} </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>

<div class="d-flex flex-column justify-content-center align-items-center " style="position:fixed; bottom:10px; right:5px">
    <button style="background: #5757c8;color: white;width: 180px;height: 60px;border-style: none;border-radius: 5px; margin-bottom:5px" id="convertBtn">Download to PDF</button>
    @if (!$is_view)
    <a href="{{ url('create-pdf') }}?packageInfoId=<?= $typeId ?>"><button style="background: black;color: white;width: 180px;height: 60px;border-style: none;border-radius: 5px;">Go
            back to Edit</button></a>
    @endif
</div>
<!-- Include the html2canvas library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    const convertBtn = document.getElementById("convertBtn");
    const contentDiv = document.getElementById("content");

    var projectTitles = document.getElementsByClassName("projectTitle");
    var projectName = document.getElementsByClassName("projectTypeName");
    if (projectTitles.length > 0) {
        var fileName = projectTitles[0].innerHTML;
    }

    if (projectName.length > 0) {
        var fileTypeName = projectName[0].innerHTML;
    }

    const pdfOptions = {
        image: {
            type: "jpeg",
            quality: 1,
        }, // Use PNG and set maximum quality
        filename: `${fileName} - ${fileTypeName}.pdf`, // The default filename for the downloaded PDF
        html2canvas: {
            scale: 3
        }, // Increase the scale for better image quality (adjust as needed)
        jsPDF: {
            unit: "mm",
            format: "letter",
            orientation: "portrait"
        },
    };
    convertBtn.addEventListener("click", () => {
        // $("#loader").removeClass('d-none');
        html2pdf().set(pdfOptions).from(contentDiv).save();
        // $("#loader").addClass('d-none');
        // html2pdf().set(pdfOptions).from(contentDiv).outputPdf().then(pdf => {
        //     $("#loader").removeClass('d-none');
        //     saveAs(pdf, `${fileName}.pdf`); // Save the PDF
        // });
    });

    // function convertToPDF() {
    //     html2pdf().set(pdfOptions).from(contentDiv).save();
    // }

    // window.addEventListener("load", convertToPDF);
    // const imgElements = document.getElementsByClassName("body-images");

    // Assuming there are multiple elements with the class "body-images"
    // You can loop through them to get the width and height of each element
    // for (let i = 0; i < imgElements.length; i++) {
    //     var imgWidth = imgElements[i].clientWidth; // Get the width of the element
    //     var imgHeight = imgElements[i].clientHeight; // Get the height of the element
    //     console.log(`Image ${i + 1} - Height: ${imgHeight}, Width: ${imgWidth}`);
    //     const imgRatio = imgWidth / imgHeight;
    //     const pageWidth = imgRatio * 1056;
    //     console.log(imgRatio,"ratio");
    //     console.log(pageWidth,"width")
    // }
</script>
<script>
    var canvas,
        context,
        dragging = false,
        dragStartLocation,
        snapshot;

    const contentWrapper = document.getElementById("content");
    const innerContent = document.getElementById("inner-content");
    const commentModal = document.getElementById("comment-modal");
    const addComment = document.getElementById("comment-btn");
    const commentContent = document.getElementById("comment-content");
    const commentModalClose = document.getElementById("comment-modal-close");
    const commentOption = document.getElementById("comment-option");
    const controlWrapper = document.getElementById("control-wrapper");
    const editOption = document.getElementById("edit-option");

    $(".edit-option").click(function() {
        $(".edit-option").css("background-color", "transparent");
        $(this).css("background-color", "#dce8f3");
    });

    function getCanvasCoordinates(event) {
        var x = event.clientX - canvas.getBoundingClientRect().left;
        var y = event.clientY - canvas.getBoundingClientRect().top;

        return {
            x: x,
            y: y,
        };
    }

    function takeSnapShot() {
        snapshot = context.getImageData(0, 0, canvas.width, canvas.height);
    }

    function restoreSnapShot() {
        context.putImageData(snapshot, 0, 0);
    }

    function drawLine(position) {
        context.lineWidth = 20;
        context.strokeStyle = "#ffff007d";
        context.beginPath();
        context.moveTo(dragStartLocation.x, dragStartLocation.y);
        context.lineTo(position.x, position.y);
        context.stroke();
    }

    function drawRect(position) {
        context.lineWidth = 3;
        context.strokeStyle = "#FF0000";
        var w = position.x - dragStartLocation.x;
        var h = position.y - dragStartLocation.y;
        context.beginPath();
        context.rect(dragStartLocation.x, dragStartLocation.y, w, h);
    }

    function drawArrow(position) {
        context.lineWidth = 3;
        context.strokeStyle = "#0000FF";

        var fromX = dragStartLocation.x;
        var fromY = dragStartLocation.y;
        var toX = position.x;
        var toY = position.y;
        var arrowheadSize = 10;
        var angle = Math.atan2(toY - fromY, toX - fromX);
        context.beginPath();
        context.moveTo(fromX, fromY);
        context.lineTo(toX, toY);
        context.stroke();
        context.beginPath();
        context.moveTo(toX, toY);
        context.lineTo(
            toX - arrowheadSize * Math.cos(angle - Math.PI / 6),
            toY - arrowheadSize * Math.sin(angle - Math.PI / 6)
        );
        context.lineTo(
            toX - arrowheadSize * Math.cos(angle + Math.PI / 6),
            toY - arrowheadSize * Math.sin(angle + Math.PI / 6)
        );
        context.closePath();
        context.fillStyle = "#0000FF";
        context.fill();
    }

    function draw(position) {
        var shape = document.querySelector(
            'input[type="radio"][name="shape"]:checked'
        ).value;
        context.lineCap = "round";
        if (shape === "line") {
            drawLine(position);
        }
        if (shape === "rect") {
            context.stroke();
            drawRect(position);
        }
        if (shape === "arrow") {
            context.stroke();
            drawArrow(position);
        }
    }

    function dragStart(event) {
        dragging = true;
        dragStartLocation = getCanvasCoordinates(event);
        takeSnapShot();
    }

    function drag(event) {
        var position;
        if (dragging === true) {
            restoreSnapShot();
            position = getCanvasCoordinates(event);
            draw(position);
        }
    }

    //Drag Stop
    function dragStop(event) {
        dragging = false;
        restoreSnapShot();
        var position = getCanvasCoordinates(event);
        draw(position);
    }

    function eraseCanvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
        const commentWrapper = document.getElementsByClassName("comment");
        var radioElements = document.querySelectorAll('input[name="shape"]');
        for (var i = 0; i < radioElements.length; i++) {
            radioElements[i].checked = false;
        }
        for (const commentItem of commentWrapper) {
            console.log(commentItem);
            commentItem.style.display = "none";
        }
    }

    //function invoked when document is fully loaded
    function init() {
        canvas = document.getElementById("canvas");
        context = canvas.getContext("2d");
        var clearCanvas = document.getElementById("clearCanvas"),
            contentWrapper = document.getElementById("content");
        clearCanvas.addEventListener("click", eraseCanvas, false);
    }
    const pdfEditOption = document.querySelectorAll('input[name="shape"]');
    pdfEditOption.forEach((radio) => {
        radio.addEventListener("change", (event) => {
            const selectedOption = event.target.value;
            if (
                selectedOption === "line" ||
                selectedOption === "rect" ||
                selectedOption === "arrow"
            ) {
                canvas.addEventListener("mousedown", dragStart, false);
                canvas.addEventListener("mousemove", drag, false);
                canvas.addEventListener("mouseup", dragStop, false);
                innerContent.removeEventListener("click", openCommentModal);
            }
            if (selectedOption === "comm") {
                innerContent.addEventListener("click", openCommentModal, false);
                commentModal.addEventListener("click", (event) => {
                    event.stopPropagation();
                });
                addComment.addEventListener("click", modalComment, false);
                commentModalClose.addEventListener("click", () => {
                    commentModal.style.display = "none";
                });
            }
        });
    });

    window.addEventListener("load", init, false);

    function setCanvasDimensions() {
        const canvas = document.getElementById("canvas");
        const contentWrapper = document.getElementById("inner-content");
        canvas.width = contentWrapper.clientWidth;
        canvas.height = contentWrapper.clientHeight;
    }

    // Call the function to set canvas dimensions initially and when the window is resized
    window.addEventListener("load", setCanvasDimensions);
    window.addEventListener("resize", setCanvasDimensions);

    var x1, y1;

    function openCommentModal() {
        commentContent.value = "";
        x1 = event.clientX - innerContent.getBoundingClientRect().left;
        y1 = event.clientY - innerContent.getBoundingClientRect().top;
        console.log(x1, "x");
        console.log(y1, "y");

        commentModal.style.cssText = `
                          position: absolute;
                          left: ${x1}px;
                          top: ${y1}px;
                          display: flex;
                          flex-direction: column;
                          align-items: flex-end;
                          row-gap: 0.5rem;
                          box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
                          width: 200px;
                          padding: 0.5rem;
                          background-color: white;
                          border-radius: 10px;
                          z-index:3;
                      `;
    }

    function modalComment() {
        event.stopPropagation();
        const comment = document.createElement("div");
        const commentDelete = document.createElement("img");
        commentDelete.id = "comment-delete";
        commentDelete.src = "{{ asset('public/assets/images/delete-button.png') }}";
        comment.classList.add("comment");
        comment.style.cssText = `
                              left: ${x1}px;
                              top: ${y1}px;
                              display: none;
                              color: red;
                              background: transparent;
                              position: absolute;
                              border-radius: 10px;
                              padding: 7px 20px 7px 7px;
                              font-weight: 600;
                              cursor: pointer;
                              z-index:2;
                          `;
        commentDelete.style.cssText = `
                          width:15px;
                          position:absolute;
                          top:2px;
                          right:2px;
                          display:none;
                          `;

        comment.addEventListener("mouseenter", () => {
            commentDelete.style.display = "block";
        });

        comment.addEventListener("mouseleave", () => {
            commentDelete.style.display = "none";
        });
        if (commentContent.value === "") {
            commentModal.style.display = "none";
        } else {
            comment.textContent = commentContent.value;
            commentDelete.addEventListener("click", () => {
                event.stopPropagation();
                comment.remove();
            });
            comment.appendChild(commentDelete);
            innerContent.appendChild(comment);
            commentModal.style.display = "none";
            comment.style.display = "block";
        }
    }
</script>