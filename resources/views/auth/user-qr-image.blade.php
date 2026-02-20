@php
    // Get wilayah names
    $wilayahService = app(\App\Services\WilayahService::class);
    $provinsi = $wilayahService->getProvinces();
    $kabupaten = $wilayahService->getRegencies($user->kodeProvinsi);
    $kecamatan = $wilayahService->getDistricts($user->kodeKabupaten);
    $kelurahan = $wilayahService->getVillages($user->kodeKecamatan);

    // Find names
    $provinsiName = collect($provinsi)->firstWhere('id', $user->kodeProvinsi)['name'] ?? '';
    $kabupatenName = collect($kabupaten)->firstWhere('id', $user->kodeKabupaten)['name'] ?? '';
    $kecamatanName = collect($kecamatan)->firstWhere('id', $user->kodeKecamatan)['name'] ?? '';
    $kelurahanName = collect($kelurahan)->firstWhere('id', $user->kodeKelurahan)['name'] ?? '';

    // Build alamat
    $alamatParts = array_filter([
        $user->alamatDetail,
        $user->rtrw ? $user->rtrw->nomor : '',
        $kelurahanName,
        $kecamatanName,
        $kabupatenName,
        $provinsiName,
    ]);
    $fullAlamat = implode(', ', $alamatParts);
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>QR Code {{ $user->username }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .qr-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .qr-section {
            margin-bottom: 20px;
        }

        .qr-image {
            width: 200px;
            height: 200px;
            border: 2px solid #007bff;
            border-radius: 8px;
            margin: 0 auto;
        }

        .info-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .status-badge {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .user-name {
            font-size: 18px;
            font-weight: bold;
            color: #000000;
            margin: 5px 0;
        }

        .user-address {
            font-size: 12px;
            color: #666;
            line-height: 1.4;
            margin-top: 5px;
        }

        .section-title {
            font-size: 14px;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            font-weight: bolder;
        }
    </style>
</head>

<body>
    <div class="qr-card">
        <div class="qr-section">
            <img class="qr-image" src="{{ public_path('storage/' . $user->qrImage) }}" alt="{{ $user->username }}">
        </div>

        <div class="info-section">
            <div class="status-badge">
                {{ $user->role->roleName === 'User' ? 'Warga: ' : 'Ketua RT/RW: ' . $user->rtrw->nomor }}
            </div>

            <div class="user-name">{{ $user->username }}</div>

            <div class="user-address">
                <div class="section-title">Alamat</div>
                <div>{{ $user->alamatDetail }}</div><br>
                <div class="section-title">Kelurahan</div>
                <div>{{ $kelurahanName }}</div><br>
                <div class="section-title">Kecamatan</div>
                <div>{{ $kecamatanName }}</div><br>
                <div class="section-title">Kabupaten</div>
                <div>{{ $kabupatenName }}</div><br>
                <div class="section-title">Provinsi</div>
                <div>{{ $provinsiName }}</div><br>
            </div>
        </div>
    </div>
</body>

</html>
