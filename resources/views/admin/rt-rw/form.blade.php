<center>
    <h2>{{ $data ? 'Mengupdate Data RT/RW ' . $data->nomor : 'Menambah Data RT/RW' }}</h2>
    <form method="POST" action="{{ $data ? route('admin.rt-rw.update', $data->rtRwId) : route('admin.rt-rw.store') }}"
        id="rtrwForm">

        {{ csrf_field() }}

        @if ($data)
            @method('PUT')
        @endif

        <label for="rt">RT *</label><br>
        <input type="number" name="rt" id="rt" value="{{ old('rt', $data->rt ?? '') }}" required><br><br>
        <label for="rw">RW *</label><br>
        <input type="number" name="rw" id="rw" value="{{ old('rw', $data->rw ?? '') }}" required><br><br>
        <label for="kodeProvinsi">Provinsi *</label><br>
        <select id="kodeProvinsi" name="kodeProvinsi" required><br><br>
            <option value="">Pilih Provinsi</option>
            @foreach ($provinces as $province)
                <option value="{{ $province['id'] }}" {{ $data ? ($data->kodeProvinsi == $province['id'] ? 'selected' : '') : '' }}>
                    {{ $province['name'] }}
                </option>
            @endforeach
        </select><br><br>
        @error('kodeProvinsi')
            <div class="error-message" style="display: block;">{{ $message }}</div>
        @enderror

        <label for="kodeKabupaten">Kabupaten/Kota <span class="required">*</span></label><br>
        <select id="kodeKabupaten" name="kodeKabupaten" required disabled>
            <option value="">Pilih Kabupaten/Kota</option>
        </select><br><br>
        @error('kodeKabupaten')
            <div class="error-message" style="display: block;">{{ $message }}</div>
        @enderror

        <label for="kodeKecamatan">Kecamatan <span class="required">*</span></label><br>
        <select id="kodeKecamatan" name="kodeKecamatan" required disabled>
            <option value="">Pilih Kecamatan</option>
        </select><br><br>
        @error('kodeKecamatan')
            <div class="error-message" style="display: block;">{{ $message }}</div>
        @enderror

        <label for="kodeKelurahan">Kelurahan/Desa <span class="required">*</span></label><br>
        <select id="kodeKelurahan" name="kodeKelurahan" required disabled>
            <option value="">Pilih Kelurahan/Desa</option>
        </select><br><br>   
        @error('kodeKelurahan')
            <div class="error-message" style="display: block;">{{ $message }}</div>
        @enderror

        <label for="alamatDetail">Alamat Detail</label><br>
        <textarea name="alamatDetail" id="alamatDetail" placeholder="Jl. Manggis No. 3...">{{ $data->alamatDetail ?? '' }}</textarea><br><br>
        
        <button type="submit" id="submitBtn">Simpan</button>
    </form>
</center>

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
                        kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';

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
                        kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';

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
