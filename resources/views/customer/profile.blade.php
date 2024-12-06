@extends('customer.main')
@section('title', 'User Profile')
@section('content')

    @include('customer.navbar')
    <div class="row mx-auto px-4 pt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 text-right">
                            <h3>User Profile</h3>
                        </div>
                        <div class="col-md-6 text-right pr-4">
                            <a href="{{ url('/customer/dashboard') }}" class="btn btn-md btn-success text-light">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Customer Details</h5>
                                        </div>
                                        <div class="card-body font-weight-bold">
                                            <p>Name: {{ $result['data']->name }} </p>
                                            <p>Rental For: {{ $result['data']->rental_for }} </p>
                                            <p>Company Name: {{ $result['data']->companyname }} </p>
                                            <p>Mobile: {{ $result['data']->mobile }} </p>
                                            <p>Email: <span class="text-lowercase">{{ $result['data']->email }} </p>
                                        </div>
                                    </div>
                                </div>                           
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Address & Other Details</h5>
                                        </div>
                                        <div class="card-body font-weight-bold">
                                            <p>Address: {{ $result['data']->address }} </p>
                                            <p>City: {{ $result['data']->city }} </p>
                                            <p>Post Code: {{ $result['data']->postcode }} </p>
                                            <p>State: {{ $result['data']->state }} </p>
                                            <p>Country: {{ $result['data']->country }} </p>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{-- <div class="col-md-6 mx-auto"> --}}
                            <div class="card">
                                <div class="card-header">
                                    <h5>Payments</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-stripped">
                                        <thead>
                                            <tr>
                                                <th>Invoice#</th>
                                                <th>Date</th>
                                                <th>Rental ID</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        {{-- {{dd($result['pendingInvoices'])}} --}}
                                        @if (!empty($result['getDataInvoices']))
                                            @foreach ($result['getDataInvoices'] as $keys=>$item)
                                       {{-- {{dd($item['created_at'])}} --}}
                                                <tbody>
                                                    <tr>
                                                        <td>{{$item['id']}}</td>
                                                        <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                        <td>{{$item['rental_id']}}</td>
                                                        <td>&#8377; {{ number_format($item['payment'], 2)}}</td>
                                                        <td>
                                                            @if ($item['payment_status'] == 'Paid')
                                                                {{$item['payment_status']}}
                                                            @else
                                                                Due
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($item['payment_status'] == 'Paid')
                                                            <a href="#" 
                                                            target="blank" 
                                                            class="btn btn-md btn-success text-light">preview</a>
                                                            @else
                                                                <a href="https://razorpay.com/payment-link/{{$item['payment_link_id']}}" 
                                                                target="blank" 
                                                                class="btn btn-md btn-success text-light">Pay Now</a>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @endforeach                                        
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
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
        tr {
            text-align: center;
            font-size: 16px;
        }

        table {
            width: 75%;
        }
        p{
            text-align: left;
            margin-bottom: 5px;
            margin-top: 5px;
        }
    </style>
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script> --}}

    <script></script>
@endsection