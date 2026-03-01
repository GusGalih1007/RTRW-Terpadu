@extends('layout.dashboard.app')
@section('title', 'Detail User')
@section('main-content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="user-profile">
                    <div class="user-avatar">
                        <img src="{{ asset('assets/images/avatars/01.png') }}" alt="User Avatar" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                    </div>
                    <div class="user-detail mt-3">
                        <h4 class="mb-1">{{ $data->username ?? 'Data tidak tersedia' }}</h4>
                        <p class="text-muted mb-2">{{ $data->email ?? 'Email tidak tersedia' }}</p>
                        <p class="text-muted mb-2">{{ $data->emailVerifiedAt ?? 'Email belum terverifikasi' }}</p>
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
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" value="{{ $data->nik ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ $data->username ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $data->email ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" value="{{ $data->phone ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" value="{{ $data->pekerjaan ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Anggota Keluarga</label>
                            <input type="text" class="form-control" value="{{ $data->anggotaKeluarga ?? 'Tidak tersedia' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" class="form-control" value="{{ $data->role->description ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" value="{{ $data->status ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">RT/RW</label>
                            <input type="text" class="form-control" value="{{ $data->rtrw->rt ?? 'Tidak tersedia' }} / {{ $data->rtrw->rw ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Detail</label>
                            <input type="text" class="form-control" value="{{ $data->alamatDetail ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Wilayah</label>
                            <input type="text" class="form-control" value="{{ $data->village_name ?? 'Tidak tersedia' }}, {{ $data->district_name ?? 'Tidak tersedia' }}, {{ $data->regency_name ?? 'Tidak tersedia' }}, {{ $data->province_name ?? 'Tidak tersedia' }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dibuat Tanggal</label>
                            <input type="text" class="form-control" value="{{ $data->created_at ? $data->created_at->format('d M Y H:i') : 'Tidak tersedia' }}" readonly>
                        </div>
                    </div>
                </div>
                
                <!-- QR Code Section -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h6 class="mb-3">QR Code User</h6>
                            <div class="border p-3 d-inline-block">
                                @if($data->qrImage)
                                    <img src="{{ asset('storage/' . $data->qrImage) }}" alt="QR Code" class="img-fluid" style="width: 200px; height: 200px;">
                                @else
                                    <img src="{{ asset('assets/images/avatars/01.png') }}" alt="QR Code Placeholder" class="img-fluid" style="width: 200px; height: 200px;">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
