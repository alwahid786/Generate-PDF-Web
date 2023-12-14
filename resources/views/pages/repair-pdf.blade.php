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
                <h1>Repair Pdf</h1>
            </div>
        </div>

        <div class="contact-form">
            <h2 style="font-size: 18px;font-weight: bold;">Click on button to repair your corrupted PDF</h2>
            <br>
            <br>
            <a href="https://www.ilovepdf.com/repair-pdf" target="_blank">
                <button>Repair PDF</button>
            </a>
        </div>

    </div>
</main>
@endsection
@section('insertjavascript')

@endsection