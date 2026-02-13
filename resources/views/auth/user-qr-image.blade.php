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
        $user->rtrw ? $user->rtrw->rtRwName : '',
        $kelurahanName,
        $kecamatanName,
        $kabupatenName,
        $provinsiName
    ]);
    $fullAlamat = implode(', ', $alamatParts);
@endphp

<center>
    <img id="qrImage" src="{{ asset('storage/' . $user->qrImage) }}" width="300" alt="{{ $user->username }}"><br>
    <div>
        <small>{{ $user->role->roleName === 'User' ? 'Warga' : 'Ketua RT/RW'}}</small><br>
        <small>{{ $user->username }}</small><br>
        <small>{{ $fullAlamat }}</small>
    </div>
</center>
