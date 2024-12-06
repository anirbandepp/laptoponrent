@extends('customer.main')
@section('title', 'Thank you')
@section('content')

<section class="vh-100">

	<div class="container py-5 h-100">
		<div class="row d-flex align-items-center justify-content-center h-100">
			<div class="col-md-12 col-lg-12 col-xl-6 offset-xl-1 m-auto" id="login-form">
				<div class="b-logo">
					<img src="{{ asset('assets/img/logo.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
				</div>
			   
				<div class="text-center py-4 my-4">
                    @if (session()->has('msg'))
						<div class="pb-4">
							<h5 class="py-2">{{ session('msg') }}</h5>
						</div>
                    @endif
					{{-- <div class="pb-4">
						<h5 class="py-2">A verification email is sent to your email address. Please click an activation link in the email to login.</h5>
					</div> --}}
                    <a href="{{url('/customer/dashboard')}}" class="btn login btn-lg btn-block rounded-pill btn-success w-25 text-capitalize text-light" style="margin-left: 37%;">Login</a>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection