@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style>
    body {
        background: #f6f6f6;
    }

    iframe {
        width: 100%;
        height: 100vh;

    }
</style>
@if(auth()->user()->is_admin==1)
@include('includes.admin.navbar')
@else
@include('includes.navbar')
@endif
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper">
            <div class="heading-top">
                <h1>PDF Package Creator <span>{{ date("F j, Y") }}</span></h1>
            </div>
        </div>

        {!! $pdfTemplate !!}

        {{-- <iframe src="">

        </iframe> --}}

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
    $(document).ready(function() {
        $('#detail-table').DataTable({
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "pageLength": 12,
            language: {
                'paginate': {
                    'previous': '<img class="my-1" src="{{asset("public/assets/images/rev.png")}}" alt="">',
                    'next': '<img class="my-1" src="{{asset("public/assets/images/for.png")}}" alt="">'
                }
            }
        });
    });
</script>
<script>
    $('.sidenav  li:nth-of-type(1)').addClass('active');
</script>


@endsection
