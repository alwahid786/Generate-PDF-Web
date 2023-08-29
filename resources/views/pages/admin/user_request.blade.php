@extends('layouts.layout-default')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>


    @include('includes.admin.navbar')
    <main class="content-wrapper">
        <div class="container-fluid py-3">
            <div class="header-wrapper">
                <div class="heading-top">
                    <h1>Dashboard <span>{{ date('d M Y') }}</span></h1>
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
                            <th>Aproval Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    @if(sizeof($users) >0)
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>

                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" onchange="changeUserStatus({{ $user->id }})" @if ($user->user_status=='approved' ) checked @endif  data-id="{{ $user->id }}" class="custom-control-input user-status" id="customSwitch{{ $user->id }}">
                                        <label class="custom-control-label" for="customSwitch{{ $user->id }}"></label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4">
                                No Data Found!
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

    <script>
        function changeUserStatus(id) {
            // var checked = $('#userStatus').is(':checked');

            var isChecked = $("#customSwitch"+id).prop('checked');
        if (isChecked == true) {
            var reverse = false;
            var title = 'Active';
            status = 'approved';
        } else {
            var reverse = true;
            var title = 'In Active';
            status = 'pending';
        }
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to update user status",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        url: '{{ route("update.status") }}',
                        type: "POST",
                        data: {
                            id: id,
                            status: status
                        },
                        dataType: 'json',

                        success: function(data) {
                            if (data.status === true) {
                                Swal.fire(
                                    'Updated!',
                                    'User status '+title+' successfully',
                                    'success'
                                )
                            }
                        },
                        error: function(data) {

                        }

                    });
                }else{
                    $("#customSwitch"+id).prop('checked', reverse);
                }
            })


        }
        
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
        $('.sidenav  li:nth-of-type(2)').addClass('active');
    </script>
@endsection
