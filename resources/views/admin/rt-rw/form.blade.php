@extends('layout.dashboard.app')
@section('title', $data ? 'Update User' : 'Tambah User')
@section('main-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">
                            {{ $data ? 'Update data ' . $data->rt . '/' . $data->rw : 'Tambah data RT-RW' }}</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>
                        Tambahkan data RT-RW yang ada di daerahmu.
                        Pastikan data yang dimasukkan sudah lengkap dan sesuai dengan data asli daerah
                    </p>
                    <form method="POST"
                        action="{{ $data ? route('admin.rt-rw.update', $data->rtRwId) : route('admin.rt-rw.store') }}"
                        id="rtrwForm">

                        {{ csrf_field() }}

                        @if ($data)
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="rt" class="form-label">RT *</label>
                                <input type="number" name="rt" id="rt" value="{{ old('rt', $data->rt ?? '') }}"
                                    class="form-control" placeholder="001" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="rw" class="form-label">RW *</label>
                                <input type="number" name="rw" id="rw" value="{{ old('rw', $data->rw ?? '') }}"
                                    class="form-control" placeholder="001" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="kodeProvinsi" class="form-label">Provinsi *</label>
                                <select id="kodeProvinsi" class="form-select" name="kodeProvinsi" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province['id'] }}"
                                            {{ $data ? ($data->kodeProvinsi == $province['id'] ? 'selected' : '') : '' }}>
                                            {{ $province['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kodeProvinsi')
                                    <div class="error-message" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="kodeKabupaten" class="form-label">Kabupaten/Kota <span class="required">*</span></label>
                                <select class="form-select" id="kodeKabupaten" name="kodeKabupaten" required disabled>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                                @error('kodeKabupaten')
                                    <div class="error-message" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="kodeKecamatan" class="form-label">Kecamatan <span class="required">*</span></label>
                                <select class="form-select" id="kodeKecamatan" name="kodeKecamatan" required disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('kodeKecamatan')
                                    <div class="error-message" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="kodeKelurahan" class="form-label">Kelurahan/Desa <span class="required">*</span></label>
                                <select class="form-select" id="kodeKelurahan" name="kodeKelurahan" required disabled>
                                    <option value="">Pilih Kelurahan/Desa</option>
                                </select>
                                @error('kodeKelurahan')
                                    <div class="error-message" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="alamatDetail" class="form-label">Alamat Detail</label>
                                <textarea name="alamatDetail" class="form-control" id="alamatDetail" placeholder="Jl. Manggis No. 3...">{{ $data->alamatDetail ?? '' }}</textarea>
                            </div>
                        </div>
                        <button type="submit" id="submitBtn" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.rt-rw') }}" class="btn btn-light">Kembali</a>
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

        // Load kabupaten when provinsi changes
        provinsiSelect.addEventListener('change', function() {
            const provinsiId = this.value;
            kabupatenSelect.innerHTML = '<option value="">Memuat...</option>';
            kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
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
    });
</script>
