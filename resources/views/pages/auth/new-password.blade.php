@extends('layouts.layout-default')
<style>
    .login-content {
        justify-content: center !important;
        row-gap: 4rem !important;
    }
</style>

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 login-banner-left px-0">
            <div class="login-logo">
                <div class="logo-icon text-center">
                    <img src="{{asset('public/assets/images/login-logo.png')}}" alt="image">
                    <h1>PDF Package Creator</h1>
                </div>
                <div class="login-left-description mt-5">
                    <p>The creation of Project Specifications, Submittals, and Record Drawing Packages, made easy. This flow through process will enable the creation of drawings to be carried out in a few simple steps. Information can be copy and pasted from other
                        sources, or manually entered into the system</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 px-0 ">
            <div class="login-content-outer">
                <div class="login-content py-lg-2">
                    <div class="login-heading text-center">
                        <img src="{{asset('public/assets/images/login-logo.png')}}" alt="image">
                        <h1>#BringingConceptsToLight</h1>
                    </div>
                    <div class="signin-options">
                        <div class="sign-in-google">
                            <a href="#">
                                <h1>
                                    Reset Password
                                </h1>
                            </a>
                        </div>

                    </div>
                    <div class="login-form">
                        <form action="{{route('resetPassword')}}" method="POST">
                            @csrf
                            @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                <p class="m-0">{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            <div class="form-group login-email-field">
                                <i class="fa fa-eye-slash show-pass" aria-hidden="true"></i>
                                <i class="fa fa-eye hide-pass" aria-hidden="true"></i>
                                <input type="password" class="form-control" id="loginpassword" name="password" placeholder="Password">
                            </div>
                            <div class="form-group login-email-field">
                                <i class="fa fa-eye-slash show-pass" aria-hidden="true"></i>
                                <i class="fa fa-eye hide-pass" aria-hidden="true"></i>
                                <input type="password" class="form-control" id="loginpassword" name="password_confirmation" placeholder="Confirm Password">
                            </div>
                            <div class="d-flex justify-content-center login-button-outer">
                                <button type="submit" class="btn  login-btn">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>


        </div>

    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{asset('public/assets/images/success-tick.png')}}" alt="image">
            </div>
            <div class="modal-body">
                Password Reset Successfully
            </div>
        </div>
    </div>
</div>
@endsection
@section('insertjavascript')
<script>
    function moveToNext(currentInput, nextInputId) {
        if (currentInput.value.length === currentInput.maxLength) {
            document.getElementById(nextInputId).focus();
        }
    }
</script>
<script>
    $(document).ready(function() {
        $("#input1").focus();
    })
</script>
<script>
    $(document).ready(function() {

        $('.show-pass, .hide-pass').on('click', function() {
            var formGroup = $(this).closest('.form-group');
            var passwordInput = formGroup.find('input');
            if (passwordInput.attr('type') === 'password') {
                passwordInput.attr('type', 'text');
            } else {
                passwordInput.attr('type', 'password');
            }
        });
    });
</script>
In this code, when you click on the eye icon, it will toggle the visibility of the password in the corresponding input field (within the same form-group). The .closest() and .find() methods are used to navigate the DOM and select the relevant elements.







@endsection