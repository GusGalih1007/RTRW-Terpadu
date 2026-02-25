<center>
    <h2>Data RT/RW</h2>
    <a href="{{ route('admin.rt-rw.create') }}">+ Tambah Data</a>
    <hr>
    <table border="1" style="border-collapse: collapse" cellpadding="10">
        <tr>
            <th>No.</th>
            <th>RT/RW</th>
            <th>Alamat</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            <th>Kabupaten</th>
            <th>Provinsi</th>
            <th>Action</th>
        </tr>
        @foreach ($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->rt . '/' . $d->rw ?? '-' }}</td>
                <td>{{ $d->alamatDetail ?? '-' }}</td>
                <td>{{ $d->province_name ?? '-' }}</td>
                <td>{{ $d->regency_name ?? '-' }}</td>
                <td>{{ $d->district_name ?? '-' }}</td>
                <td>{{ $d->village_name ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.rt-rw.delete', $d->rtRwId) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('admin.rt-rw.edit', $d->rtRwId) }}">Edit</a> |
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</center>
