@extends('layouts.app', ['title' => 'Detail Admin'])

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Transaksi</h5>

            @if(request()->is('view-more-admin') )
                @include('partials.transaksi.admin', ['data' => $dataAdmin])
            @elseif(request()->is('view-more-prepare'))
                @include('partials.transaksi.prepare', ['data' => $dataPrepare])
            @elseif(request()->is('view-more-checked'))
                @include('partials.transaksi.checked', ['data' => $dataChecked])
            @elseif(request()->is('view-more-sj'))
                @include('partials.transaksi.surat-jalan', ['data' => $dataSJ])
            @elseif(request()->is('view-more-loading'))
                @include('partials.transaksi.surat-jalan', ['data' => $dataSJ])
            @endif
        </div>
    </div>
</div>
@endsection
