@extends('layouts.layout-default')
@section('content')
<style>
    body {
        background: #f6f6f6;
    }
</style>
@include('includes.navbar')
<main class="content-wrapper">
    <div class="container-fluid py-3">
        <div class="header-wrapper pb-3">
            <div class="heading-top">
                <h1>Contact Us</h1>
            </div>
        </div>
        <div class="contact-form">
            <form>
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Name:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Email:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="email">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Phone No:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Message:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <textarea name="" id=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>

    </div>
</main>
@endsection
@section('insertjavascript')
<script>
    $('.sidenav  li:nth-of-type(8)').addClass('active');
</script>
@endsection