<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manajemen Eventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex flex-column min-vh-100">

    @include('layout.nav')

        <!-- Main Content -->
        <main class="col-lg-9 col-xl-10 ms-sm-auto px-md-4 mt-4">
            <aside id="colorlib-hero" class="js-fullheight">
                <div class="flexslider js-fullheight">
                    @yield('container') <!-- Konten akan dimuat di sini -->
                </div>
            </aside>
        </main>
    </div>
</div>

<footer class="mt-auto">
    <!-- Tambahkan konten footer di sini -->
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
