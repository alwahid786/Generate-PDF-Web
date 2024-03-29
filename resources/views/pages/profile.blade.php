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
@include('includes.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper">
            <div class="heading-top">
                <h1>Profile <span>{{ date("F j, Y") }}</span></h1>
            </div>
        </div>
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{{ \Session::get('success') }}</li>
            </ul>
        </div>
        @endif
        <form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="profile-body">
                <div class="profile-body-inner">
                    <div class="profile-img-wrapper">
                        <!-- <img src="{{asset('public/assets/images/test-image.jpg')}}"> -->

                        @if (auth()->user()->profile_img)
                        <img src="{{auth()->user()->profile_img ?? ''}}" id="profile-image">
                        @else
                        <span style="    font-weight: bold;
                        padding-bottom: 20px;
                    ">No Profile Image</span>
                        @endif

                        <div class="upload-file">
                            <label class="mb-0">
                                Upload Profile Pic
                                <input type="file" id="image-input" name="profile_img" class="validate" />
                            </label>
                        </div>
                        <p class="d-none" id="error-message" style="color: red;">File size should be less than or equal to 5 MB</p>
                    </div>
                    <div class="profile-detail-wrapper">
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Name</h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text" name="name" class="validate" value="{{auth()->user()->name ?? ''}}">
                            </div>
                        </div>
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Email </h1>
                            </div>
                            <div class="pdf-info-input">
                                <input type="text" disabled name="email" class="validate" value="{{auth()->user()->email}}">
                            </div>
                        </div>
                        <div class="pdf-info-input-wrapper">
                            <div class="section-heading">
                                <h1>Password</h1>
                            </div>
                            <div class="pdf-info-input password-field">
                                <i class="fa fa-eye-slash show-pass" aria-hidden="true"></i>
                                <i class="fa fa-eye hide-pass" aria-hidden="true"></i>
                                <input type="password" id="loginpassword" name="password" class="validate">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-update-btn">
                    <button type="submit" style="margin-top: 20px" class="login-btn">Update</button>
                    <!-- <button class="login-btn" data-toggle="modal" data-target="#exampleModal">Update</button> -->
                </div>
            </div>
        </form>
    </div>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{asset('public/assets/images/success-tick.png')}}" alt="image">
            </div>
            <div class="modal-body">
                Updated Successfully
            </div>
        </div>
    </div>
</div>
@endsection
@section('insertjavascript')
<script>
    $('.sidenav  li:nth-of-type(7)').addClass('active');
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('image-input').addEventListener('change', function(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const imageElement = document.getElementById('profile-image');
                const file = input.files[0];

                if (file.size <= 5 * 1024 * 1024) {
                    imageElement.src = URL.createObjectURL(file);
                    $('#error-message').addClass('d-none');
                } else {

                    $('#error-message').removeClass('d-none');

                    input.value = '';
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".hide-pass").hide();
        $(".show-pass").click(function() {
            $(this).hide();
            $(".hide-pass").show();
            $("#loginpassword").attr("type", "text")
        });
        $(".hide-pass").click(function() {
            $(this).hide();
            $(".show-pass").show();
            $("#loginpassword").attr("type", "password")
        });
        $("#loginemail").focus();
    });
</script>

@endsection
