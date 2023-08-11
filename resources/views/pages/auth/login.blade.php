@extends('layouts.layout-default')
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
                            <a href="{{url('/google')}}">
                                <img src="{{asset('public/assets/images/google-icon-logo.png')}}" />
                                <h1>
                                    Sign in with Google
                                </h1>
                            </a>
                        </div>
                        <div class="email-login-option pt-4">
                            <h1>OR LOGIN WITH EMAIL</h1>
                        </div>
                    </div>
                    <div class="login-form">
                        <form action="{{route('loginFunction')}}" method="POST" id="loginForm_d">
                            @csrf
                            @if(session()->has('signupSuccess'))
                            <div class="alert alert-success">
                                {{ session('signupSuccess') }}
                            </div>
                            @endif
                            @if(session()->has('passwordSuccess'))
                            <div class="alert alert-success">
                                {{ session('passwordSuccess') }}
                            </div>
                            @endif
                            @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                <p class="m-0">{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            <div class="form-group login-email-field">
                                <input type="email" name="email" class="form-control" id="loginemail" aria-describedby="emailHelp" placeholder="Email">
                            </div>
                            <div class="form-group login-email-field">
                                <i class="fa fa-eye-slash show-pass" aria-hidden="true"></i>
                                <i class="fa fa-eye hide-pass" aria-hidden="true"></i>
                                <input type="password" class="form-control" id="loginpassword" name="password" placeholder="Password">
                            </div>
                            <div class="reset-password ">
                                <div class="checkbox-input-wrapper">
                                    <input type="checkbox" id="vehicle1" name="Keep-me-logged-in" value="Keep me logged in">
                                    <h1>Keep me logged in</h1>
                                </div>

                                <a href="{{(url('reset-password'))}}">Forgot Password?</a>
                            </div>
                            <div class="d-flex justify-content-center login-button-outer">
                                <button type="submit" class="btn  login-btn">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="sign-up-link pt-1">
                        Don’t have an account yet?
                        <a href="{{(url('signup'))}}">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('insertjavascript')
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