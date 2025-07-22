@extends('layouts.app')

@section('content')
<div class="container mt-4">
<div class="card">
    <div class="card-body">
        <h4 class="mb-4">Data Waiting Post</h4>
        <form action="{{ route('wp.index') }}" method="GET" id="filterForm">
            <label for="customer" class="form-label">Tanggal Delivery</label>
            <div class="col-md-4">
                <input type="date" name="date" id="dateInput" class="form-control" value="{{ request('date') }}">
            </div>
        </form>
            <div class="mb-3">
                <label for="customer" class="form-label">Customer</label>
                <input type="text" name="customer" id="customer" class="form-control text-uppercase" value="{{$customer}}" readonly>
            </div>

            <div class="mb-3">
                <label for="customer" class="form-label">Cycle</label>
                <input type="text" name="cycle" id="cycle" class="form-control" value="{{$cycle}}" readonly>
            </div>


            <script>
                document.getElementById('dateInput').addEventListener('change', function () {
                    document.getElementById('filterForm').submit();
                });
            </script>

        <h4 class="mb-4">Data Manifest</h4>
        <div class="table-responsive-scroll">
            <table class="table table-bordered table-striped mt-2 table-hover table-sm text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Order</th>
                        <th>Manifest</th>
                        <th>Job No</th>
                        <th>Cycle</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($manifests as $manifest )
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $manifest->tanggal_order }}</td>
                        <td>{{ $manifest->dn_no }}</td>
                        <td>{{ $manifest->job_no }}</td>
                        <td>{{ $manifest->cycle }}</td> {{-- FIX: Added closing </td> here --}}
                        <td>
                            @if ($manifest->status === null)
                                {{-- Jika status null, tampilkan kosong --}}
                            @elseif ($manifest->status === 'OK')
                                <b style="color: green;">OK</b>
                            @elseif ($manifest->status === 'NG')
                                <b style="color: red;">NG</b>
                            @else
                                {{ $item->status }} {{-- Tampilkan status apa adanya jika bukan null, OK, atau NG --}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-danger mt-4">Kembali</a>
        <a href="{{ route('po.open-scan') }}" class="btn btn-primary mt-4">Scan Manifest</a>
    </div>
</div>
</div>
@endsection

