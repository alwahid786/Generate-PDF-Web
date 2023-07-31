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
                                    Verify OTP
                                </h1>
                            </a>
                        </div>

                    </div>
                    <div class="login-form">
                        <form action="{{route('verifyOtp')}}" method="POST">
                            @csrf
                            @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                <p class="m-0">{{ $error }}</p>
                                @endforeach
                            </div>
                            @endif
                            <div class="form-group login-email-field">
                                <div class="otp-inputs">
                                    <input type="text" maxlength="1" name="otp[]" class="form-control" id="input1" onkeyup="moveToNext(this, 'input2')" aria-describedby="emailHelp">
                                    -<input type="text" maxlength="1" name="otp[]" class="form-control" id="input2" onkeyup="moveToNext(this, 'input3')" aria-describedby="emailHelp">
                                    -<input type="text" maxlength="1" name="otp[]" class="form-control" id="input3" onkeyup="moveToNext(this, 'input4')" aria-describedby="emailHelp">
                                    -<input type="text" maxlength="1" name="otp[]" class="form-control" id="input4" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="d-flex justify-content-center login-button-outer">
                                <input type="hidden" name="otp_code" id="otpCode_d">
                                <button type="submit" class="btn  login-btn">
                                    Verify
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="sign-up-link pt-1">
                        Didn't received OTP? <a href="{{(url('reset-password'))}}">Check your email</a>
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
                OTP Varified
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

        // Combine OTP CODE 
        function combineOTP() {
            const otpInputs = document.querySelectorAll('input[name="otp[]"]');
            const otpValue = Array.from(otpInputs).map(input => input.value).join('');
            document.getElementById('otpCode_d').value = otpValue;
        }
        document.querySelector('form').addEventListener('submit', combineOTP);
    })
</script>
@endsection