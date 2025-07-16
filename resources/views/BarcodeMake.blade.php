
@php
use Milon\Barcode\Facades\DNS1D;
@endphp

@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2>Barcode Generator</h2>
    <p>{{ $data }}</p>
    <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode">
</div>
@endsection
