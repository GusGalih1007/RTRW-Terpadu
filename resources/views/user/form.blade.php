@extends('layout.dashboard.app')
@section('title', $data ? 'Update User' : 'Tambah User')
@section('main-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ $data ? 'Update data ' . $data->username : 'Tambah data pengguna' }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Tambahkan data warga {{ Auth::user()->role->roleName == 'Admin' ? 'dan Ketua RT/RW ' : '' }} yang ada
                        di daerahmu.
                        Pastikan data yang dimasukkan sudah lengkap dan sesuai dengan data asli milik warga
                    </p>
                    <h5 class="mb-4">Data Pribadi</h5>
                    <form method="POST" action="{{ route('user.store') }}">
                        @csrf

                        @if ($data)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="username" class="form-label">Nama Panjang<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Nama panjang..." value="{{ old('username', $data->username ?? '') }}">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" id="email" class="form-control" value="{{ old('email', $data->email ?? '') }}" name="email"
                                    placeholder="contoh@email.com...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="nik" class="form-label">NIK<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="nik" id="nik" value="{{ old('nik', $data->nik ?? '') }}"
                                    placeholder="16 digit NIK...">
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="phone" class="form-label">No. Telepon<span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="phone" id="phone" value="{{ old('phone', $data->phone ?? '') }}"
                                    placeholder="Telepon...">
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="pekerjaan" class="form-label">Pekerjaan<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $data->pekerjaan ?? '') }}"
                                    placeholder="Pekerjaan saat ini...">
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="anggotaKeluarga" class="form-label">Anggota Keluarga<span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="anggotaKeluarga" id="anggotaKeluarga" value="{{ old('anggotaKeluaga', $data->anggotaKeluarga ?? '') }}"
                                    placeholder="Jumlah anggota...">
                            </div>
                        </div>
                        <div class="row">
                                <label for="status">Status<span
                                        class="text-danger">*</span></label>
                            <div class="form-group">
                                <select class="form-select" id="status">
                                <option value="active" selected>Active</option>
                                <option value="inactive" {{ $data ? ($data->status->value == 'inactive' ? 'selected' : '') : '' }}>InActive</option>
                                </select>
                            </div>
                        </div>
                        <hr class="hr-horizontal">
                        <h5 class="mb-4">Alamat</h5>
                        <div class="row">
                            @if (Auth::user()->role->roleName != 'Sub-Admin')
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="kodeProvinsi" class="form-label">Provinsi<span
                                            class="text-danger">*</span></label>
                                    <select name="kodeProvinsi" class="form-select" id="kodeProvinsi">
                                        <option value="" hidden selected>Pilih Provinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province['id'] }}"
                                                {{ $data ? ($data->kodeProvinsi == $province['id'] ? 'selected' : '') : '' }}>
                                                {{ $province['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="kodeKabupaten" class="form-label">Kabupaten<span
                                            class="text-danger">*</span></label>
                                    <select name="kodeKabupaten" class="form-select" id="kodeKabupaten" disabled>
                                        <option value="" hidden selected>Pilih Kabupaten</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="kodeKecamatan" class="form-label">Kecamatan<span
                                            class="text-danger">*</span></label>
                                    <select name="kodeKecamatan" class="form-select" id="kodeKecamatan" disabled>
                                        <option value="" hidden selected>Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="kodeKelurahan" class="form-label">Kelurahan<span
                                            class="text-danger">*</span></label>
                                    <select name="kodeKelurahan" class="form-select" id="kodeKelurahan" disabled>
                                        <option value="" hidden selected>Pilih Kelurahan</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="rtrw" class="form-label">Nomor RT/RW<span
                                            class="text-danger">*</span></label>
                                    <select name="rtrw" class="form-select" id="rtrw" disabled>
                                        <option value="" hidden selected>Pilih RT/RW</option>
                                    </select>
                                </div>
                            @endif
                            <div class="form-group {{ Auth::user()->role->roleName != 'Sub-Admin' ? 'col-md-9 col-sm-12' : ''}}">
                                <label for="alamatDetail" class="form-label">Alamat Rumah<span
                                        class="text-danger">*</span></label>
                                <textarea name="alamatDetail" class="form-control" id="alamatDetail" placeholder="Jalan, Nomor rumah, dll...">{{old('alamatDetail', $data->alamatDetail ?? '')}}</textarea>
                            </div>
                        </div>
                        <hr class="hr-horizontal">
                        <h5 class="mb-4">Password</h5>
                        <p class="alert alert-warning">Catatan penting! Data password yang akan anda masukan merupakan
                            password yang akan digunakan oleh
                            pengguna yang anda catat. Pastikan jangan bagikan kepada siapapun kecuali pemilik akun.
                            Penyalahgunaan data
                            sepenuhnya tanggung jawab pengguna akun dan anda sebagai pembuat akun
                        </p>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password" class="form-label">Password<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="password" id="password"
                                    placeholder="Min: 8 karakter...">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="Ulangi password anda...">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('user.index') }}" class="btn btn-dark text-white">kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('rtrwForm');
        const submitBtn = document.getElementById('submitBtn');

        // Wilayah data loading
        const provinsiSelect = document.getElementById('kodeProvinsi');
        const kabupatenSelect = document.getElementById('kodeKabupaten');
        const kecamatanSelect = document.getElementById('kodeKecamatan');
        const kelurahanSelect = document.getElementById('kodeKelurahan');
        const rtRwSelect = document.getElementById('rtrw');

        // Load kabupaten when provinsi changes
        provinsiSelect.addEventListener('change', function() {
            const provinsiId = this.value;
            kabupatenSelect.innerHTML = '<option value="">Memuat...</option>';
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            rtRwSelect.innerHTML = '<option value="" hidden selected>Pilih RT/RW</option>';
            rtRwSelect.disabled = true;
            
            kabupatenSelect.disabled = false;
            kecamatanSelect.disabled = true;
            kelurahanSelect.disabled = true;

            if (provinsiId) {
                fetch(`/api/wilayah/regencies/${provinsiId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Regencies data:', data);
                        kabupatenSelect.innerHTML =
                            '<option value="">Pilih Kabupaten/Kota</option>';

                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(kabupaten => {
                                const option = document.createElement('option');
                                option.value = kabupaten.id;
                                option.textContent = kabupaten.name;
                                kabupatenSelect.appendChild(option);
                            });
                        } else {
                            kabupatenSelect.innerHTML = '<option value="">Tidak ada data</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching regencies:', error);
                        kabupatenSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    });
            } else {
                kabupatenSelect.disabled = true;
                kecamatanSelect.disabled = true;
                kelurahanSelect.disabled = true;
            }
        });

        // Load kecamatan when kabupaten changes
        kabupatenSelect.addEventListener('change', function() {
            const kabupatenId = this.value;
            kecamatanSelect.innerHTML = '<option value="">Memuat...</option>';
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            rtRwSelect.innerHTML = '<option value="" hidden selected>Pilih RT/RW</option>';
            rtRwSelect.disabled = true;
            
            kecamatanSelect.disabled = false;
            kelurahanSelect.disabled = true;

            if (kabupatenId) {
                fetch(`/api/wilayah/districts/${kabupatenId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Districts data:', data);
                        kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(kecamatan => {
                                const option = document.createElement('option');
                                option.value = kecamatan.id;
                                option.textContent = kecamatan.name;
                                kecamatanSelect.appendChild(option);
                            });
                        } else {
                            kecamatanSelect.innerHTML = '<option value="">Tidak ada data</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching districts:', error);
                        kecamatanSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    });
            } else {
                kecamatanSelect.disabled = true;
                kelurahanSelect.disabled = true;
            }
        });

        // Load kelurahan when kecamatan changes
        kecamatanSelect.addEventListener('change', function() {
            const kecamatanId = this.value;
            kelurahanSelect.innerHTML = '<option value="">Memuat...</option>';
            rtRwSelect.innerHTML = '<option value="" hidden selected>Pilih RT/RW</option>';
            rtRwSelect.disabled = true;
            
            kelurahanSelect.disabled = false;

            if (kecamatanId) {
                fetch(`/api/wilayah/villages/${kecamatanId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Villages data:', data);
                        kelurahanSelect.innerHTML =
                            '<option value="">Pilih Kelurahan/Desa</option>';

                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(kelurahan => {
                                const option = document.createElement('option');
                                option.value = kelurahan.id;
                                option.textContent = kelurahan.name;
                                kelurahanSelect.appendChild(option);
                            });
                        } else {
                            kelurahanSelect.innerHTML = '<option value="">Tidak ada data</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching villages:', error);
                        kelurahanSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    });
            } else {
                kelurahanSelect.disabled = true;
            }
        });

        // Load RT/RW when kelurahan changes
        kelurahanSelect.addEventListener('change', function() {
            const kelurahanId = this.value;
            rtRwSelect.innerHTML = '<option value="" hidden selected>Memuat...</option>';
            rtRwSelect.disabled = true;

            if (!kelurahanId) {
                rtRwSelect.innerHTML = '<option value="" hidden selected>Pilih RT/RW</option>';
                rtRwSelect.disabled = true;
                return;
            }

            fetch(`/api/rt-rw/kelurahan/${kelurahanId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    // Clear and set placeholder
                    rtRwSelect.innerHTML = '<option value="" hidden selected>Pilih RT/RW</option>';

                    if (Array.isArray(data) && data.length > 0) {
                        data.forEach(rtrw => {
                            const option = document.createElement('option');
                            option.value = rtrw.rtRwId;
                            option.textContent = rtrw.rt + '/' + rtrw.rw;
                            rtRwSelect.appendChild(option);
                        });
                        rtRwSelect.disabled = false;
                    } else {
                        const noDataOption = document.createElement('option');
                        noDataOption.value = '';
                        noDataOption.textContent = 'Tidak ada data RT/RW';
                        noDataOption.disabled = true;
                        rtRwSelect.appendChild(noDataOption);
                        rtRwSelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error fetching RT/RW:', error);
                    rtRwSelect.innerHTML = '<option value="">Gagal memuat data</option>';
                    rtRwSelect.disabled = false;
                });
        });

        // Form validation
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (field.value.trim() === '') {
                    isValid = false;
                    field.style.borderColor = 'var(--danger-color)';
                } else {
                    field.style.borderColor = 'var(--border-color)';
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi (*)');
                return false;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = 'Sedang Memproses...';
        });

        // Set initial disabled states
        kabupatenSelect.disabled = true;
        kecamatanSelect.disabled = true;
        kelurahanSelect.disabled = true;
        rtRwSelect.disabled = true;
    });
</script>
