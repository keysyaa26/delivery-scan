@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="text-center mb-4">
        <h4 class="fw-bold">Dashboard</h4>
    </div>

    @include('partials.card')

<script>
    function loadSummary() {
        fetch('/get-prepare-data')
            .then(response =>response.json())
            .then(data=> {
                console.log(data);
                const result = `${data.totalClosed} / ${data.totalOpen}`;
                document.getElementById('summaryPrepare').innerHTML = result;
            })
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadSummary();
    });
</script>
@endsection
