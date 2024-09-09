<link rel="stylesheet" href="{{ asset('css/nav.css') }}">

<div class="container-fluid">
    <div class="row">
        <!-- Desktop Sidebar -->
        <nav class="col-lg-3 col-xl-2 d-none d-lg-block bg-dark text-white sidebar">
            <div class="position-sticky">
                <!-- Profile Section -->
                 <!-- Profile Section -->
                 <a href="{{ route('users.index') }}" class="profile-section d-flex align-items-center p-3 text-white text-decoration-none">
                    <!-- Gambar Profil -->
                    <img src="{{ Auth::user()->photo ? Storage::url(Auth::user()->photo) : asset('img/profile.jpg') }}" alt="Profile Picture" class="profile-picture me-3">
                    <div>
                        <h5 class="profile-name">{{ Auth::user()->username }}</h5>
                        <p class="profile-role">{{ Auth::user()->role }}</p>
                    </div>
                </a>

                <!-- Navigation Menu -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                    </li>
                    @if(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('barang.index') }}">Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('laporan.index') }}">Laporan</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('perbaikan.index') }}">Perbaikan</a>
                    </li>
                    <li class="nav-item">
                        <form action="/logout" method="post">
                            @csrf
                            <button class="nav-link text-white bg-dark border-0" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Mobile Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Manajemen Inventory</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Manajemen Inventory</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body bg-dark text-white">
                        <!-- Profile Section -->
                        <div class="profile-section d-flex align-items-center p-3">
                            <!-- Gambar Profil -->
                            <img src="{{ Auth::user()->photo ? Storage::url(Auth::user()->photo) : asset('img/default-profile.png') }}" alt="Profile Picture" class="profile-picture me-3">
                            <div>
                                <h5 class="profile-name">{{ Auth::user()->username }}</h5>
                                <p class="profile-role">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                        <!-- Navigation Menu -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('barang.index') }}">Barang</a>
                            </li>
                            @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('laporan.index') }}">Laporan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('perbaikan.index') }}">Perbaikan</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <form action="/logout" method="post">
                                    @csrf
                                    <button class="nav-link text-white bg-dark border-0" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>
