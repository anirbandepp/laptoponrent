@extends('customer.main')
@section('title', 'Upload Documents')
@section('content')

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">

                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 m-auto" id="login-form">
                    <div class="b-logo">
                        <img src="{{ asset('assets/img/favicon.png') }}" class="rounded mx-auto d-block pb-3" alt="...">
                    </div>
                    <div class="varification-title">
                        <h6 class="text-center pb-3">Upload your documents here</h6>
                    </div>
                    <form action="{{ route('customer.update_documnets') }}" method="post" enctype="multipart/form-data">
                        @method('post')
                        @csrf

                        <!-- PAN card input -->
                        @if (!isset($result['pan_card']))
                            <div class="mb-3">
                                <label for="">PAN Card</label>
                                <div class="form-outline">
                                    <input type="file" name="pan_card" class="form-control form-control-lg" />
                                </div>
                                @error('pan_card')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif


                        <!-- Electricity Bill input -->
                        @if (!isset($result['electricity_bill']))
                            <div class="mb-3">
                                <label for="">Electricity Bill</label>
                                <div class="form-outline">
                                    <input type="file" name="electricity_bill" class="form-control form-control-lg" />
                                </div>
                                @error('electricity_bill')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <!-- Property Tax bill input -->
                        @if (!isset($result['property_tax_bill']))
                            <div class="mb-3">
                                <label for="">Property Tax Bill</label>
                                <div class="form-outline">
                                    <input type="file" name="property_tax_bill" class="form-control form-control-lg" />
                                </div>
                                @error('property_tax_bill')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <!-- Submit button -->
                        <button type="submit" class="btn login btn-lg btn-block rounded-pill btn-success">UPLOAD</button>

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
    <script></script>
@endsection
