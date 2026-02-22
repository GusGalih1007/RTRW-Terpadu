<center>
    <h2>Login</h2>
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
    <form action="{{ route('auth.login.post') }}" method="POST">
        {{ csrf_field() }}
        <label for="email">E-mail</label><br>
        <input type="email" name="email" required><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" required><br><br> 
        <button type="submit">Login</button><br><br>
        <div>
            <a href="{{ route('auth.forgot-password') }}">Lupa Password</a>
        </div>
    </form>
</center>
