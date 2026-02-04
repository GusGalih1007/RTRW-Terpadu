<center>
    <h2>Register</h2>
    <form method="POST" action="{{ route('auth.register.post') }}">
        {{ csrf_field() }}
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
