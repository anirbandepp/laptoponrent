@extends('customer.main')
@section('title', 'Payment')
@section('content')

    <section class="vh-100">

        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto" id="login-form">
                    <div class="b-logo">
                        <img src="{{ asset('assets/img/logo.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
                    </div>
                    @if ($status)
                        <div class="p-4 text-center h1">
                            {{-- <i class="fa fa-check-circle text-success" aria-hidden="true"></i> --}}
                            <h2>Thank you!</h2>
                            <h6>{{$message}}</h6>
                        </div>
                    @else
                        <div class="p-4 text-center h1">
                            <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                            <h4>You’ve cancelled the payment!</h4>
                            <h6>{{$message}}</h6>
                        </div>
                    @endif
                    <div class="text-center">
                        <a href="/" class="btn btn-primary text-white">Go Back</a>
                    </div>
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
