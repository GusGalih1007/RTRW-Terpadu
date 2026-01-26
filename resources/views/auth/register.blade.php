<center>
    <h2>Register</h2>
    <form method="POST" action="{{ route('auth.register.post') }}">
        {{ csrf_field() }}
        <table cellpadding="10" style="text-align: center">
            <tr>
                <td>
                    <label>NIK</label>
                    <br>
                    <input type="number" name="nik" required>
                </td>
                <td>
                    <label>Nama Lengkap</label>
                    <br>
                    <input type="text" name="username" required>
                </td>
                <td>
                    <label>No. Telp</label>
                    <br>
                    <input type="number" name="phone" required>
                </td>
                <td>
                    <label>Email</label>
                    <br>
                    <input type="email" name="email" required>
                </td>
            </tr>
                <td>
                    <label>Provinsi</label>
                    <br>
                    <input type="number" name="kodeProvinsi">
                </td>
                <td>
                    <label>Kabupaten / Kota</label>
                    <br>
                    <input type="number" name="kodeKabupaten">
                </td>
                <td>
                    <label>Kecamatan</label>
                    <br>
                    <input type="number" name="kodeKecamatan">
                </td>
                <td>
                    <label>Kelurahan</label>
                    <br>
                    <input type="number" name="kodeKelurahan">
                </td>
            </tr>
            <tr>
                <td>
                    <label>Alamat Detail</label>
                    <br>
                    <textarea name="alamatDetail" required></textarea>
                </td>
                <td>
                    <label>Pekerjaan yang Ditekuni</label>
                    <br>
                    <input type="text" name="pekerjaan" required>
                </td>
                <td colspan="2">
                    <label>Anggota Keluarga dalam Kartu Keluarga</label>
                    <br>
                    <input type="number" name="anggotaKeluarga" required>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label>Password</label>
                    <br>
                    <input type="password" name="password" required>
                </td>
                <td colspan="2">
                    <label>Konfirmasi Password</label>
                    <br>
                    <input type="password" name="password_confirmation">
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <button type="submit">Submit</button>
                </td>
            </tr>
        </table>
    </form>
</center>