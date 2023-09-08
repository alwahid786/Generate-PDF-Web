<body style="background-color: #f6f6f6;">
    <div id="content"
        style="
        display:flex;
        flex-direction:column;
        align-items:center;
    margin: 0 auto;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
          Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue',
          sans-serif;
      ">
        <div style="
          height: 1056px;
width:816px;
          background-color: rgb(255, 255, 255);
          padding: 2rem;"
            class="main-page-wrapper">
            <div style="height: 50%; position: relative">
                <img src="{{ asset('public/assets/images/logo-icon.png') }}"
                    style="
              position: absolute;
              right: -150px;
              top: 50%;
              transform: translateY(-50%) rotate(-90deg);
              width: 500px;
            " />
            </div>
            <div
                style="
            height: 50%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 0 2rem;
          ">
                <?php
                $date = new DateTime($pdf_path[0]['fixture']['created_at']);
                $formattedDate = $date->format('d F Y');
                ?>
                <div>
                    <h1 style="font-size: 2.8rem; margin: 0" class="projectTitle">{{ $pdf_path[0]['fixture']['project'] }}</h1>
                    <h3 style="font-size: 17px;margin-top: 6px;margin-bottom: 4px;font-weight: bold;" class="projectTypeName">{{ $packageTypeName[0] }}</h3>
                    <p style="font-size: 14px;padding-top: 12px;">{{ $formattedDate }}</p>
                </div>
                <div
                    style="
              display: flex;
              align-items: center;
              justify-content: space-between;
            ">
                    <div><img src="{{ asset('public/assets/images/logo-icon.png') }}" style="width: 170px" /></div>
                    <div>
                        <a href="https://visionz.ca/"
                            style="text-decoration: none; color: black; font-size: 17px">visionz.ca</a>
                    </div>
                    <div>
                        <p style="font-size: 17px; margin: 0">437-886-9837</p>
                    </div>
                    <div>
                        <a href="mailto:projects@visionz.ca"
                            style="text-decoration: none; color: black; font-size: 17px">projects@visionz.ca</a>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($pdf_path as $index => $path)
            @php
                $currentPage = $index + 1;
            @endphp
            <div style="height: 1056px; width:816px; padding: 2rem; background-color: rgb(255, 255, 255);"
                class="body-page-wrapper">
                <div class="table-wrapper" style="border: 1px solid; ">
                    <div class="table-header" style="height: 70px; display: flex; border-bottom: 1px solid black">
                        <div style="width: 20%;border-right: 1px solid black;text-align: center;padding: 10px 0px;">
                            <img style="width: 120px; margin: 0 auto"
                                src="{{ asset('public/assets/images/side-logo.png') }}" alt="" />
                        </div>
                        <div style="width: 25%; border-right: 1px solid black; padding: 2px 0px">
                            <h1 style="margin: 0; font-size: 1.2rem; text-align: center">
                                Project
                            </h1>
                            <p
                                style="margin: 0; text-align: center; font-size: 0.9rem; word-break:break-all; padding:0 0.5rem">
                                {{ $path['fixture']['project'] }}
                            </p>
                        </div>
                        <div style="width: 30%; border-right: 1px solid black; padding: 2px 0px">
                            <h1 style="margin: 0; font-size: 1.2rem; text-align: center;">
                                Part Number
                            </h1>
                            <p
                                style="margin: 0; text-align: center; font-size: 0.9rem; word-break:break-all; padding:0 0.5rem">
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
                                {{ $path['fixture']['type'] }}</h1>
                        </div>
                    </div>

                    <div class="pdf-content"
                        style="height: 890px; width:100%; display:flex; justify-content:center; align-items:center">
                        <img class="body-images" style="max-width:100%" src="{{ $path['path'] }}" alt="">
                        {{-- <img src="{{asset('public/assets/images/Capture.png')}}" alt="" style="width: 100%" /> --}}
                    </div>

                    <div class="table-footer"
                        style="height: 37px; display: flex; border-top: 1px solid black; padding: 8px 0px">
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
</body>

<div class="d-flex justify-content-center align-items-center mt-5">
    <button style="background: #5757c8;color: white;width: 250px;height: 60px;border-style: none;border-radius: 5px;"
        id="convertBtn">Download to PDF</button>
    @if (!$is_view)
        <a href="{{ url('create-pdf') }}?packageInfoId=<?= $typeId ?>"><button
                style="background: black;color: white;width: 250px;height: 60px;border-style: none;border-radius: 5px;margin-left: 5px">Go
                back to Edit</button></a>
    @endif
    <div>
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
