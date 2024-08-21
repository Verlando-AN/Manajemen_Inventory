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
  <div class="card-register">
    <div class="forms-container">
      <div class="signin-signup">
        <form action="/register" method="post" class="sign-in-form">
          @csrf 
          <h2 class="title">Register</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" name="username" class="form-control rounded-top @error('username') is-invalid @enderror" id="username" placeholder="Username"/>
            @error('username')
                <div class="invalid-feedback">
                    Error
                </div>
            @enderror
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" required />
            @error('email')
                <div class="invalid-feedback">
                    Error
                </div>
            @enderror
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required />
            @error('password')
                <div class="invalid-feedback">
                    8character
                </div>
            @enderror
          </div>
        <input type="submit" value="register" class="btn solid" />
        <p>Sudah Memiliki Akun? <a href="/login" class="nav-item nav-link">Login</a>       
        </form>    
       </div>
    </div>
  </div>

</body>
</html>
