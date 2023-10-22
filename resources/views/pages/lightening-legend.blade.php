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

            <div class="lightining-input-wrapper">

                @foreach ($fixtureTypes as $data)

                {{-- @foreach ($data->legends as $legendsData) --}}


                <div class="lighting-legend-create my-3">
                    <div class="input-field-wrapper">
                        <div class="lightining-input">
                            <label for="">Type*</label>
                            <input type="text" name="type[]" value="{{ $data->type }}" readonly />
                            <input type="hidden" name="fixture_id[]" value="{{ $data->id }}" />
                            <input type="hidden" name="pakage_info_id" value="{{ $packageInfoId }}" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Manufacturer*</label>
                            <input type="text" name="manufacturer[]" value="{{ $data->legends->manufacturer ?? '' }}" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Description*</label>
                            <input type="text" name="description[]" value="{{ $data->legends->description ?? '' }}" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Part Number*</label>
                            <input type="text" name="part_number[]" value="{{ $data->part_number ?? '' }}" readonly />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Lamp*</label>
                            <input type="text" name="lamp[]" value="{{ $data->legends->lamp ?? '' }}" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Voltage*</label>
                            <input type="text" name="voltage[]" value="{{ $data->legends->voltage ?? '' }}" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Dimming*</label>
                            <input type="text" name="dimming[]" value="{{ $data->legends->dimming ?? '' }}" />
                        </div>
                    </div>
                    <div class="lighting-img-wrapper">
                        <h1 class="">Image*</h1>
                        @if ($data->image_path != NULL)
                        <img src="{{ asset('public/files/'.$data->image_path) }}" alt="image" />
                        @else
                        <img src="{{ asset('public/assets/images/empty_image.jpg') }}" alt="">
                        @endif
                    </div>
                </div>

                {{-- @endforeach --}}

                @endforeach

                <div class="legend-creator-btns">
                    <div class="legend-create-pdf">
                        {{-- <a href="#">Save or Update</a> --}}
                        <button type="submit" style="width: 150px;height: 48px;border-radius: 8px;background: #003f77;color:white">Save or Update</button>
                    </div>
                    <div class="lightining-input-btn">
                        <a href="{{(url('legends-pdf'))}}?packageInfoId=<?= $packageInfoId ?>"> Create PDF</a>
                    </div>
                </div>

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