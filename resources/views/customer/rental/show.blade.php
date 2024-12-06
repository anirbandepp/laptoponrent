@extends('customer.main')
@section('title', 'User Dashboard')
@section('content')
    @include('customer.navbar')
    <div class="container">
        <div class="row my-4">
            <div class="col-md-12 mb-3">
                <h2>Product List & Agreement</h2>
            </div>
            <div class="col-md-12 mb-3">
                <div class="card mb-4">
                    <div class="card-header">Rental Details</div>
                        <div class="card-body row">
                            <div class="col-md-3">
                                <h6> <b> Start Date: </b> {{ empty($rental->subscription_date) ? ' Not Availble' : date('d M, Y', strtotime($rental->subscription_date)) }}</h6>
                            </div>
                            <div class="col-md-3">
                                <h6> <b> End Date: </b>{{ empty($rental->subscription_date_end) ? ' Until Cancelled' : date('d M, Y', strtotime($rental->subscription_date_end)) }}</h6>
                            </div>
                            <div class="col-md-6">
                                <h6> <b> Total Rental per billing cycle:</b> &#8377;{{number_format($rental->total_amount, 2)}}/ {{$rental->time_period}}</h6>
                            </div>
                            {{-- <div class="col-md-2" style="padding: 0">
                                <h6> <b> Deposit:</b> &#8377;{{$rental->deposit_amount}}</h6>
                            </div> --}}
                            
                        </div>
                    
                </div>
            </div>
            {{-- {{dd($rental)}} --}}
            <div class="col-md-12">
                @foreach ($rental->rentals as $key => $item)
                {{-- {{dd($item)}} --}}
                    <div class="card mb-4">
                        <div class="card-header">Item {{ $key + 1 }} ({{ $item->name }} )</div>
                        <div class="card-body row">
                            <div class="col-md-4">
                                <h6><b>Product Name: </b>{{ $item->name }} </h6>
                            </div>
                            <div class="col-md-4">
                                <h6><b>Category: </b>{{ $item->category }} </h6>
                            </div>
                            <div class="col-md-4">
                                <h6><b>Rent:</b> &#8377;{{ number_format($item->rent_quantity, 2) }}</h6>
                            </div>
                            <div class="col-md-4">
                                <h6><b>Quantity: </b>{{ $item->quantity }} </h6>
                            </div>
                            <div class="col-md-7">
                                <h6><b>Amount:</b> &#8377;{{ number_format($item->amount, 2) }} </h6>
                            </div>
                            <div class="col-md-12">
                                <h6><b>Description : </b>{!! $item->description !!}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="card">
                    <div class="card-header d-flex">
                        <div class="col-md-10">Agreement</div>
                        {{-- <div class="col-md-2 text-right">
                            <i class="fa fa-download" aria-hidden="true"></i>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        @if (empty($rental->agreement_doc))
                            <p>{!! $agreement !!}</p>
                        @else
                        {{-- {{url('/')}} --}}
                        {{-- {{dd($rental->agreement_doc)}} --}}
                            <div class="text-center">
                                <embed src="{{ asset('storage/' . $rental->agreement_doc) }}" width="800px" height="2100px" />
                                {{-- <embed src="{{ asset('storage/sign/' . $rental->agreement_sign) }}" width="800px" height="2100px" /> --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if (empty($rental->agreement_sign))
                <div class="col-md-12 mt-2">
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                Signature
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="wrapper border">
                                        <canvas id="signature-pad" class="w-100" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button type="button" class="btn btn-success" onclick="onClickSign()">Submit</button>
                                    <button type="button" class="btn btn-danger" id="clear"><span> Clear
                                        </span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('css')
@endsection
@section('js')
    @if (empty($rental->agreement_sign))
        <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js"></script>
        <script>
            var canvas = document.getElementById("signature-pad");

            function resizeCanvas() {
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }
            window.onresize = resizeCanvas;
            resizeCanvas();
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(250,250,250)'
            });
            document.getElementById("clear").addEventListener('click', function() {
                signaturePad.clear();
            })

            function onClickSign() {
                var canvas = document.getElementById("signature-pad");
                $.ajax({
                    type: "POST",
                    url: "{{ route('customer.sign', $rental->id) }}",
                    data: {
                        'sign': canvas.toDataURL(),
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response) {
                            location.reload();
                        }
                    }
                });
            }
        </script>
    @endif
@endsection
