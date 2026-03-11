@extends('layout.dashboard.app')
@section('title', 'RT-RW')
@section('main-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Data RT/RW</h4>
                    </div>
                    <div>
                        <a href="{{ route('admin.rt-rw.create') }}" class="btn btn-primary">Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <p>Data ini merupakan data RT/RW yang sudah terdaftar dalam sistem. Bila ada RT/RW anda yang
                        belum terdaftar, Silahkan tambahkan data dengan menekan tombol diatas</p>
                    <div class="custom-datatable-entries">
                        <table id="datatable" class="table table-bordered table-hover" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>RT/RW</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->rt . '/' . $d->rw ?? '-' }}</td>
                                        <td>{{ $d->province_name ?? '-' }}</td>
                                        <td>{{ $d->regency_name ?? '-' }}</td>
                                        <td>{{ $d->district_name ?? '-' }}</td>
                                        <td>{{ $d->village_name ?? '-' }}</td>
                                        <td>{{ $d->alamatDetail ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('admin.rt-rw.delete', $d->rtRwId) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('admin.rt-rw.edit', $d->rtRwId) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
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
