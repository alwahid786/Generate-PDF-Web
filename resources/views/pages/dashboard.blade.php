@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style>
    body {
        background: #f6f6f6;
    }

    .form-control-sm {
        width: 300px !important;
        margin: 6px !important;
    }
</style>
@include('includes.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper">
            <div class="heading-top">
                <h1>Dashboard<span>{{date('d M Y')}}</span></h1>
            </div>
            <a href="{{(url('create-pdf'))}}" class="btn create-btn"><img class="mr-2" src="{{asset('public/assets/images/plus.png')}}" alt="">Create New Package</a>
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
                            <a href="{{(url('pdf-cover'))}}?packageTypeId=<?= $package['id']; ?>&is_view=true"><img class="my-1" src="{{asset('public/assets/images/view.png')}}" alt=""></a>
                            <a href="{{(url('create-pdf'))}}?packageInfoId=<?= $package['id']; ?>"><img class="my-1" src="{{asset('public/assets/images/edit.png')}}" alt=""></a>
                            <a href="{{(url('ligtening-legend'))}}?packageInfoId=<?= $package['id']; ?>"><img style="width: 30px;" class="my-1" src="{{asset('public/assets/images/add.png')}}" alt=""></a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="table-legend-outer">
            <div class="table-legend-wrapper">
                <a><img class="my-1" src="{{asset('public/assets/images/view.png')}}" alt="">View PDF</a>
                <a><img class="my-1" src="{{asset('public/assets/images/edit.png')}}" alt="">Edit PDF</a>
                <a><img style="width: 30px;" class="my-1" src="{{asset('public/assets/images/add.png')}}" alt="">Add Lightining Legends</a>
            </div>
        </div>

    </div>
</main>

{{-- delete modal --}}

<div class="modal" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title">Modal title</h5> --}}
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span> --}}
                {{-- </button> --}}
            </div>
            <div class="modal-body">
                <p style="font-size: 18px;">Are you sure you want to delete this data.</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('deletePackage') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="packageId">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

            </div>
        </div>
    </div>
</div>


@endsection




{{-- edit package --}}

{{-- <div class="modal" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
          <p style="font-size: 18px;">Are you sure you want to delete this data.</p>
        </div>
        <div class="modal-footer">
            <form action="{{ route('deletePackage') }}" method="post">
@csrf

</form>

</div>
</div>
</div>
</div> --}}



@section('insertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    function deleteFunction(id) {
        $("#packageId").val(id);
        $("#deleteModal").modal('show');
    }

    // function editFunction(id)
    // {

    //     $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    //     });

    //     $.ajax({

    //         url: '{{ route("getPackageData") }}',
    //         type: "POST",
    //         data: {id : id},
    //         dataType: 'json',

    //         success: function(data) {

    //             $('#')

    //         },

    //         error: function(data) {

    //         }

    //     });
    //     // $("#editModal").modal('show');
    // }
</script>
<script>
    $(document).ready(function() {
        $('#detail-table').DataTable({
            "ordering": false,
            "info": false,
            "searching": true,
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
    // $('.sidenav  li:nth-of-type(1)').addClass('active');
</script>
@endsection