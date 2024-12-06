@extends('customer.main')
@section('title', 'Reset password')
@section('content')

@include('customer.navbar')

    <section class="vh-90">

        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto" id="login-form">
                    <div class="b-logo">
                        <img src="{{ asset('assets/img/logo.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
                        <div class="signup-title pb-2">
                            <h2 class="text-center">Reset your password</h2>
                        </div>
                    </div>
                    @if (session()->has('msg'))
                        <div class="bg-light">
                            <h5 class="py-2 text-success">{{ session('msg') }}</h5>
                        </div>
                    @endif
                    <form action="{{ route('customer.reset_password_process') }}" method="POST">
                        @method('post')
                        @csrf
                        <!-- Password input -->
                        <div class="input-group form-outline mb-4 position-relative">
                            <input type="password" name="password" class="form-control form-control-lg" id="inputPassword"
                                aria-describedby="inputGroupPrepend" required="">
                            <label for="inputPassword" class="form-label">Password</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback pt-2">Required password </div>
                        </div>
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <!-- Password input -->
                        <div class="input-group form-outline mb-4 position-relative">
                            <input type="password" name="password_confirmation" class="form-control form-control-lg"
                                id="inputRepassword" aria-describedby="inputGroupPrepend" required="">
                            <label for="inputRepassword" class="form-label">Retype password</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback pt-2">Required same password </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn login btn-lg btn-block rounded-pill btn-success">SUBMIT</button>

                    </form>
                    @if (session()->has('error'))
                        <div class="m-2">
                            <p class="text-light bg-msg p-2">{{ session('error') }}</p>
                        </div>
                    @endif
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

        .error {
            color: red;
        }

        .bg-msg {
            background-color: red;
        }
    </style>
@endsection

@section('js')

@endsection
