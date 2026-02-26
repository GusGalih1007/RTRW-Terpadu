@extends('layout.dashboard.app')
@section('title', 'Users')
@section('main-content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Data Pengguna</h4>
                </div>
            </div>
            <div class="card-body">
                <p>Data ini merupakan data pengguna aplikasi yang sudah terdaftar dalam sistem. Bila ada warga anda yang belum terdaftar, Silahkan tambahkan data dengan menekan tombol diatas</p>
                <div class="custom-datatable-entries">
                    {{-- <table id="datatable" class="table table-bordered table-hover" data-toggle="data-table">
                        <tr>
                            <th>No.</th>
                            <th>NIK</th>
                            <th>Nama Panjang</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Kelurahan</th>
                            <th>Kecamatan</th>
                            <th>Kabupaten</th>
                            <th>Provinsi</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection