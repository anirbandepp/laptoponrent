@extends('customer.main')
@section('title', 'Registration Page')
@section('content')

    <section class="vh-100">

        <div class="container pt-0 h-100" id="signup-form">

            <div class="row d-flex align-items-center justify-content-center h-100">

                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto mt-5" id="login-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="login-page  float-end">
                                <a class="fw-bold" href="{{ url('/') }}" role="button">
                                    Login
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="b-logo">
                        <img src="{{ asset('assets/img/logo.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
                    </div>
                    <div class="signup-title pb-2">
                        <h2 class="text-center">Registration</h2>
                    </div>
                    @if (session()->has('msg'))
                        <div class="bg-light">
                            <h5 class="py-2 text-success">{{ session('msg') }}</h5>
                        </div>
                    @endif
                    <form action="{{ route('customer.registration') }}" method="post" class="needs-validation"
                        id="forms" novalidate>
                        @method('post')
                        @csrf

                        {{-- Rental Radio --}}
                        <div class="form-outline mb-2 position-relative">
                            <label class="form-label" for="rental_for"><b>Rental for</b></label>&nbsp;&nbsp;
                            <input type="radio" id="personal" name="rental_for" value="personal" required/> Personal &nbsp;&nbsp;
                            <input type="radio" id="corporate" name="rental_for" value="corporate" onclick="getDataVal()"/> Corporate
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback" style="margin-top: -10px">Required rental for field </div>
                        </div>
                        @error('rental_for')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        
                        <!-- full name input -->
                        <div class="form-outline mb-4 position-relative">
                            <input type="text" id="fullName" name="name" class="form-control form-control-lg"
                                value="{{ old('name') }}" required="" />
                            <label class="form-label" for="fullName">Full Name</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback" style="margin-top: -10px">Required full name </div>
                        </div>
                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <!-- Company name input -->
                        <div class="form-outline mb-4 position-relative" id="setinput">
                            <input type="text" name="companyname" id="companyname" class="form-control form-control-lg"
                                value="{{ old('companyname') }}" />
                            <label class="form-label" for="companyName">Company name</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback" style="margin-top: -12px">Required company name </div>
                        </div>
                        @error('companyname')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <!-- Mobile Number input -->
                        <div class="input-group form-outline mb-4 position-relative">
                            <span class="input-group-text" id="inputMobile">+91</span>
                            <input type="tel" pattern="+91[7-9]{2}-[0-9]{3}-[0-9]{4}" name="mobile"
                                value="{{ old('mobile') }}" class="form-control form-control-lg" id="inputMobile"
                                oninput="check(this)" required>
                            <label class="form-label" for="form1Example13">Mobile</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback pt-2">Required mobile number </div>
                        </div>
                        @error('mobile')
                            <div class="error">{{ $message }}</div>
                        @enderror


                        <!-- Email input -->
                        <div class="input-group form-outline mb-4 position-relative">
                            <!-- <span class="input-group-text" id="inputEmail">@</span> -->
                            <input type="email" class="form-control form-control-lg" id="inputEmail" name="email"
                                value="{{ old('email') }}" aria-describedby="inputGroupPrepend" required="">
                            <label for="inputEmail" class="form-label">Email</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback pt-2">Required full Email </div>
                        </div>
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror


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

                        <!-- Address input -->
                        <div class="form-outline mb-4 position-relative">
                            <input type="text" id="address" name="address" value="{{ old('address') }}"
                                class="form-control form-control-lg" required="" />
                            <label class="form-label" for="address">Your Address</label>
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback" style="margin-top: -12px">Required Address </div>
                        </div>

                        @error('address')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        <!-- city, postcode state, country (India only) -->
                        <div class="row g-3">
                            <div class="col-md-6 position-relative position-relative">
                                <div class="form-outline mb-0">
                                    <input type="text" class="form-control form-control-lg" id="cityName"
                                        name="city" value="{{ old('city') }}" required="">
                                    <label for="cityName" class="form-label">City</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback" style="margin-top: -12px">Required city name </div>
                                </div>
                                @error('city')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 position-relative">
                                <div class="form-outline mb-0">
                                    <input type="text" class="form-control form-control-lg" id="postCode"
                                        name="postcode" value="{{ old('postcode') }}" required="">
                                    <label for="postCode" class="form-label">Postcode</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback" style="margin-top: -12px">Required postcode </div>
                                </div>
                                @error('postcode')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 position-relative">
                                <div class="form-outline mb-4">
                                    <input type="text" class="form-control form-control-lg" id="stateName"
                                        name="state" value="{{ old('state') }}" required="">
                                    <label for="stateName" class="form-label">State</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback" style="margin-top: -14px">Required state name </div>
                                </div>
                            </div>
                            <div class="col-md-6 position-relative">
                                <div class="form-outline mb-4">
                                    <input type="text" class="form-control form-control-lg" id="countryName"
                                        name="country" value="India" readonly required="">
                                    <label for="countryName" class="form-label">Country</label>
                                    <div class="valid-feedback"></div>
                                    <div class="invalid-feedback">Required country name </div>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-around align-items-center mb-4">

                            <button type="submit"
                                class="btn login btn-lg btn-block rounded-pill btn-success">Submit</button>
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
    </style>
@endsection

@section('js')
    <script>
        // $(document).ready(function () {
        //     $("#regBtn").click(function () {
        //         alert("This is an alert message!");
        //     });
        // });
    </script>
    <script>
        {{-- Example starter JavaScript for disabling form submissions if there are invalid fields --}}
            (function() {
                'use strict'

                {{-- Fetch all the forms we want to apply custom Bootstrap validation styles to --}}
                var forms = document.querySelectorAll('.needs-validation')

                {{-- Loop over them and prevent submission --}}
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }

                            form.classList.add('was-validated')
                        }, false)
                    })
            })();

            function getDataVal()
            {
                var rental_for_val = $('input[name="rental_for"]:checked').val();
                $('#companyname').show().prop('required','true');
            }
           
    </script>
@endsection
