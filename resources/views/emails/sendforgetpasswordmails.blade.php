
@extends('customer.main')
@section('title', 'Forget password mail')
@section('content')

    <section class="vh-100">

        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto" id="login-form">
                    <div class="b-logo">
                        <img src="{{ asset('assets/img/logo.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
                    </div>
                   
					<div class="text-center py-4 my-4">
						<h2 class="my-4">Check your email for new password</h2>
						<h3 class="text-success text-bold">Thank you ! </h3>
                        <h4><a href="{{url('/')}}" class="text-info">Click Me</a></h4>
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
