@extends('layout.dashboard.app')
@section('title', 'User')
@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Data Pengguna</h4>
                </div>
                <div>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah</a>
                </div>
            </div>
            <div class="card-body">
                <p>Data ini merupakan data pengguna aplikasi yang sudah terdaftar dalam sistem. Bila ada warga anda yang belum terdaftar, Silahkan tambahkan data dengan menekan tombol diatas</p>
                <div class="custom-datatable-entries">
                    <table id="datatable" class="table table-bordered table-hover" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Panjang</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $d->nik }}</td>
                                    <td>{{ $d->username }}</td>
                                    <td>{{ $d->phone }}</td>
                                    <td>{{ $d->email }}</td>
                                    <td>{{ $d->role->description }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('user.delete', $d->userId) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('user.show', $d->userId) }}" class="btn btn-info btn-sm">Detail</a>
                                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection