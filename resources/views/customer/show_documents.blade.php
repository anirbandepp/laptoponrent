@extends('customer.main')
@section('title', 'Show Documents')
@section('content')

    @include('customer.navbar')

    <div class="container">
        <div class="row py-3" style="text-align: center">
            {{-- <div class="card"> --}}
            <div class="card-header bg-light mb-2">
                <h5>Only PDF, DOC, DOCX, JPG, JPEG formats are allowed. Maximum file size to upload is 5MB.</h5>
            </div>
            @if (session()->has('msg'))
                <div class="bg-light mb-2">
                    <h5 class="py-2 text-success">{{ session('msg') }}</h5>
                </div>
            @endif
            {{-- </div> --}}
           <div class="card">
            <div class="card-header" style="text-align: left">
                Documents (personal)
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $id = session()->get('ADMIN_EMAIL');
                    @endphp
                    {{-- Aadhar Card --}}
                    @if (isset($result['adhar_card']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">Aadhar Card 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->adhar_card) }}"
                                        target="BLANK" >View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->adhar_card) }}" target="BLANK">
                                        <h4> {{ $result->adhar_card }}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">Aadhar Card Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="adhar_card" class="form-control" id="adharCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="adhar" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('adhar_card')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
            
        
                    {{-- PAN Card --}}
                    @if (isset($result['pan_card']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">PAN Card 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->pan_card) }}"
                                        target="BLANK">View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->pan_card) }}" target="BLANK">
                                        <h4> {{ $result->pan_card }}</h4>
                                    </a>
                                </div>
                            </div>                    
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post" enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">PAN Card Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="pan_card" class="form-control" id="panCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="pan" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('pan_card')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
        
        
                    {{-- Electricity Bill --}}
                    @if (isset($result['electricity_bill']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">Electricity Bill 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->electricity_bill) }}"
                                        target="BLANK">View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->electricity_bill) }}" target="BLANK">
                                        <h4> {{ $result->electricity_bill }}</h4>
                                    </a>
                                </div>
                            </div>   
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post" enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">Electricity Bill Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="electricity_bill" class="form-control" id="panCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="pan" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('electricity_bill')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
            
                    {{-- Property Tax Bill --}}
                    @if (isset($result['property_tax_bill']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">Property Tax Bill 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->property_tax_bill) }}"
                                        target="BLANK">View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->property_tax_bill) }}" target="BLANK">
                                        <h4> {{ $result->property_tax_bill }}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post" enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">Property Tax Bill Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="property_tax_bill" class="form-control" id="panCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="pan" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('property_tax_bill')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-header" style="text-align: left">
                Documents (corporate)
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- GST Certificate --}}
                    @if (isset($result['gst_certificate']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">GST Certificate 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->gst_certificate) }}"
                                        target="BLANK" >View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->gst_certificate) }}" target="BLANK">
                                        <h4> {{ $result->gst_certificate }}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">GST Certificate Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="gst_certificate" class="form-control" id="adharCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="adhar" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('gst_certificate')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
            
                    {{-- Corporate PAN Card --}}
                    @if (isset($result['corporate_pan_card']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">PAN Card 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->corporate_pan_card) }}"
                                        target="BLANK">View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->corporate_pan_card) }}" target="BLANK">
                                        <h4> {{ $result->corporate_pan_card }}</h4>
                                    </a>
                                </div>
                            </div>                    
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post" enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">PAN Card Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="corporate_pan_card" class="form-control" id="panCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="pan" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('corporate_pan_card')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
        
                    {{-- Office Rental Agreement --}}
                    @if (isset($result['office_rental_agreement']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">Office Rental Agreement 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->office_rental_agreement) }}"
                                        target="BLANK">View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->office_rental_agreement) }}" target="BLANK">
                                        <h4> {{ $result->office_rental_agreement }}</h4>
                                    </a>
                                </div>
                            </div>                    
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post" enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">Office Rental Agreement Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="office_rental_agreement" class="form-control" id="panCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="pan" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('office_rental_agreement')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
        
        
                    {{-- Incorporation Certificate --}}
                    @if (isset($result['incorporation_certificate']))
                        <div class="col-sm-6 pb-2">
                            <div class="card" style="height: 193px;">
                                <div class="card-header">
                                    <h5 class="textSize">Incorporation Certificate 
                                        {{-- <a href="{{ url('/storage/documents/' . $result->incorporation_certificate) }}"
                                        target="BLANK">View</a> --}}
                                    </h5>
                                </div>
                                <div class="card-body" style="margin-top: 30px;">                            
                                    <a href="{{ url('/storage/documents/' . $result->incorporation_certificate) }}" target="BLANK">
                                        <h4> {{ $result->incorporation_certificate }}</h4>
                                    </a>
                                </div>
                            </div>   
                        </div>
                    @else
                        <div class="col-sm-6 pb-2">
                            <div class="card">
                                <form action="{{ url('customer/upload_documents/' . $id) }}" method="post" enctype="multipart/form-data">
                                    @method('post')
                                    @csrf
                                    <p class="textSize">Incorporation Certificate Not Uploaded</p>
                                    <div class="card-body">
                                        <input type="file" name="incorporation_certificate" class="form-control" id="panCard" required>
                                        <div class="profile-pic pt-1">
                                            {{-- <embed src="" id="pan" width="100%">  --}}
                                        </div>
                                        <button type="submit" class="btn login btn-md btn-block rounded-pill btn-success"
                                            style="margin-top: 30px;">UPLOAD</button>
                                        @error('incorporation_certificate')
                                            <div class="error mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
           </div>
        </div>
    </div>

@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <style>
        body {
            background-color: #5F9EA0;
        }

        .card {}

        .profile-badge {
            border: 1px solid #c1c1c1;
            padding: 5px;
            position: relative;
        }

        .profile-pic {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1001;

        }

        .profile-pic img {
            border-radius: 50%;
            box-shadow: 0px 0px 5px 0px #c1c1c1;
            cursor: pointer;
            width: 130px;
            height: 130px;
        }

        .hidden {
            display: none;
        }

        .card-img-top {
            height: 180px;
        }

        .textSize {
            margin: 10px;
            text-align: center;
            font-size: 18px;
        }

        .error {
            color: red;
        }
    </style>
@endsection

@section('js')
    <script>
        // Adhar Card
        var adharCard = $('#adharcard').val();
        if (adharCard != null) {
            adharCard.onchange = evt => {
                const [file] = adharCard.files
                if (file) {
                    adhar.src = URL.createObjectURL(file)
                }
            }
        }

        // function previewFile4() {
        //     var preview4 = document.querySelector('#profile-image4');
        //     var file4 = document.querySelector('input[name=adhar_card]').files[0];
        //     var reader = new FileReader();

        //     reader.addEventListener("load", function() {
        //         preview4.src = reader.result;
        //     }, false);

        //     if (file4) {
        //         reader.readAsDataURL(file4);
        //     }
        // }
        // $(function() {
        //     $('#profile-image4').on('click', function() {
        //         $('#profile-image-upload4').click();
        //     });
        // });

        // PAN Card
        var panCard = $('#panCard').val();
        if (panCard != null) {
            panCard.onchange = evt => {
                const [file] = panCard.files
                if (file) {
                    pan.src = URL.createObjectURL(file)
                }
            }
        }

        // function previewFile1() {
        //     var preview1 = document.querySelector('#profile-image1');
        //     var file1 = document.querySelector('input[name=pan_card]').files[0];
        //     var reader = new FileReader();

        //     reader.addEventListener("load", function() {
        //         preview1.src = reader.result;
        //     }, false);

        //     if (file1) {
        //         reader.readAsDataURL(file1);
        //     }
        // }
        // $(function() {
        //     $('#profile-image1').on('click', function() {
        //         $('#profile-image-upload1').click();
        //     });
        // });

        // Electricity Bill
        var electricityBill = $('#electricityBill').val();
        if (electricityBill != null) {
            console.log('1');
            electricityBill.onchange = evt => {
                const [file] = electricityBill.files
                if (file) {
                    console.log(file);
                    electricity.src = URL.createObjectURL(file)
                }
            }
        }

        // function previewFile2() {
        //     var preview2 = document.querySelector('#profile-image2');
        //     var file2 = document.querySelector('input[name=electricity_bill]').files[0];
        //     var reader = new FileReader();

        //     reader.addEventListener("load", function() {
        //         preview2.src = reader.result;
        //     }, false);

        //     if (file2) {
        //         reader.readAsDataURL(file2);
        //     }
        // }
        // $(function() {
        //     $('#profile-image2').on('click', function() {
        //         $('#profile-image-upload2').click();
        //     });
        // });

        // Property Tax Bill
        var propertyTaxBill = $('#propertyTaxBill').val();
        if (propertyTaxBill != null) {
            propertyTaxBill.onchange = evt => {
                const [file] = propertyTaxBill.files
                if (file) {
                    propertyTax.src = URL.createObjectURL(file)
                }
            }
        }
        // function previewFile3() {
        //     var preview3 = document.querySelector('#profile-image3');
        //     var file3 = document.querySelector('input[name=property_tax_bill]').files[0];
        //     var reader = new FileReader();

        //     reader.addEventListener("load", function() {
        //         preview3.src = reader.result;
        //     }, false);

        //     if (file3) {
        //         reader.readAsDataURL(file3);
        //     }
        // }
        // $(function() {
        //     $('#profile-image3').on('click', function() {
        //         $('#profile-image-upload3').click();
        //     });
        // });
    </script>


@endsection
