@extends('customer.main')
@section('title', 'Adhar Verification')
@section('content')

    <section class="vh-100">
        {{-- <img src="{{asset('assets/img/loader.gif')}}" id="loader" class="w-25" alt=""> --}}
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">

                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto" id="login-form">
                    <div class="b-logo">
                        <img src="{{ asset('assets/img/favicon.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
                    </div>
                    {{-- <a href="{{ route('customer.verification') }}" class="align-baseline">Skip</a> --}}
                    <div class="varification-title">
                        <h6 class="text-center pb-3">Varify your adhaar card number</h6>
                    </div>
                    {{-- <form action="{{ route('customer.verification') }}" method="post"> --}}
                    @method('post')
                    @csrf
                    <!-- Email input -->
                    <div class="mb-4">
                        <div class="form-outline">
                            <input type="text" id="aadharinput" data-type="adhaar-number" name="adhar" maxLength="14"
                                minlength="14" class="form-control form-control-lg" />
                            <label class="form-label" for="aadharinput">Adhaar card number</label>
                        </div>
                        {{-- <div class="error">d</div> --}}
                        {{-- <a href="#">Verify your Adhar</a> --}}
                        @error('adhar')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div id="preloader">
                        <div id="status">&nbsp;</div>
                    </div> --}}
                    {{-- <div class="pb-2">
                        <a href="#" onclick="skipverify()">Skip</a>
                    </div> --}}
                    <!-- Submit button -->
                    <button type="button" onclick="aadharverfiy()"
                        class="btn login btn-lg btn-block rounded-pill btn-success">Verify</button>

                    {{-- </form> --}}
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
        $(document).ready(function() {
            $('#loader').hide();
        });
        $('[data-type="adhaar-number"]').keyup(function() {
            var value = $(this).val();
            value = value.replace(/\D/g, "").split(/(?:([\d]{4}))/g).filter(s => s.length > 0).join("-");
            $(this).val(value);
        });

        $('[data-type="adhaar-number"]').on("change, blur", function() {
            var value = $(this).val();
            var maxLength = $(this).attr("maxLength");
            if (value.length != maxLength) {
                $(this).addClass("highlight-error");
            } else {
                $(this).removeClass("highlight-error");
            }
        });

        function aadharverfiy() {
            aadharNumber = $('#aadharinput').val();
            if (aadharNumber.length == 0) {
                // Please enter aadhar number
                alert("Please Enter Adhar Card Number for verifcation.")
            } else {
                $('#loader').show();
                // aadhar card verfiy code 
                if (true) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('customer.verification') }}",
                        data: {
                            aadhar: aadharNumber,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status) {
                                window.location.replace("{{ route('emails.register_thank_you') }}");
                            } else {
                                $('#loader').hide();

                                alert("Something Went worng!!");
                            }
                        }
                    });
                } else {
                    alert("Your aadhar number is wrong . Please entry vaild adhar number");
                }
            }
            $('#loader').hide();
        }

        // skip adhar number page
        function skipverify() {
            $.ajax({
                type: "POST",
                url: "{{ route('customer.verification') }}",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        window.location.replace("{{ route('customer.dashboard') }}");
                    } else {
                        $('#loader').hide();
                        alert("Something Went worng!!");
                    }
                }
            });
        }
    </script>
@endsection
