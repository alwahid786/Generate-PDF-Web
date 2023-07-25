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
                        <form>
                            <div class="form-group login-email-field">
                                <input type="email" name="email" class="form-control" id="loginemail" aria-describedby="emailHelp" placeholder="Email">
                            </div>
                            <div class="d-flex justify-content-center login-button-outer">
                                <a href="{{(url('verify-otp'))}}" class="btn  login-btn">
                                    Send OTP
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>


        </div>

    </div>
</div>
@endsection
@section('insertjavascript')
@endsection