@extends('layout.auth.app')
@section('title', 'Reset Password')
@section('main-content')
    <div class="row align-items-center h-100 m-0 bg-white">
        <div class="col-md-6 d-md-block d-none bg-primary mt-n1 vh-100 overflow-hidden p-0">
            <img src="{{ asset('assets/images/auth/05.png') }}" class="img-fluid gradient-main animated-scaleX" alt="images">
        </div>
        <div class="col-md-6">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card card-transparent auth-card d-flex justify-content-center mb-0 shadow-none">
                        <div class="card-body">
                            <a href="{{ route('welcome') }}" class="navbar-brand d-flex align-items-center mb-3">

                                <!--Logo start-->
                                <div class="logo-main">
                                    <div class="logo-normal">
                                        <svg width="60" height="60" viewBox="0 0 120 120" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <text x="40" y="40" font-family="Arial, Helvetica, sans-serif" font-size="32"
                                                font-weight="bold" fill="black" text-anchor="middle"
                                                dominant-baseline="middle">RT</text>
                                            <text x="45" y="63" font-family="Arial, Helvetica, sans-serif" font-size="32"
                                                font-weight="bold" fill="black" text-anchor="middle"
                                                dominant-baseline="middle">RW</text>
                                            <line x1="20" y1="78" x2="80" y2="78" stroke="black"
                                                stroke-width="1.5" />
                                            <text x="48" y="88" font-family="Arial, Helvetica, sans-serif" font-size="14"
                                                font-weight="bold" fill="#3B58E9" text-anchor="middle"
                                                dominant-baseline="middle">Terpadu</text>
                                        </svg>
                                    </div>
                                    <div class="logo-mini">
                                        <svg width="60" height="60" viewBox="0 0 120 120" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <text x="40" y="40" font-family="Arial, Helvetica, sans-serif" font-size="32"
                                                font-weight="bold" fill="black" text-anchor="middle"
                                                dominant-baseline="middle">RT</text>
                                            <text x="45" y="63" font-family="Arial, Helvetica, sans-serif" font-size="32"
                                                font-weight="bold" fill="black" text-anchor="middle"
                                                dominant-baseline="middle">RW</text>
                                            <line x1="20" y1="78" x2="80" y2="78" stroke="black"
                                                stroke-width="1.5" />
                                            <text x="48" y="88" font-family="Arial, Helvetica, sans-serif" font-size="14"
                                                font-weight="bold" fill="#3B58E9" text-anchor="middle"
                                                dominant-baseline="middle">Terpadu</text>
                                        </svg>
                                    </div>
                                </div>
                                <!--logo End-->

                                <h4 class="logo-title ms-3">RT/RW Terpadu</h4>
                            </a>
                            @if (session('error'))
                                <div id="alerts-disimissible-component">
                                    <div class="alert alert-left alert-danger alert-dismissible fade show" role="alert">
                                        <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.81409 20.4368H19.1971C20.7791 20.4368 21.7721 18.7267 20.9861 17.3527L13.8001 4.78775C13.0091 3.40475 11.0151 3.40375 10.2231 4.78675L3.02509 17.3518C2.23909 18.7258 3.23109 20.4368 4.81409 20.4368Z"
                                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"></path>
                                            <path d="M12.0024 13.4147V10.3147" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M11.995 16.5H12.005" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        {{ session('error') }}!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            @endif
                            @if (session('success'))
                                <div id="alerts-disimissible-component">
                                    <div class="alert alert-left alert-success alert-dismissible fade show"
                                        role="alert">
                                        <svg width="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.94118 10.7474V20.7444C5.94118 21.0758 5.81103 21.3936 5.57937 21.628C5.3477 21.8623 5.0335 21.994 4.70588 21.994H2.23529C1.90767 21.994 1.59347 21.8623 1.36181 21.628C1.13015 21.3936 1 21.0758 1 20.7444V11.997C1 11.6656 1.13015 11.3477 1.36181 11.1134C1.59347 10.879 1.90767 10.7474 2.23529 10.7474H5.94118ZM5.94118 10.7474C7.25166 10.7474 8.50847 10.2207 9.43512 9.28334C10.3618 8.34594 10.8824 7.07456 10.8824 5.74887V4.49925C10.8824 3.83641 11.1426 3.20071 11.606 2.73201C12.0693 2.26331 12.6977 2 13.3529 2C14.0082 2 14.6366 2.26331 15.0999 2.73201C15.5632 3.20071 15.8235 3.83641 15.8235 4.49925V10.7474H19.5294C20.1847 10.7474 20.8131 11.0107 21.2764 11.4794C21.7397 11.9481 22 12.5838 22 13.2466L20.7647 19.4947C20.5871 20.2613 20.25 20.9196 19.8045 21.3704C19.3589 21.8211 18.8288 22.04 18.2941 21.994H9.64706C8.6642 21.994 7.72159 21.599 7.0266 20.896C6.33162 20.1929 5.94118 19.2394 5.94118 18.2451"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        {{ session('success') }}!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <h2 class="mb-2 text-center">Reset Password</h2>
                            <p class="text-center">Masukan password baru untuk merubah password</p>
                            <form method="post" action="{{ route('auth.reset-password.put', session('userId')) }}">
                                {{ csrf_field() }}
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password Baru</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password Baru..."
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi password..."
                                                required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
