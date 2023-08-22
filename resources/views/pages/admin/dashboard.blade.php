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
@include('includes.admin.navbar')
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


@endsection
