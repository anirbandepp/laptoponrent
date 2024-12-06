@extends('customer.main')
@section('title', 'Login Page')
@section('content')

<section class="vh-100">
      
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto" id="login-form">
          <div class="b-logo">
            <img src="{{ asset('assets/img/logo.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
          </div>
          <form action="{{ route('customer.user_login') }}" method="POST">
            @method('post')
              @csrf
            <!-- Email input -->
            <div class=" my-4">
              <div class="form-outline">
                  <input type="email" id="form1Example13" name="email" class="form-control form-control-lg" value="{{old('email')}}" />
                  <label class="form-label" for="form1Example13">Email </label>
              </div>
              @error('email')
                <div class="error">{{ $message }}</div>
              @enderror
            </div>
              

            <!-- Password input -->
            <div class="my-4">
              <div class="form-outline">
                  <input type="password" id="form1Example23" name="password" class="form-control form-control-lg" />
                  <label class="form-label" for="form1Example23">Password</label>
              </div>
              @error('password')
              <div class="error">{{ $message }}</div>
              @enderror
          </div>
          @if(session()->has('error'))
            <div class="m-2">
              <p class="text-light bg-msg p-2">{{session('error')}}</p>
            </div>
          @endif
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
              <a href="{{url('/forget_password_page')}}">Forgot password?</a>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn login btn-lg btn-block rounded-pill btn-success">Login</button>

            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0 text-muted">OR</p>
            </div>

            <a class="btn btn-primary btn-lg btn-block text-dark rounded-pill registration" style="background-color: #fff" href="{{url('/registration')}}" role="button">
              Registration
            </a>
           

          </form>
          
        </div>
      </div>
    </div>
  </section>
    
@endsection
@section('css')
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
    .bg-msg{
      background-color: red;
    }
  </style>
@endsection

@section('js')
    
@endsection