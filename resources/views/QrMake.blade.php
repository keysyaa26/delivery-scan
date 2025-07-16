@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h4>🔳 QR Code untuk Session Aktif</h4>

    @if($qrText)
        <div class="my-4">
            {!! QrCode::size(250)->generate($qrText) !!}
        </div>

        <pre class="text-start bg-light p-3 rounded">
{{ $qrText }}
        </pre>
    @else
        <p>Tidak ada data session yang aktif.</p>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">← Kembali</a>
</div>
@endsection
