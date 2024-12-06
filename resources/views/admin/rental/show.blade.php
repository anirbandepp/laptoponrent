@extends('adminlte::page')

@section('title', 'Agreement')

@section('content_header')
    <h1>Rental Agreement</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('customer.show', $customerDetails->id) }}" role="tab" aria-controls="home"
                                aria-selected="true"><i class="fa fa-list" aria-hidden="true"></i> Back</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('rental.create', ['customer' => $customerDetails->id]) }}" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fa fa-plus" aria-hidden="true"></i>
                                Create</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('rental.show', $customerDetails->id) }}" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fa fa-eye" aria-hidden="true"></i>
                                Show</a>
                        </li>
                    </ul>
                    <div class="pdf m-4">
                        {{-- <div class="text-center"><b>COMPUTER LEASE AGREEMENT</b></div> --}}
                        {!!$agreement!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop
