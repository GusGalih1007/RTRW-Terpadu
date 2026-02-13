<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Diri - RT/RW Terpadu</title>
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --bg-color: #f8f9fa;
            --card-bg: #ffffff;
            --text-color: #333;
            --border-color: #dee2e6;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 20px;
        }

        .header h1 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .header p {
            color: var(--secondary-color);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .required {
            color: var(--danger-color);
        }

        input[type="text"],
        input[type="number"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            background-color: #fff;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .form-row-4 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 20px;
        }

        .text-muted {
            font-size: 14px;
            color: var(--secondary-color);
            margin-top: 5px;
        }

        .btn {
            background-color: var(--primary-color);
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--primary-color);
            width: 0%;
            transition: width 0.3s ease;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: var(--secondary-color);
        }

        @media (max-width: 768px) {

            .form-row,
            .form-row-3,
            .form-row-4 {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 0 15px;
            }

            .card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>RT/RW Terpadu</h1>
                <p>Lengkapi Data Diri Anda</p>
            </div>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('auth.complete-profile.warga.post', $user->userId) }}" method="POST"
                id="completeProfileForm">
                @csrf
                @method('PUT')

                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill"></div>
                </div>
                <div class="step-indicator">
                    <span>Langkah 1 dari 1</span>
                    <span id="progressText">0%</span>
                </div>

                <div class="form-row-3">
                    <div class="form-group">
                        <label for="nik">NIK <span class="required">*</span></label>
                        <input type="number" id="nik" name="nik" value="{{ old('nik') }}" required>
                        <span class="text-muted">Nomor Induk Kependudukan (16 digit)</span>
                        @error('nik')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                        <span class="text-muted">Sesuai KTP</span>
                        @error('username')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor HP <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                        <span class="text-muted">Nomor aktif untuk kontak darurat</span>
                        @error('phone')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row-3">
                    <div class="form-group">
                        <label for="kodeProvinsi">Provinsi <span class="required">*</span></label>
                        <select id="kodeProvinsi" name="kodeProvinsi" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province['id'] }}"
                                    {{ old('kodeProvinsi') == $province['id'] ? 'selected' : '' }}>
                                    {{ $province['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('kodeProvinsi')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kodeKabupaten">Kabupaten/Kota <span class="required">*</span></label>
                        <select id="kodeKabupaten" name="kodeKabupaten" required disabled>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                        @error('kodeKabupaten')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kodeKecamatan">Kecamatan <span class="required">*</span></label>
                        <select id="kodeKecamatan" name="kodeKecamatan" required disabled>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        @error('kodeKecamatan')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row-3">
                    <div class="form-group">
                        <label for="kodeKelurahan">Kelurahan/Desa <span class="required">*</span></label>
                        <select id="kodeKelurahan" name="kodeKelurahan" required disabled>
                            <option value="">Pilih Kelurahan/Desa</option>
                        </select>
                        @error('kodeKelurahan')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rtRwId">RT/RW <span class="required">*</span></label>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <select id="rtRwId" name="rtRwId" required style="flex: 1;" disabled>
                                <option value="" selected hidden>Pilih RT/RW</option>
                                @if ($rtrws != null)
                                    @foreach ($rtrws as $rtrw)
                                        <option value="{{ $rtrw->rtRwId }}"
                                            {{ old('rtRwId') == $rtrw->rtRwId ? 'selected' : '' }}>
                                            {{ $rtrw->nomor }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="">Tidak ada data RT/RW</option>
                                @endif
                            </select>
                        </div>
                        @error('rtRwId')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <div>
                            <small>RT/RW anda belum terdaftar? Hubungi petugas RT/RW setempat untuk mendaftarkan RT/RW kamu</small>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan <span class="required">*</span></label>
                        <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}"
                            required>
                        <span class="text-muted">Pekerjaan utama Anda</span>
                        @error('pekerjaan')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="anggotaKeluarga">Jumlah Anggota Keluarga <span class="required">*</span></label>
                        <input type="number" id="anggotaKeluarga" name="anggotaKeluarga"
                            value="{{ old('anggotaKeluarga') }}" required>
                        <span class="text-muted">Termasuk Anda</span>
                        @error('anggotaKeluarga')
                            <div class="error-message" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamatDetail">Alamat Lengkap <span class="required">*</span></label>
                    <textarea id="alamatDetail" name="alamatDetail" rows="4" required>{{ old('alamatDetail') }}</textarea>
                    <span class="text-muted">RT/RW, Jalan, Nomor Rumah, dll</span>
                    @error('alamatDetail')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <button type="submit" class="btn" id="submitBtn">
                        Simpan Data dan Generate QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('completeProfileForm');
            const submitBtn = document.getElementById('submitBtn');
            const progressFill = document.getElementById('progressFill');
            const progressText = document.getElementById('progressText');
            const requiredFields = form.querySelectorAll('[required]');

            // Update progress bar
            function updateProgress() {
                let completed = 0;
                requiredFields.forEach(field => {
                    if (field.value.trim() !== '') {
                        completed++;
                    }
                });

                const percentage = Math.round((completed / requiredFields.length) * 100);
                progressFill.style.width = percentage + '%';
                progressText.textContent = percentage + '%';
            }

            // Real-time progress update
            requiredFields.forEach(field => {
                field.addEventListener('input', updateProgress);
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                let isValid = true;

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
                rtRwId.innerHTML = '<option value="" selected hidden>Pilih RT/RW</option>';
                rtRwId.disabled = true;

                // Enable kabupaten select
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
                rtRwId.innerHTML = '<option value="" selected hidden>Pilih RT/RW</option>';
                rtRwId.disabled = true;

                // Enable kecamatan select
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
                rtRwId.innerHTML = '<option value="" selected hidden>Pilih RT/RW</option>';
                rtRwId.disabled = true;

                // Enable kelurahan select
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

            kelurahanSelect.addEventListener('change', function() {
                const kelurahanId = this.value;
                rtRwId.innerHTML = '<option value="" selected hidden>Memuat...</option>';
                rtRwId.disabled = true;

                if (!kelurahanId) {
                    rtRwId.innerHTML = '<option value="" selected hidden>Pilih RT/RW</option>';
                    rtRwId.disabled = true;
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
                        rtRwId.innerHTML = '<option value="" selected hidden>Pilih RT/RW</option>';

                        console.log();

                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(rtrw => {
                                const option = document.createElement('option');
                                option.value = rtrw.rtRwId; // ← note: key is rtRwId, not id
                                option.textContent = rtrw.nomor;
                                rtRwId.appendChild(option);
                            });
                            rtRwId.disabled = false;
                        } else {
                            const noDataOption = document.createElement('option');
                            noDataOption.value = '';
                            noDataOption.textContent = 'Tidak ada data RT/RW';
                            noDataOption.disabled = true;
                            rtRwId.appendChild(noDataOption);
                            rtRwId.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching RT/RW:', error);
                        rtRwId.innerHTML = '<option value="">Gagal memuat data</option>';
                        rtRwId.disabled = false;
                    });
            });

            // Initial progress update
            updateProgress();

            // Set initial disabled states
            kabupatenSelect.disabled = true;
            kecamatanSelect.disabled = true;
            kelurahanSelect.disabled = true;
            rtRwId.disabled = true;
        });
    </script>
</body>

</html>
