@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

@include('includes.admin.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper">
            <div class="heading-top">
                <h1>Dashboard <span>{{date('d M Y')}}</span></h1>
            </div>
        </div>

        @if (\Session::has('error'))
        <div class="alert alert-danger">
            <div>
                <div>{{ \Session::get('error') }}</div>
            </div>
        </div>
        @endif
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <div>
                    <div>{{ \Session::get('success') }}</div>
                </div>
            </div>
        @endif

        <div class="client-table ">
            <table id="detail-table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                </tbody>
            </table>
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
    $('.sidenav  li:nth-of-type(2)').addClass('active');
</script>


@endsection
