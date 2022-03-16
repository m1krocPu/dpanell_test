<!DOCTYPE html>
<html lang="en">
  
<head>
   @include('layouts.head')
  </head>
  <body>
    <div class="loader-wrapper">
      <div class="theme-loader">    
        <div class="loader-p"></div>
      </div>
    </div>
    <section>
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-7"><img class="bg-img-cover bg-center" src="{{asset('assets/images/login-bg.jpg')}}" alt="looginpage"></div>
          <div class="col-xl-5 p-0">
            <div class="login-card">
              <form class="theme-form login-form needs-validation {{ $errors->first('login')==''?'':'was-validated'}}" method="POST">
                @csrf
                <h4>Login</h4>
                <h6>Welcome, please insert your Email and Password.</h6>
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                    <input  class="form-control" name="username" type="email" required="" placeholder="" autofocus="" value="{{ old('username') }}">
                  </div>
                </div>
                <div class="form-group">
                  <label>Kata Sandi</label>
                  <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                    <input class="form-control" type="password" name="password" required="" placeholder="*********">
                    <div class="invalid-feedback">Email or Password incorrect.</div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary btn-block" type="submit">Log In</button>
                </div>
                
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
     <script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
    <!-- feather icon js-->
    <script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
    <script src="{{asset('assets/js/config.js')}}"></script>
    <!-- Bootstrap js-->
    <script src="{{asset('assets/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap/bootstrap.min.js')}}"></script>

    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{asset('assets/js/script.js')}}"></script>

  </body>

</html>