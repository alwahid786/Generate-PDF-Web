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

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ \Session::get('success') }}</li>
                </ul>
            </div>
        @endif

        <div class="contact-form">
            <form method="post" action="{{ route('contactUs') }}">
                @csrf
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Name:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="name">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Email:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="email" name="email" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Phone No:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <input type="text" name="phone_number" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="pdf-info-input-wrapper">
                        <div class="section-heading">
                            <h1>Message:</h1>
                        </div>
                        <div class="pdf-info-input">
                            <textarea name="description" id="" required></textarea>
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
