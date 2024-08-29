<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/stylelogin.css">
  <title>Login</title>
</head>
<body>
  <div class="logo">
    <img src="img/logo.png">
   </div> 
  <div class="card-login">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="/login" method="post" class="sign-in-form">
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
          @csrf
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" name="email" placeholder="Email" autofocus required />
          </div>
          @error('email')
            <span class="error">{{ $message }}</span>
          @enderror
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required />
          </div>
          @error('password')
            <span class="error">{{ $message }}</span>
          @enderror
         
          <input type="submit" value="Login" class="btn solid" />
          <p>Belum Memiliki Akun? <a href="/register" class="nav-item nav-link">Register</a>
           
          </form>
        </div>
      </div>
    </div>
  
  </body>
  </html>
  
