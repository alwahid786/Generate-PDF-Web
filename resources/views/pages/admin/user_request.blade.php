@extends('layouts.layout-default')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" onclick="changeUserStatus({{ $user->id }})"
                                            type="checkbox" role="switch" id="userStatus">
                                    </div>
                                </td>
                            </tr>
                        @endforeach

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

    <script>

        function changeUserStatus(id) {
            // var checked = $('#userStatus').is(':checked');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                url: '{{ route('update.status') }}',
                type: "POST",
                data: {
                    id: id
                },
                dataType: 'json',

                success: function(data) {

                },
                error: function(data) {

                }

            });
        }

    </script>



<script>
    $('.sidenav  li:nth-of-type(2)').addClass('active');
</script>


@endsection
