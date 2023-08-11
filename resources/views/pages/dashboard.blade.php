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
                <h1>Dashboard <span>{{date('d M Y')}}</span></h1>
            </div>
            <a href="{{(url('create-pdf'))}}" class="btn create-btn"><img class="mr-2" src="{{asset('public/assets/images/plus.png')}}" alt="">Create New Package</a>
        </div>

        <div class="client-table ">
            <table id="detail-table" style="width:100%">
                <thead>
                    <tr>
                        <th>Reference#</th>
                        <!-- <th>User</th> -->
                        <th>Project</th>
                        <th>Date Created </th>
                        <th>Date Last Edit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($packageInfo) > 0)
                    @foreach($packageInfo as $package)
                    <tr>
                        <td data-column="Reference#">{{$package['vision_reference'] ?? 'N/A'}}</td>
                        <!-- <td data-column="User">John Smith</td> -->
                        <td data-column="Project">{{$package['package_name'] ?? 'N/A'}}</td>
                        <td data-column="Date Created">{{date('M d, Y', strtotime($package['created_at']))}}</td>
                        <td data-column="Date Last Edit">{{date('M d, Y h:i:s', strtotime($package['updated_at']))}}</td>
                        <td class="action-btn" data-column="Actions">
                            <a href="{{(url('pdf-cover'))}}?packageTypeId=<?= $package['id']; ?>"><img class="my-1" src="{{asset('public/assets/images/view.png')}}" alt=""></a>
                            <a href="#"><img class="my-1" src="{{asset('public/assets/images/edit.png')}}" alt=""></a>
                            <a href="#"><img class="my-1" src="{{asset('public/assets/images/delete.png')}}" alt=""></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
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