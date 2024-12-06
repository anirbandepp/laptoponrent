@extends('customer.main')
@section('title', 'Email Verification')
@section('content')

<div>
	&nbsp
</div>
<div class="container" style="padding-top:40px; padding-bottom: 40px;">
	<div class="text-center py-4 my-4">
		<h2 class="my-4">Thanks for the verification.</h2>
		{{-- <h3 class="text-success text-bold">Thank you</h3> --}}
		<h5 class="">
			<a href="{{url('/customer/dashboard')}}" class="btn login btn-lg btn-block rounded-pill btn-success w-25 text-capitalize text-light" style="margin-left: 37%;">Login</a>
		</h5>
	</div>
</div>

@endsection