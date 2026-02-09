<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Pendaftaran Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            border: 1px solid #dee2e6;
        }

        .user-info {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .qr-section {
            background-color: white;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .qr-code {
            margin: 15px 0;
        }

        .qr-code img {
            max-width: 300px;
            height: auto;
            border: 2px solid #007bff;
            border-radius: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        .info-value {
            color: #333;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #666;
            font-size: 12px;
        }

        .highlight {
            background-color: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>RT/RW Terpadu</h1>
        <h2>Data Pendaftaran Anda</h2>
    </div>

    <div class="content">
        <div class="highlight">
            <p><strong>Terima kasih telah mendaftar!</strong> Data Anda telah berhasil disimpan dalam sistem RT/RW
                Terpadu.</p>
        </div>

        <div class="user-info">
            <h3>Informasi Pengguna</h3>

            <div class="info-row">
                <span class="info-label">Nama Lengkap:</span>
                <span class="info-value">{{ $user->username ?? 'Belum diisi' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Password:</span>
                <span class="info-value">{{ Crypt::decrypt($user->password) }}</span>
            </div>

            {{-- <div class="info-row">
                <span class="info-label">NIK:</span>
                <span class="info-value">{{ $user->nik ?? 'Belum diisi' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Nomor HP:</span>
                <span class="info-value">{{ $user->phone ?? 'Belum diisi' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Pekerjaan:</span>
                <span class="info-value">{{ $user->pekerjaan ?? 'Belum diisi' }}</span>
            </div>

            <div class="info-row">
                <span class="info-label">Jumlah Anggota Keluarga:</span>
                <span class="info-value">{{ $user->anggotaKeluarga ?? 'Belum diisi' }}</span>
            </div> --}}
        </div>

        {{-- <div class="user-info">
            <h3>Alamat Lengkap</h3>

            <div class="info-row">
                <span class="info-label">Provinsi:</span>
                <span class="info-value">
                    @if($wilayahData['province'])
                        {{ $wilayahData['province'] }}
                    @elseif($user->kodeProvinsi)
                        {{ $user->kodeProvinsi }} (Kode)
                    @else
                        Belum diisi
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Kabupaten/Kota:</span>
                <span class="info-value">
                    @if($wilayahData['regency'])
                        {{ $wilayahData['regency'] }}
                    @elseif($user->kodeKabupaten)
                        {{ $user->kodeKabupaten }} (Kode)
                    @else
                        Belum diisi
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Kecamatan:</span>
                <span class="info-value">
                    @if($wilayahData['district'])
                        {{ $wilayahData['district'] }}
                    @elseif($user->kodeKecamatan)
                        {{ $user->kodeKecamatan }} (Kode)
                    @else
                        Belum diisi
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Kelurahan/Desa:</span>
                <span class="info-value">
                    @if($wilayahData['village'])
                        {{ $wilayahData['village'] }}
                    @elseif($user->kodeKelurahan)
                        {{ $user->kodeKelurahan }} (Kode)
                    @else
                        Belum diisi
                    @endif
                </span>
            </div>

            <div class="info-row">
                <span class="info-label">Alamat Detail:</span>
                <span class="info-value">{{ $user->alamatDetail ?? 'Belum diisi' }}</span>
            </div>
        </div> --}}

        @if ($user->qrImage)
            <div class="qr-section">
                <h3>Kode QR Anda</h3>
                <p>Gunakan kode QR ini untuk proses verifikasi dan identifikasi Anda di sistem RT/RW Terpadu</p>

                <div class="qr-code">
                    <img src="{{ asset('storage/' . $user->qrImage) }}" alt="QR Code" />
                </div>

                <p><em>Simpan kode QR ini dengan baik dan jangan bagikan kepada siapa pun</em></p>
                <p><em>QR code juga dilampirkan dalam email ini sebagai file terpisah untuk kemudahan download dan pencetakan</em></p>
            </div>
        @endif

        <div class="footer">
            <p><strong>Catatan Penting:</strong></p>
            <ul>
                <li>Data ini disimpan secara aman dalam database RT/RW Terpadu</li>
                <li>Jika ada perubahan data, silakan hubungi petugas RT/RW setempat</li>
                <li>Kode QR ini bersifat pribadi dan tidak dapat diganti</li>
                <li>Untuk pertanyaan lebih lanjut, silakan hubungi admin RT/RW</li>
            </ul>

            <p style="margin-top: 20px;">
                Email ini dikirim secara otomatis oleh sistem RT/RW Terpadu.<br>
                Jangan membalas email ini.
            </p>
        </div>
    </div>
</body>

</html>
