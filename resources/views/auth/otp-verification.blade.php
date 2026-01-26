<center>
    <h2>Verifikasi OTP</h2>
    <form action="{{ route('auth.verify-otp.post') }}" method="POST">
        {{ csrf_field() }}
        <label>Kode OTP</label><br>
        <input type="number" name="otp">
        <button type="submit">Submit</button>
    </form>
</center>