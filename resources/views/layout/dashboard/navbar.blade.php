<nav class="nav navbar navbar-expand-xl navbar-light iq-navbar">
    <div class="container-fluid navbar-inner">
        <a href="#" class="navbar-brand">

            <!--Logo start-->
            <div class="logo-main">
                <div class="logo-normal">
                    <svg width="50" height="50" viewBox="0 0 120 120" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <text x="40" y="40" font-family="Arial, Helvetica, sans-serif" font-size="32" font-weight="bold"
                            fill="black" text-anchor="middle" dominant-baseline="middle">RT</text>
                        <text x="45" y="63" font-family="Arial, Helvetica, sans-serif" font-size="32" font-weight="bold"
                            fill="black" text-anchor="middle" dominant-baseline="middle">RW</text>
                        <line x1="20" y1="78" x2="80" y2="78" stroke="black"
                            stroke-width="1.5" />
                        <text x="48" y="88" font-family="Arial, Helvetica, sans-serif" font-size="14" font-weight="bold"
                            fill="#3B58E9" text-anchor="middle" dominant-baseline="middle">Terpadu</text>
                    </svg>
                </div>
                <div class="logo-mini">
                    <svg width="50" height="50" viewBox="0 0 120 120" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <text x="40" y="40" font-family="Arial, Helvetica, sans-serif" font-size="32" font-weight="bold"
                            fill="black" text-anchor="middle" dominant-baseline="middle">RT</text>
                        <text x="45" y="63" font-family="Arial, Helvetica, sans-serif" font-size="32" font-weight="bold"
                            fill="black" text-anchor="middle" dominant-baseline="middle">RW</text>
                        <line x1="20" y1="78" x2="80" y2="78" stroke="black"
                            stroke-width="1.5" />
                        <text x="48" y="88" font-family="Arial, Helvetica, sans-serif" font-size="14" font-weight="bold"
                            fill="#3B58E9" text-anchor="middle" dominant-baseline="middle">Terpadu</text>
                    </svg>
                </div>
            </div>
            <!--logo End-->

            <h4 class="logo-title">Dashboard</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
            </i>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <span class="navbar-toggler-bar bar1 mt-2"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-center navbar-list mb-lg-0 mb-2 ms-auto">
                <li class="nav-item dropdown custom-drop">
                    <a class="nav-link d-flex align-items-center py-0" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('assets/images/avatars/01.png') }}" alt="User-Profile"
                            class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_1.png') }}" alt="User-Profile"
                            class="theme-color-purple-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_2.png') }}" alt="User-Profile"
                            class="theme-color-blue-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_4.png') }}" alt="User-Profile"
                            class="theme-color-green-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_5.png') }}" alt="User-Profile"
                            class="theme-color-yellow-img img-fluid avatar avatar-50 avatar-rounded">
                        <img src="{{ asset('assets/images/avatars/avtar_3.png') }}" alt="User-Profile"
                            class="theme-color-pink-img img-fluid avatar avatar-50 avatar-rounded">
                        <div class="caption d-none d-md-block ms-3">
                            <h6 class="caption-title mb-0">{{ Auth::user()->username }}</h6>
                            <p class="caption-sub-title mb-0">{{ Auth::user()->role->description }}</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="../dashboard/app/user-profile.html">Profile</a></li>
                        <li><a class="dropdown-item" href="../dashboard/app/user-privacy-setting.html">Privacy
                                Setting</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
