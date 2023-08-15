<body style="background-color: #f6f6f6;">
    <div id="content"
        style="
    margin: 0 auto;
        max-width: 968px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI',
          Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue',
          sans-serif;
      ">
        <div style="
          height: 1355px;
          background-color: rgb(255, 255, 255);
          padding: 2rem;">
            <div style="height: 50%; position: relative">
                <img src="{{ asset('public/assets/images/logo-icon.png') }}"
                    style="
              position: absolute;
              right: -200px;
              top: 50%;
              transform: translateY(-50%) rotate(-90deg);
              width: 600px;
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
                    $date = new DateTime($object['created_at']);
                    $formattedDate = $date->format('d F Y');
                ?>
                <div>
                    <h1 style="font-size: 2.8rem; margin: 0" class="projectTitle">{{ $object['project'] }}</h1>
                    {{-- <h3 style="font-size: 2.2rem; margin-top: 0; margin-bottom: 20px">
                        Submittal Package
                    </h3> --}}
                    <p style="font-size: 1.5rem; margin: 0">{{ $formattedDate }}</p>
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
            <div style="height: 1355px; padding: 2rem; background-color: rgb(255, 255, 255);">
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
                            <p style="margin: 0; text-align: center; font-size: 0.9rem">
                                {{ $object['project'] }}
                            </p>
                        </div>
                        <div style="width: 30%; border-right: 1px solid black; padding: 2px 0px">
                            <h1 style="margin: 0; font-size: 1.2rem; text-align: center">
                                Part Number
                            </h1>
                            <p style="margin: 0; text-align: center; font-size: 0.9rem">
                                {{ $object['part_number'] }}
                            </p>
                            <p style="margin: 0; text-align: center; font-size: 0.9rem">
                                <strong>Visionz #</strong> {{ $object['vision_reference'] }}
                            </p>
                        </div>
                        <div style="width: 25%; padding: 2px 0px">
                            <h1 style="margin: 0; text-align: center; font-size: 1.2rem">
                                Type
                            </h1>
                            <h1 style="margin: 0; text-align: center; font-size: 1.8rem">L1</h1>
                        </div>
                    </div>

                    <div class="pdf-content" style="height: 1183px">
                        <img style="width: 100%; height: 100%" src="{{ $path }}" alt="">
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
</body>

<div class="d-flex justify-content-center align-items-center mt-5">
    <button style="background: #5757c8;color: white;width: 250px;height: 60px;border-style: none;border-radius: 5px;" id="convertBtn">Download to PDF</button>
<div>
<!-- Include the html2canvas library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    const convertBtn = document.getElementById("convertBtn");
    const contentDiv = document.getElementById("content");

    var projectTitles  = document.getElementsByClassName("projectTitle");
    if (projectTitles.length > 0) {
        var fileName = projectTitles[0].innerHTML;
    }

    const pdfOptions = {
        image: {
            type: "png",
            quality: 1.0
        }, // Use PNG and set maximum quality
        filename: `${fileName}.pdf`, // The default filename for the downloaded PDF
        html2canvas: {
            scale: 4
        }, // Increase the scale for better image quality (adjust as needed)
        jsPDF: {
            format: [250, 358.5]
        },
        // scale: 4,
    };
    convertBtn.addEventListener("click", () => {
        html2pdf().set(pdfOptions).from(contentDiv).save();
    });

    // function convertToPDF() {
    //     html2pdf().set(pdfOptions).from(contentDiv).save();
    // }

    // window.addEventListener("load", convertToPDF);
</script>