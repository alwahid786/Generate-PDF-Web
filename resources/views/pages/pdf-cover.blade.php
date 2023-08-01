@extends('layouts.layout-default')
@section('content')
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
                <h1>PDF Package Creator <span>14 Jul 2023</span></h1>
            </div>
        </div>
        <iframe src="https://docs.google.com/viewer?url=https://kodextech.com/Submittal_pkg.pdf&embedded=true">
        </iframe>
    </div>
</main>

@endsection
@section('insertjavascript')
@endsection