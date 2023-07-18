@extends('layouts.layout-default')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-6 px-0">
            <div class="leftImgSection">
                <div class="heading">
                    <h3>Lorem Ipsum</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero, soluta cum? Vero inventore nam unde aut cumque eius? Dolore mollitia molestiae quidem facilis dolorum! Velit quae maxime nulla culpa asperiores.</p>
                </div>
                <div class="image text-center">
                    <img class="w-75 img-fluid" src="{{asset('assets/images/login.svg')}}" alt="login" />
                </div>
            </div>
        </div>
        <div class="col-6 px-0">
            <div class="rightFormSection text-center">
                <div class="logo text-center mt-3">
                    <img class="w-25" src="{{asset('assets/images/logo.svg')}}" alt="">
                </div>
                <div class="heading mt-3">
                    <h3 class="text-center">Welcome Back</h3>
                </div>
                <div class="contentForm mx-auto">
                    <div class="google mt-4">
                        <a class="text-center py-3" href="javascript:void(0)">
                            <img src="{{asset('assets/images/google.svg')}}" alt="signin with google" />
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-center my-4">
                        <div class="borderDiv"></div>
                        <div class="textDiv">OR LOGIN WITH EMAIL</div>
                        <div class="borderDiv"></div>
                    </div>
                    <div class="formSection mt-5">
                        <form action="">
                            <input type="email" name="email" id="email" class="emailInput px-3 py-1" placeholder="Email" />
                            <!-- <input type="password" name="email" id="email" /> -->
                            <div class="input-group mt-3">
                                <input type="password" class="form-control" placeholder="Password" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append bg-white">
                                    <span class="input-group-text bg-white" id="basic-addon2"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <a class="forgotPassword" href="javascript:void(0)">Forgot Password?</a>
                            </div>
                            <button type="submit" class="py-3 mt-5">Sign In</button>
                        </form>
                    </div>
                    <div class="text-center signUp mt-5">
                        <span>Don't have an account yet? <a href="javascript:void(0)">Sign Up</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('insertjavascript')
@endsection