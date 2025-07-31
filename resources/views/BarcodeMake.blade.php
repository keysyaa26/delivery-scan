<!DOCTYPE html>
<html>
<head>
    <title>QR Code List</title>
    <style>
        .qr-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px;
        }
        .qr-box {
            text-align: center;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
            width: 200px;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Daftar QR Code</h2>

<div class="qr-container">
    @foreach ($dataList as $data)
        <div class="qr-box">
            {!! QrCode::size(150)->generate(json_encode($data)) !!}
            <p><strong>{{ $data['customer'] }} -  {{ $data['route'] }} - {{ $data['cycle'] }}</strong></p>
        </div>
    @endforeach
</div>

</body>
</html>
