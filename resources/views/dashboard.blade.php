@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="text-center mb-4">
        <h4 class="fw-bold">Dashboard</h4>
    </div>

    @include('partials.card')

    @if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
    @endif

<script>
    function loadSummary() {
        fetch("{{ route('dataPrepare') }}")
            .then(response =>response.json())
            .then(data => {
                const result = `${data.totalClosed} / ${data.totalOpen}`;
                document.getElementById('summaryPrepare').innerHTML = result;
            })

        fetch("{{ route('dataAdmin') }}")
            .then(response => response.json())
            .then(data => {
                const result = `${data.totalPlan} / ${data.totalActual}`;
                document.getElementById('summaryAdmin').innerHTML = result;
            });
        fetch("{{ route('dataChecked') }}")
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const result = `${data.totalPlan} / ${data.totalActual}`;
                document.getElementById('summaryChecked').innerHTML = result;
            });
        fetch ("{{ route('dataSJ')}}")
            .then(response => response.json())
            .then(data => {
                const result = `${data.totalPlan} / ${data.totalActual}`;
                document.getElementById('summarySJ').innerHTML = result;
            });
        fetch ("{{ route('dataSJ')}}")
            .then(response => response.json())
            .then(data => {
                const result = `${data.totalPlan} / ${data.totalActual}`;
                document.getElementById('summaryLoading').innerHTML = result;
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadSummary();
    });
</script>
@endsection
