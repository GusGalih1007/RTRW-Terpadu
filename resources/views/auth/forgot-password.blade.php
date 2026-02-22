<center>
    <h2>Lupa Password</h2>
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
    <p>Masukan email untuk mereset password</p>
    <form method="post" action="{{ route('auth.forgot-password.post') }}">
        {{ csrf_field() }}
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" required><br><br>
        <button type="submit">Submit</button>
    </form>
</center>