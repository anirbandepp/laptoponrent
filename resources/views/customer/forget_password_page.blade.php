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
                    <form action="{{ route('customer.sendforgetpasswordmail') }}" method="POST">
                        @method('post')
                        @csrf
                        <!-- Email input -->
                        <div class=" my-4">
                            <div class="form-outline">
                                <input type="email" id="form1Example13" name="email"
                                    class="form-control form-control-lg" value="{{ old('email') }}" />
                                <label class="form-label" for="form1Example13">Email </label>
                            </div>
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session()->has('error'))
                            <div class="m-2">
                                <p class="text-light bg-msg p-2">{{ session('error') }}</p>
                            </div>
                        @endif
                        <!-- Submit button -->
                        <button type="submit" class="btn login btn-lg btn-block rounded-pill btn-success">Send
                            Password</button>
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
