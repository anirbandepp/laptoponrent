@extends('adminlte::auth.login')
{{-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Acme login</title>
  <!-- MDB icon -->
  <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-login-form.min.css') }}" />
  <!-- Style.css  -->
  <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
</head>

<body id="login">
    <!-- Start your project here-->
  
    <style>
      .divider:after,
      .divider:before {
        content: "";
        flex: 1;
        height: 1px;
        background: #eee;
      }
      .error{
        color: red;
      }
    </style>
    <section class="vh-100">
      
      <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
         
          <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto" id="login-form">
            <div class="b-logo">
              <img src="{{ asset('assets/img/favicon.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
            </div>
            <form action="{{ url('/login') }}" method="POST">
                @csrf
              <!-- Email input -->
              <div class=" my-4">
                <div class="form-outline">
                    <input type="email" id="form1Example13" name="email" class="form-control form-control-lg" />
                    <label class="form-label" for="form1Example13">Email or Mobile number</label>
                </div>
                @error('email')
                  <div class="error">{{ $message }}</div>
                @enderror
              </div>
                
  
              <!-- Password input -->
              <div class=" my-4">
                <div class="form-outline">
                    <input type="password" id="form1Example23" name="password" class="form-control form-control-lg" />
                    <label class="form-label" for="form1Example23">Password</label>
                </div>
                @error('password')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
  
              <div class="d-flex justify-content-around align-items-center mb-4">
                <!-- Checkbox -->
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value=""
                    id="form1Example3"
                    checked
                  />
                  <label class="form-check-label" for="form1Example3"> Remember me </label>
                </div>
                <a href="{{url('/password/reset')}}">Forgot password?</a>
              </div>
  
              <!-- Submit button -->
              <button type="submit" class="btn login btn-lg btn-block rounded-pill text-white">Login</button>
  
              <div class="divider d-flex align-items-center my-4">
                <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
              </div>
  
              <a class="btn btn-primary btn-lg btn-block text-dark rounded-pill registration" style="background-color: #fff" href="{{url('/register')}}" role="button">
                Registration
              </a>
             
  
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- End your project here-->

  <!-- MDB -->
  <script type="text/javascript" src="{{ asset('/assets/js/mdb.min.js') }}"></script>
  <!-- Custom scripts -->
  <script type="text/javascript"></script>
</body>

</html> --}}
    
   