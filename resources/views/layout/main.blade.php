<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manajemen Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    

    <style>
        body {
            background-color: #e9ecef;
        }
    
        .sidebar {
            height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            z-index: 100; 
            overflow-y: auto;
        }
        .content {
            margin-left: 250px; 
        }
        @media (max-width: 767.98px) {
            h1 {
                font-size: 1.5rem; 
            }
    
            label, th, td {
                font-size: 0.875rem; 
            }
    
            .btn {
                font-size: 0.875rem; 
            }
        }
    </style>
    

</head>
<body >

    @include('layout.nav')
        <main class="col-lg-9 col-xl-10 ms-sm-auto px-md-4 mt-4">
            <aside id="colorlib-hero" class="js-fullheight">
                <div class="flexslider js-fullheight">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                       {{ session('success') }}
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  @endif  
                    @if($errors->any())
                      <div class="alert alert-error alert-dismissible">
                        <ul>
                          @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    @endif      
                    @yield('container') 
                    
                </div>
            </aside>
        </main>
    </div>
</div>

<footer class="mt-auto">
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
