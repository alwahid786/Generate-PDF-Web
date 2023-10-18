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
            <div class="lightining-input-wrapper">
                <div class="lighting-legend-create my-3">
                    <div class="input-field-wrapper">
                        <div class="lightining-input">
                            <label for="">Type*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Manufacturer*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Description*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Part Number*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Lamp*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Voltage*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Dimming*</label>
                            <input type="text" />
                        </div>
                    </div>
                    <div class="lighting-img-wrapper">
                        <h1 class="">Image*</h1>
                        <img src="./dummy.jpg" alt="image" />
                    </div>
                </div>
                <div class="lighting-legend-create my-3">
                    <div class="input-field-wrapper">
                        <div class="lightining-input">
                            <label for="">Type*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Manufacturer*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Description*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Part Number*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Lamp*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Voltage*</label>
                            <input type="text" />
                        </div>
                        <div class="lightining-input">
                            <label for=""> Dimming*</label>
                            <input type="text" />
                        </div>
                    </div>
                    <div class="lighting-img-wrapper">
                        <h1 class="">Image*</h1>
                        <img src="./dummy.jpg" alt="image" />
                    </div>
                </div>
                <div class="legend-creator-btns">
                    <div class="legend-create-pdf">
                        <a href="#">Save or Update</a>
                    </div>
                    <div class="lightining-input-btn">
                        <a href="{{url('/lightining-cover')}}"> Create PDF</a>
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