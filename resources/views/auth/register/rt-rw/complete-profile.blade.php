<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
        }

        .modal-header {
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-color);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--secondary-color);
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .modal-close:hover {
            background-color: #f8f9fa;
            color: var(--text-color);
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            padding: 20px 25px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-modal {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary-modal {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary-modal:hover {
            background-color: #0056b3;
        }

        .btn-secondary-modal {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary-modal:hover {
            background-color: #545b62;
        }

        .alert-modal {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }

        .alert-modal-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-modal-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .form-group-modal {
            margin-bottom: 20px;
        }

        .form-group-modal label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
        }

        .form-group-modal input,
        .form-group-modal select {
            width: 100%;
            padding: 10px;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            background-color: #fff;
        }

        .form-group-modal input:focus,
        .form-group-modal select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .form-row-modal {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 768px) {
            .form-row-modal {
                grid-template-columns: 1fr;
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

            <form action="{{ route('auth.complete-profile.rt-rw.post', $user->userId) }}" method="POST"
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
                        {{-- <button type="button" class="btn-secondary" style="padding: 12px 16px; font-size: 14px; white-space: nowrap;" onclick="openRtRwModal()">
                            + Tambah RT/RW
                        </button> --}}
                        <div>
                            <small>RT/RW anda belum terdaftar? <a href="#"
                                    onclick="openRtRwModal(); return false;">Daftarkan</a></small>
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

    <!-- RT/RW Modal -->
    <div class="modal-overlay" id="rtRwModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Tambah RT/RW Baru</h3>
                <button class="modal-close" onclick="closeRtRwModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="rtRwAlert" class="alert-modal" style="display: none;"></div>

                <form id="rtRwForm" method="POST">
                    @csrf
                    <div class="form-row-modal">
                        <div class="form-group-modal">
                            <label for="rtNumber">Nomor RT <span class="required">*</span></label>
                            <input type="number" id="rtNumber" name="rt" min="1" max="999"
                                required>
                            <span class="text-muted" style="font-size: 12px; color: var(--secondary-color);">1-3
                                digit</span>
                        </div>
                        <div class="form-group-modal">
                            <label for="rwNumber">Nomor RW <span class="required">*</span></label>
                            <input type="number" id="rwNumber" name="rw" min="1" max="999"
                                required>
                            <span class="text-muted" style="font-size: 12px; color: var(--secondary-color);">1-3
                                digit</span>
                        </div>
                    </div>

                    <div class="form-row-modal">
                        <div class="form-group-modal">
                            <label for="modalKodeProvinsi">Provinsi <span class="required">*</span></label>
                            <select id="modalKodeProvinsi" name="kodeProvinsi" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province['id'] }}">
                                        {{ $province['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group-modal">
                            <label for="modalKodeKabupaten">Kabupaten/Kota <span class="required">*</span></label>
                            <select id="modalKodeKabupaten" name="kodeKabupaten" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row-modal">
                        <div class="form-group-modal">
                            <label for="modalKodeKecamatan">Kecamatan <span class="required">*</span></label>
                            <select id="modalKodeKecamatan" name="kodeKecamatan" required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div class="form-group-modal">
                            <label for="modalKodeKelurahan">Kelurahan/Desa <span class="required">*</span></label>
                            <select id="modalKodeKelurahan" name="kodeKelurahan" required>
                                <option value="">Pilih Kelurahan/Desa</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-secondary-modal"
                    onclick="closeRtRwModal()">Batal</button>
                <button type="button" class="btn-modal btn-primary-modal" onclick="submitRtRwForm()">Simpan
                    RT/RW</button>
            </div>
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

            // RT/RW Modal Functions
            const rtRwModal = document.getElementById('rtRwModal');
            const rtRwForm = document.getElementById('rtRwForm');
            const rtRwAlert = document.getElementById('rtRwAlert');
            const modalKodeProvinsi = document.getElementById('modalKodeProvinsi');
            const modalKodeKabupaten = document.getElementById('modalKodeKabupaten');
            const modalKodeKecamatan = document.getElementById('modalKodeKecamatan');
            const modalKodeKelurahan = document.getElementById('modalKodeKelurahan');

            // Open modal
            window.openRtRwModal = function() {
                rtRwModal.classList.add('active');
                // Copy current wilayah selection to modal
                if (provinsiSelect.value) modalKodeProvinsi.value = provinsiSelect.value;
                if (kabupatenSelect.value) modalKodeKabupaten.value = kabupatenSelect.value;
                if (kecamatanSelect.value) modalKodeKecamatan.value = kecamatanSelect.value;
                if (kelurahanSelect.value) modalKodeKelurahan.value = kelurahanSelect.value;

                // Trigger change events to load dependent data
                if (modalKodeProvinsi.value) {
                    const event = new Event('change');
                    modalKodeProvinsi.dispatchEvent(event);
                }
            };

            // Close modal
            window.closeRtRwModal = function() {
                rtRwModal.classList.remove('active');
                rtRwForm.reset();
                rtRwAlert.style.display = 'none';
                modalKodeKabupaten.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                modalKodeKecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
                modalKodeKelurahan.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
            };

            // Submit RT/RW form
            window.submitRtRwForm = function() {
                const formData = new FormData(rtRwForm);
                const data = Object.fromEntries(formData.entries());

                // Validation
                if (!data.rt || !data.rw || !data.kodeProvinsi || !data.kodeKabupaten || !data.kodeKecamatan ||
                    !data.kodeKelurahan) {
                    showRtRwAlert('Mohon lengkapi semua field yang wajib diisi (*)', 'danger');
                    return;
                }

                if (data.rt < 1 || data.rt > 999 || data.rw < 1 || data.rw > 999) {
                    showRtRwAlert('Nomor RT dan RW harus antara 1-999', 'danger');
                    return;
                }

                // Submit via AJAX
                fetch('{{ route('sub-admin.rt-rw.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(result => {
                        console.log('RT/RW saved successfully:', result);

                        // Add new option to main form select
                        const newOption = document.createElement('option');
                        newOption.value = result.data.id;
                        newOption.textContent = result.data.nomor;
                        rtRwId.appendChild(newOption);

                        // Select the new option
                        rtRwId.value = result.data.id;

                        // Close modal after success
                        setTimeout(() => {
                            closeRtRwModal();
                        }, 1000);
                    })
                    .catch(error => {
                        console.error('Error saving RT/RW:', error);

                        if (error.message.includes('422')) {
                            // Validation errors
                            showRtRwAlert('Please fix the validation errors and try again.', 'danger');
                        } else if (error.message.includes('500')) {
                            showRtRwAlert('Server error. Please try again later.', 'danger');
                        } else {
                            showRtRwAlert('Error adding RT/RW. Please try again.', 'danger');
                        }
                    });
            };

            // Show alert in modal
            function showRtRwAlert(message, type) {
                rtRwAlert.textContent = message;
                rtRwAlert.className = `alert-modal alert-modal-${type}`;
                rtRwAlert.style.display = 'block';
            }

            // Modal wilayah data loading (same as main form)
            modalKodeProvinsi.addEventListener('change', function() {
                const provinsiId = this.value;
                modalKodeKabupaten.innerHTML = '<option value="">Memuat...</option>';
                modalKodeKecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
                modalKodeKelurahan.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';

                if (provinsiId) {
                    fetch(`/api/wilayah/regencies/${provinsiId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            modalKodeKabupaten.innerHTML =
                                '<option value="">Pilih Kabupaten/Kota</option>';

                            if (Array.isArray(data) && data.length > 0) {
                                data.forEach(kabupaten => {
                                    const option = document.createElement('option');
                                    option.value = kabupaten.id;
                                    option.textContent = kabupaten.name;
                                    modalKodeKabupaten.appendChild(option);
                                });
                            } else {
                                modalKodeKabupaten.innerHTML =
                                    '<option value="">Tidak ada data</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching regencies:', error);
                            modalKodeKabupaten.innerHTML =
                                '<option value="">Gagal memuat data</option>';
                        });
                }
            });

            modalKodeKabupaten.addEventListener('change', function() {
                const kabupatenId = this.value;
                modalKodeKecamatan.innerHTML = '<option value="">Memuat...</option>';
                modalKodeKelurahan.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';

                if (kabupatenId) {
                    fetch(`/api/wilayah/districts/${kabupatenId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            modalKodeKecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';

                            if (Array.isArray(data) && data.length > 0) {
                                data.forEach(kecamatan => {
                                    const option = document.createElement('option');
                                    option.value = kecamatan.id;
                                    option.textContent = kecamatan.name;
                                    modalKodeKecamatan.appendChild(option);
                                });
                            } else {
                                modalKodeKecamatan.innerHTML =
                                    '<option value="">Tidak ada data</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching districts:', error);
                            modalKodeKecamatan.innerHTML =
                                '<option value="">Gagal memuat data</option>';
                        });
                }
            });

            modalKodeKecamatan.addEventListener('change', function() {
                const kecamatanId = this.value;
                modalKodeKelurahan.innerHTML = '<option value="">Memuat...</option>';

                if (kecamatanId) {
                    fetch(`/api/wilayah/villages/${kecamatanId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            modalKodeKelurahan.innerHTML =
                                '<option value="">Pilih Kelurahan/Desa</option>';

                            if (Array.isArray(data) && data.length > 0) {
                                data.forEach(kelurahan => {
                                    const option = document.createElement('option');
                                    option.value = kelurahan.id;
                                    option.textContent = kelurahan.name;
                                    modalKodeKelurahan.appendChild(option);
                                });
                            } else {
                                modalKodeKelurahan.innerHTML =
                                    '<option value="">Tidak ada data</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching villages:', error);
                            modalKodeKelurahan.innerHTML =
                                '<option value="">Gagal memuat data</option>';
                        });
                }
            });
        });
    </script>
</body>

</html>
