@extends('layout.landing.app')

@section('content')
<div class="inner-card-box bg-body">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 banner-one-img text-center ms-2 ms-sm-0">
                <img src="{{ asset('landing-pages/assets/images/home-1/banner-top.webp') }}" alt="RT/RW Terpadu Hero" class="img-fluid">
            </div>
            <div class="col-lg-5 inner-box">
                <div class="mb-2 text-uppercase text-primary sub-title">
                    Sistem Terpadu
                </div>
                <h1 class="text-secondary heading-title text-capitalize">RT/RW <span class="text-primary">Terpadu</span></h1>
                <p class="title-text">Sistem manajemen warga, iuran, dan program RT/RW yang terintegrasi untuk memudahkan administrasi lingkungan Anda.</p>
                <div class="d-flex align-items-center store-btn">
                    <a href="{{ route('auth.login') }}" class="btn btn-primary">Mulai Sekarang</a>
                    <a href="#fitur" class="btn btn-secondary ms-4">Lihat Fitur</a>
                </div>
                <div class="star-box mt-4">
                    <div class="d-flex mb-2 align-items-center">
                        <div class="border-end pe-2">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <g clip-path="url(#clip0_1150_5773)">
                                        <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1150_5773">
                                            <rect width="16" height="16" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <svg class="ms-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <g clip-path="url(#clip0_1150_5772)">
                                        <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1150_5772">
                                            <rect width="16" height="16" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <svg class="ms-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <g clip-path="url(#clip0_1150_5778)">
                                        <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1150_5778">
                                            <rect width="16" height="16" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <svg class="ms-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <g clip-path="url(#clip0_1150_5779)">
                                        <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1150_5779">
                                            <rect width="16" height="16" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <svg class="ms-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M9.65623 2.03398C9.80257 1.58357 10.4398 1.58358 10.5861 2.03398L12.1443 6.82956C12.2097 7.03099 12.3974 7.16737 12.6092 7.16737H17.6516C18.1252 7.16737 18.3221 7.77338 17.939 8.05174L13.8596 11.0156C13.6883 11.1401 13.6166 11.3607 13.682 11.5622L15.2402 16.3577C15.3865 16.8081 14.871 17.1827 14.4879 16.9043L10.4085 13.9405C10.2372 13.816 10.0052 13.816 9.83382 13.9405L5.75445 16.9043C5.37131 17.1827 4.85581 16.8081 5.00215 16.3577L6.56033 11.5622C6.62578 11.3607 6.55408 11.1401 6.38274 11.0156L2.30337 8.05174C1.92024 7.77338 2.11714 7.16737 2.59072 7.16737H7.6331C7.84489 7.16737 8.0326 7.03099 8.09805 6.82956L9.65623 2.03398Z" fill="#D9D9D9" />
                                    <mask id="mask0_1182_914" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="2" y="1" width="17" height="16">
                                        <path d="M9.65623 2.03398C9.80257 1.58357 10.4398 1.58358 10.5861 2.03398L12.1443 6.82956C12.2097 7.03099 12.3974 7.16737 12.6092 7.16737H17.6516C18.1252 7.16737 18.3221 7.77338 17.939 8.05174L13.8596 11.0156C13.6883 11.1401 13.6166 11.3607 13.682 11.5622L15.2402 16.3577C15.3865 16.8081 14.871 17.1827 14.4879 16.9043L10.4085 13.9405C10.2372 13.816 10.0052 13.816 9.83382 13.9405L5.75445 16.9043C5.37131 17.1827 4.85581 16.8081 5.00215 16.3577L6.56033 11.5622C6.62578 11.3607 6.55408 11.1401 6.38274 11.0156L2.30337 8.05174C1.92024 7.77338 2.11714 7.16737 2.59072 7.16737H7.6331C7.84489 7.16737 8.0326 7.03099 8.09805 6.82956L9.65623 2.03398Z" fill="#F2B827" />
                                    </mask>
                                    <g mask="url(#mask0_1182_914)">
                                        <rect x="-1" y="0.603027" width="13" height="19" fill="#F2B827" />
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <img src="{{ asset('landing-pages/assets/images/home-1/13.webp') }}" alt="Rating" class="img-fluid ps-2 star-icon">
                    </div>
                    <h6 class="mb-0 mt-1 text-black"><span>1000+</span> Pengguna Terdaftar</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-secondary features-card" id="fitur">
    <div class="container">
        <div class="row mx-2 mx-sm-0">
            <div class="col-lg-6"></div>
            <div class="col-lg-6 top-feature">
                <div class="text-right">
                    <div class="mb-2 text-uppercase sub-title text-white">
                        Fitur Unggulan
                    </div>
                    <h2 class="text-white notch-feature-txt heading-title text-capitalize heading-title">Fitur Terbaik untuk Administrasi RT/RW</h2>
                    <p class="title-text mb-0">Sistem terintegrasi yang memudahkan pengelolaan data warga, iuran, program, dan administrasi lingkungan Anda.</p>
                </div>
            </div>
        </div>
        <div class="row row-cols-sm-2 row-cols-lg-4">
            <div class="col">
                <div class="card services-box rounded-1">
                    <div class="card-body p-0">
                        <h5 class="mb-3">Manajemen<br>Warga</h5>
                        <p class="mb-3">Catat dan kelola data warga secara terstruktur dan aman.</p>
                        <svg width="12" class="text-primary" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.45109 0.343108L5.46396 1.36387L10.0063 1.42104L0.0568434 11.3704L0.787737 12.1013L10.7371 2.15194L10.7943 6.6942L11.8151 6.70706L11.736 0.422159L5.45109 0.343108Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card services-box rounded-1">
                    <div class="card-body p-0">
                        <h5 class="mb-3">Pengelolaan<br>Iuran</h5>
                        <p>Atur dan lacak pembayaran iuran warga secara otomatis.</p>
                        <svg class="text-primary" width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.45109 0.343108L5.46396 1.36387L10.0063 1.42104L0.0568434 11.3704L0.787737 12.1013L10.7371 2.15194L10.7943 6.6942L11.8151 6.70706L11.736 0.422159L5.45109 0.343108Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card services-box rounded-1">
                    <div class="card-body p-0">
                        <h5 class="mb-3">Program<br>RT/RW</h5>
                        <p>Rencanakan dan kelola program-program lingkungan.</p>
                        <svg class="text-primary" width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.45109 0.343108L5.46396 1.36387L10.0063 1.42104L0.0568434 11.3704L0.787737 12.1013L10.7371 2.15194L10.7943 6.6942L11.8151 6.70706L11.736 0.422159L5.45109 0.343108Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="col mb-4">
                <div class="card services-box rounded-1">
                    <div class="card-body p-0">
                        <h5 class="mb-3">Verifikasi<br>Peran</h5>
                        <p>Sistem verifikasi ketat untuk admin dan ketua RT/RW.</p>
                        <svg class="text-primary" width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.45109 0.343108L5.46396 1.36387L10.0063 1.42104L0.0568434 11.3704L0.787737 12.1013L10.7371 2.15194L10.7943 6.6942L11.8151 6.70706L11.736 0.422159L5.45109 0.343108Z" fill="currentColor" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('landing-pages/assets/images/home-1/aboutus.webp') }}" alt="Tentang Kami" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="mb-2 text-primary text-uppercase sub-title">
                    Tentang RT/RW Terpadu
                </div>
                <h2 class="text-secondary text-capitalize heading-title">Solusi <span class="text-primary">Terpadu</span> untuk Administrasi Lingkungan</h2>
                <p class="mb-4">RT/RW Terpadu adalah sistem manajemen terintegrasi yang dirancang khusus untuk memudahkan administrasi lingkungan Anda. Dengan fitur-fitur canggih dan antarmuka yang user-friendly, kami membantu RT/RW dalam mengelola data warga, pembayaran iuran, program lingkungan, dan berbagai aspek administrasi lainnya.</p>
                <div class="d-flex align-items-center mb-lg-4 mb-3 about-icon-box">
                    <div class="p-2 border border-secondary rounded-1 d-flex text-secondary align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M5.5625 9.00008L7.6875 11.1251L11.9375 6.87508M15.8333 9.00008C15.8333 12.9121 12.662 16.0834 8.75 16.0834C4.83798 16.0834 1.66666 12.9121 1.66666 9.00008C1.66666 5.08806 4.83798 1.91675 8.75 1.91675C12.662 1.91675 15.8333 5.08806 15.8333 9.00008Z" stroke="#001F4C" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="mb-0 ms-1">Manajemen Warga Terpusat</span>
                    </div>
                    <div class="p-2 border border-secondary rounded-1 d-flex text-secondary align-items-center ms-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M5.5625 9.00008L7.6875 11.1251L11.9375 6.87508M15.8333 9.00008C15.8333 12.9121 12.662 16.0834 8.75 16.0834C4.83798 16.0834 1.66666 12.9121 1.66666 9.00008C1.66666 5.08806 4.83798 1.91675 8.75 1.91675C12.662 1.91675 15.8333 5.08806 15.8333 9.00008Z" stroke="#001F4C" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="mb-0 ms-1">Pembayaran Iuran Otomatis</span>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-lg-4 mb-3 about-icon-box">
                    <div class="p-2 border border-secondary rounded-1 d-flex text-secondary align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M5.5625 9.00008L7.6875 11.1251L11.9375 6.87508M15.8333 9.00008C15.8333 12.9121 12.662 16.0834 8.75 16.0834C4.83798 16.0834 1.66666 12.9121 1.66666 9.00008C1.66666 5.08806 4.83798 1.91675 8.75 1.91675C12.662 1.91675 15.8333 5.08806 15.8333 9.00008Z" stroke="#001F4C" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="mb-0 ms-1">Program Lingkungan</span>
                    </div>
                    <div class="p-2 border border-secondary rounded-1 d-flex text-secondary align-items-center ms-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                            <path d="M5.5625 9.00008L7.6875 11.1251L11.9375 6.87508M15.8333 9.00008C15.8333 12.9121 12.662 16.0834 8.75 16.0834C4.83798 16.0834 1.66666 12.9121 1.66666 9.00008C1.66666 5.08806 4.83798 1.91675 8.75 1.91675C12.662 1.91675 15.8333 5.08806 15.8333 9.00008Z" stroke="#001F4C" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="mb-0 ms-1">Verifikasi Admin</span>
                    </div>
                </div>
                <a href="{{ route('auth.login') }}" class="btn btn-primary mt-3">Mulai Sekarang</a>
            </div>
        </div>
    </div>
</div>

<div class="section-padding bg-body">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="mb-2 text-primary text-uppercase sub-title">
                    Untuk Siapa?
                </div>
                <h2 class="text-secondary heading-title text-capitalize">Cocok untuk <span class="text-primary">Semua Pihak</span></h2>
                <p class="title-text">RT/RW Terpadu dirancang untuk memenuhi kebutuhan berbagai pihak dalam administrasi lingkungan.</p>
                <ul class="list-unstyled mt-4">
                    <li class="mb-3">
                        <svg class="text-primary me-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.6667 5L7.50001 14.1667L3.33334 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <strong>Admin (Kelurahan):</strong> Memantau data warga di seluruh RT/RW, verifikasi peran, dan menerima laporan
                    </li>
                    <li class="mb-3">
                        <svg class="text-primary me-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.6667 5L7.50001 14.1667L3.33334 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <strong>Ketua RT/RW:</strong> Mengelola data warga, program, dan iuran di wilayahnya
                    </li>
                    <li class="mb-3">
                        <svg class="text-primary me-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.6667 5L7.50001 14.1667L3.33334 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <strong>Warga:</strong> Mendaftar, melihat tagihan iuran, dan berpartisipasi dalam program
                    </li>
                    <li class="mb-3">
                        <svg class="text-primary me-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.6667 5L7.50001 14.1667L3.33334 10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <strong>Petugas Iuran:</strong> Memantau pembayaran dan melakukan penagihan dengan QR Code
                    </li>
                </ul>
            </div>
            <div class="col-lg-7 mt-5 mt-lg-0">
                <img src="{{ asset('landing-pages/assets/images/home-1/dwn-1.webp') }}" alt="Untuk Siapa" class="img-fluid d-block mx-auto">
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="mb-2 text-uppercase text-primary sub-title">
                    Cara Kerja
                </div>
                <h2 class="text-secondary heading-title text-capitalize">Proses <span class="text-primary">Sederhana</span> dan Efisien</h2>
                <p class="heading-main-title">Dari pendaftaran hingga pembayaran, semua proses dirancang untuk kemudahan dan efisiensi.</p>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20 21C20 18.7909 17.9543 17 15.3333 17H8.66667C6.04567 17 4 18.7909 4 21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h5 class="card-title">1. Pendaftaran</h5>
                        <p class="card-text">Warga mendaftar dan menunggu verifikasi dari ketua RT/RW</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 8V12L15 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h5 class="card-title">2. Verifikasi</h5>
                        <p class="card-text">Ketua RT/RW memverifikasi pendaftaran warga</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 5H5C3.89543 5 3 5.89543 3 7V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V7C21 5.89543 20.1046 5 19 5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 7L12 13L21 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h5 class="card-title">3. Pembayaran</h5>
                        <p class="card-text">Warga menerima tagihan dan melakukan pembayaran</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M8 12H16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 8V16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h5 class="card-title">4. Pelaporan</h5>
                        <p class="card-text">Semua data tercatat dan dapat dilaporkan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding bg-body">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="mb-2 text-uppercase text-primary sub-title">
                    Testimoni
                </div>
                <h2 class="text-secondary heading-title text-capitalize">Apa Kata <span class="text-primary">Pengguna</span> Kami?</h2>
            </div>
            <div class="overflow-hidden slider-circle-btn" id="testimonial-slider">
                <ul class="p-0 m-0 swiper-wrapper list-inline">
                    <li class="swiper-slide">
                        <p class="mb-4 test-text">"Sistem RT/RW Terpadu sangat membantu dalam mengelola administrasi lingkungan kami. Semua data warga tercatat dengan rapi dan pembayaran iuran menjadi lebih teratur."</p>
                        <div class="text-center">
                            <img src="{{ asset('assets/images/dashboard/top-header3.png') }}" class="img-fluid rounded-pill user-test-img mt-2 mb-2" alt="Testimoni 1" style="max-width: 150px;">
                        </div>
                        <div class="mb-2 text-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h6 class="text-secondary mb-0">Ketua RT 01</h6>
                            <p class="mb-0 text-primary">Kelurahan Sukamaju</p>
                        </div>
                    </li>
                    <li class="swiper-slide">
                        <p class="mb-4 test-text">"Sebagai petugas iuran, saya sangat terbantu dengan fitur QR Code. Sekarang saya bisa langsung mengecek status pembayaran warga hanya dengan memindai QR Code mereka."</p>
                        <div class="text-center">
                            <img src="{{ asset('assets/images/dashboard/top-header4.png') }}" class="img-fluid rounded-pill user-test-img mt-2 mb-2" alt="Testimoni 2" style="max-width: 150px;">
                        </div>
                        <div class="mb-2 text-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h6 class="text-secondary mb-0">Petugas Iuran</h6>
                            <p class="mb-0 text-primary">RT 02/RW 05</p>
                        </div>
                    </li>
                    <li class="swiper-slide">
                        <p class="mb-4 test-text">"Sebagai warga, saya merasa lebih mudah dalam membayar iuran dan melihat program-program yang ada di lingkungan kami. Transparansi menjadi lebih baik."</p>
                        <div class="text-center">
                            <img src="{{ asset('assets/images/dashboard/top-header5.png') }}" class="img-fluid rounded-pill user-test-img mt-2 mb-2" alt="Testimoni 3" style="max-width: 150px;">
                        </div>
                        <div class="mb-2 text-center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M7.63067 1.28789C7.76731 0.959376 8.23272 0.959376 8.36936 1.28789L10.0222 5.26187C10.0798 5.40037 10.2101 5.495 10.3596 5.50698L14.6498 5.85093C15.0045 5.87936 15.1483 6.32197 14.8781 6.55343L11.6094 9.35344C11.4954 9.45104 11.4457 9.60416 11.4805 9.75L12.4791 13.9366C12.5617 14.2826 12.1852 14.5562 11.8815 14.3707L8.20848 12.1273C8.08048 12.0491 7.91951 12.0491 7.7915 12.1273L4.11845 14.3707C3.81481 14.5562 3.43831 14.2826 3.52087 13.9366L4.51951 9.75C4.55431 9.60416 4.50456 9.45104 4.39065 9.35344L1.12193 6.55343C0.851714 6.32197 0.995529 5.87936 1.35019 5.85093L5.64043 5.50698C5.78995 5.495 5.92019 5.40037 5.9778 5.26187L7.63067 1.28789Z" fill="#FDB022"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <h6 class="text-secondary mb-0">Warga RT 01</h6>
                            <p class="mb-0 text-primary">Kelurahan Sukamaju</p>
                        </div>
                    </li>
                </ul>
                <div class="swiper-button swiper-button-next"></div>
                <div class="swiper-button swiper-button-prev"></div>
            </div>
        </div>
    </div>
</div>

<div class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-center">
                <div class="mb-2 text-uppercase text-primary sub-title">
                    Mulai Sekarang
                </div>
                <h2 class="text-secondary heading-title text-capitalize">Siap <span class="text-primary">Mengelola</span> Lingkungan Anda?</h2>
                <p class="heading-main-title">Bergabunglah dengan RT/RW Terpadu dan rasakan kemudahan dalam administrasi lingkungan Anda.</p>
                <div class="mt-5">
                    <a href="{{ route('auth.login') }}" class="btn btn-primary btn-lg me-4">Login Sekarang</a><br><br>
                    <a href="{{ route('auth.register.rt-rw') }}" class="btn btn-secondary btn-lg">Daftar Gratis sebagai Ketua RT/RW</a><br><br>
                    <a href="{{ route('auth.register.warga') }}" class="btn btn-secondary btn-lg">Daftar Gratis sebagai Warga</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection