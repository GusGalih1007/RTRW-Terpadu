@extends('layout.dashboard.app')
@section('title', 'Detail User')
@section('main-content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="user-profile">
                        <div class="user-avatar">
                            <img src="{{ asset('assets/images/avatars/01.png') }}" alt="User Avatar"
                                class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                        </div>
                        <div class="user-detail mt-3">
                            <h4 class="mb-1">{{ $data->username ?? 'Data tidak tersedia' }}</h4>
                            <p class="text-muted mb-2">{{ $data->email ?? 'Email tidak tersedia' }}</p>
                            <p class="text-muted mb-2">Email terverifikasi pada:</p>
                            <p class="text-muted mb-2">{{ $data->email_verified_at ?? 'Email belum terverifikasi' }}</p>
                            <span class="badge bg-primary">{{ $data->role->description ?? 'Role tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Detail Informasi User</h4>
                    </div>
                    <div>
                        <a href="{{ route('user.edit', $data->userId ?? '#') }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" value="{{ $data->nik ?? 'Tidak tersedia' }}"
                                readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ $data->username ?? 'Tidak tersedia' }}"
                                readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $data->email ?? 'Tidak tersedia' }}"
                                readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" value="{{ $data->phone ?? 'Tidak tersedia' }}"
                                readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" value="{{ $data->pekerjaan ?? 'Tidak tersedia' }}"
                                readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah Anggota Keluarga</label>
                            <input type="text" class="form-control"
                                value="{{ $data->anggotaKeluarga ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control"
                                value="{{ $data->role->description ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Alamat Rumah</label>
                            <input type="text" class="form-control"
                                value="{{ $data->alamatDetail ?? 'Tidak tersedia' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Data Wilayah</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <h5 class="mb-3">Wilayah</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data->province_name ?? 'Tidak tersedia' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kabupaten</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data->regency_name ?? 'Tidak tersedia' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data->district_name ?? 'Tidak tersedia' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $data->village_name ?? 'Tidak tersedia' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <h5 class="mb-3">RT/RW</h5>
                            <input type="text" class="form-control"
                                value="{{ $data->rtrw->rt ?? 'Tidak tersedia' }} / {{ $data->rtrw->rw ?? 'Tidak tersedia' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h6 class="mb-3">QR Code User</h6>
                                <div class="border p-3 d-inline-block">
                                    @if ($data->qrImage)
                                        <img src="{{ asset('storage/' . $data->qrImage) }}" alt="QR Code"
                                            class="img-fluid" style="width: 200px; height: 200px;">
                                    @else
                                        <img src="{{ asset('assets/images/avatars/01.png') }}" alt="QR Code Placeholder"
                                            class="img-fluid" style="width: 200px; height: 200px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Status Data</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Status: </label>
                            <span
                                class="badge bg-{{ $data->status->value === 'active' ? 'success' : ($data->status->value === 'rejected' ? 'danger' : 'warning') }}">
                                {{ strtoupper($data->status->value ?? 'Tidak tersedia') }}
                            </span>
                        </div>
                        @if ($data->status->value == 'Pending')
                            <div class="alert alert-left alert-warning">
                                Status dari warga ini belum terverifikasi. Verifikasi status warga ini segera
                            </div>
                        @endif
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Dibuat Tanggal</label>
                            <input type="text" class="form-control"
                                value="{{ $data->created_at ? $data->created_at->format('d M Y H:i') : 'Tidak tersedia' }}"
                                readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Dibuat oleh</label>
                            <input type="text" class="form-control"
                                value="{{ $data->createdBy ? $data->createdby->username : 'Sistem' }}"
                                readonly>
                        </div>
                        @if ($data->status->value === 'pending')
                            <a href="{{ route('user.role-change', [
                                'id' => $data->userId,
                                'role' => 'active',
                            ]) }}"
                                class="btn btn-success col-12 mb-3">Setuju</a>
                            <a href="{{ route('user.role-change', [
                                'id' => $data->userId,
                                'role' => 'rejected',
                            ]) }}"
                                class="btn btn-danger col-12 mb-3">Tolak</a>
                        @endif
                        @if ($data->status->value === 'active')
                            <a href="{{ route('user.status-change', [
                                'id' => $data->userId,
                                'status' => 'inactive',
                            ]) }}"
                                class="btn btn-warning col-12 mb-3">Non-Aktifkan</a>
                        @elseif ($data->status->value === 'inactive')
                            <a href="{{ route('user.status-change', [
                                'id' => $data->userId,
                                'status' => 'active',
                            ]) }}"
                                class="btn btn-success col-12 mb-3">Aktifkan</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
