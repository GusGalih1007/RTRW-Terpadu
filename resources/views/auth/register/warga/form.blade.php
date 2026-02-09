<center>
    <h2>Register Sebagai Warga</h2>
    @if (session('error'))
        <div>
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('auth.register.warga.post') }}">
        {{ csrf_field() }}
        <input type="hidden" value="User" name="roleId">
        <label>Email</label>
        <br>
        <input type="email" name="email" required><br><br>
        <label>Password</label>
        <br>
        <input type="password" name="password" required><br><br>
        <label>Konfirmasi Password</label>
        <br>
        <input type="password" name="password_confirmation"><br><br>
        <button type="submit">Submit</button>
    </form>
</center>
