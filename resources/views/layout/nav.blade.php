<div class="container-fluid">
    <div class="row">

        <nav class="col-lg-3 col-xl-2 d-none d-lg-block bg-dark text-white sidebar">
            <div class="position-sticky">
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active text-white" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('laporan.index') }}">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('barang.index') }}">Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Manajemen Eventory</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Manajemen Eventory</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('laporan.index') }}">Laporan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('barang.index') }}">Barang</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>