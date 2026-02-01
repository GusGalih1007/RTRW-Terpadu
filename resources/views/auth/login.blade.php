<center>
    <h2>Login {{ Auth::user() }}</h2>
    <form action="{{ route('auth.login.post') }}" method="POST">
        {{ csrf_field() }}
        <label for="email">E-mail</label><br>
        <input type="email" name="email" required><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</center>