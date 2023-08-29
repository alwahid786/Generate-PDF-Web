@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

<style>
    .passwordBody {
        text-align: left !important;
        font-size: unset !important;
        padding-top: 25px !important;
    }

    .passwordModal .modal-content {
        padding: 1rem 0 !important;
        border-radius: 1rem !important;
    }

    .passwordModal .modal-content .modal-header h5 {
        padding-left: 1rem !important;
    }

    .passwordModal .modal-content .modal-header button {
        padding: 1rem 1.5rem !important;
    }
</style>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" onchange="changeUserStatus({{ $user->id }})" @if ($user->user_status=='approved' ) checked @endif data-id="{{ $user->id }}" class="custom-control-input user-status" id="customSwitch{{ $user->id }}">
                                <label class="custom-control-label" for="customSwitch{{ $user->id }}"></label>
                            </div>
                        </td>
                        <td>
                            <button title="Change Password" data-id="{{ $user->id }}" id="updatePassword" data-toggle="modal" data-target="#passwordModal" class="btn btn-info btn-sm" style="font-size: 12px;"><i class="fa fa-key" aria-hidden="true"></i></button>
                            <a href="#" title="Delete Profile" onclick="deleteFunction({{$user->id}})"><img class="my-1" src="{{asset('public/assets/images/delete.png')}}" alt=""></a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    </div>

    <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog passwordModal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Set Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="passwordForm" onsubmit="return checkValidation()" action="{{route('updatePassword')}}">
                    @csrf
                    <div class="modal-body passwordBody">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm password">
                        </div>
                        <input type="hidden" name="u_id" id="u_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                    <form action="{{ route('deleteUser') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('insertjavascript')
<script>
    $('body').addClass('bg-clr')
</script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>

<script>
    function deleteFunction(id) {
        $("#user_id").val(id);
        $("#deleteModal").modal('show');
    }

    function changeUserStatus(id) {
        // var checked = $('#userStatus').is(':checked');

        var isChecked = $("#customSwitch" + id).prop('checked');
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
                                'User status ' + title + ' successfully',
                                'success'
                            )
                        }
                    },
                    error: function(data) {

                    }

                });
            } else {
                $("#customSwitch" + id).prop('checked', reverse);
            }
        })


    }

    $(document).ready(function() {
        $('#detail-table').DataTable({
            "ordering": false,
            "info": false,
            "searching": false,
            "lengthChange": false,
            "pageLength": 10,
            language: {
                'paginate': {
                    'previous': '<img class="my-1" src="{{asset("public/assets/images/rev.png")}}" alt="">',
                    'next': '<img class="my-1" src="{{asset("public/assets/images/for.png")}}" alt="">'
                }
            }
        });
    });

    $("#updatePassword").click(function() {
        id = $(this).attr("data-id");
        $("#u_id").val(id);
    });


    function checkValidation() {
        error = 0;
        $("#passwordForm input").each(function() {
            if ($(this).val() == "") {
                error++;
                $(this).css('border', '1px solid red');
            } else {
                $(this).css('border', '1px solid #ced4da');
            }
        });

        if (error == 0) {
            if ($("#password").val() != $("#confirmPassword").val()) {
                alert('Password and Confirm password should match.');
                return false;
            }
            return true;
        }
        return false;
    }
</script>



<script>
    $('.sidenav  li:nth-of-type(2)').addClass('active');
</script>
@endsection