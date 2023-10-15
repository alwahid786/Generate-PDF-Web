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
                <h1>Lightening Legend Creator <span>{{ date('d M Y') }}</span></h1>
            </div>
        </div>
        <form action="{{ route('legends.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- -------------------Upper body------------------------ -->

            <div class="create-pdf-uper-body">


                @foreach($fixtureTypes as $key => $type)
                <!-- <h2>{{ $type->type }}</h2> -->

                <div class="project-input-wrapper">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Type: * </h1>
                        </div>

                        <div class="pdf-info-input">
                            <input type="text" name="fixture_type[{{ $key }}]" value="{{ $type->type }}" id="projectName" class="typeValidation" disabled>
                            <input type="hidden" name="fixture_id[{{ $key }}]" value="{{ $type->id }}" id="" class="typeValidation">
                            <p style="color: red" id="warning-message"></p>
                        </div>

                    </div>
                    @foreach($type->legends as $legend)
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Manufacturer: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="manufacturer[{{ $key }}]" value="{{ $legend->manufacturer ?? '' }}" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Description: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="description[{{ $key }}]" value="{{ $legend->description ?? '' }}" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Part Number: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="part_number[{{ $key }}]" value="{{ $legend->part_number ?? '' }}" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Lamp: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="lamp[{{ $key }}]" value="{{ $legend->lamp ?? '' }}" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Voltage: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="voltage[{{ $key }}]" value="{{ $legend->voltage ?? '' }}" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Dimming: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="dimming[{{ $key }}]" value="{{ $legend->dimming ?? '' }}" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    @endforeach
                </div>


                @endforeach

                <button class="btn btn-primary">Save or Update</button>
                <button class="btn btn-primary">Create Pdf</button>

                <!-- <div class="project-input-wrapper">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Type: * </h1>
                        </div>

                        <div class="pdf-info-input">
                            <input type="text" name="project" value="" id="projectName" class="typeValidation">
                            <p style="color: red" id="warning-message"></p>
                        </div>

                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Manufacturer: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" value="" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Description: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" value="" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Part Number: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" value="" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Lamp: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" value="" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Voltage: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" value="" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Dimming: *</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="reference" value="" id="referenceNo" class="typeValidation">
                            <p style="color: red" id="warning-message-ref"></p>
                        </div>
                    </div>
                </div> -->

            </div>



        </form>
</main>
@endsection
@section('insertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



@endsection