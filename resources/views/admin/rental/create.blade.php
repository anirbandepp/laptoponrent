@extends('adminlte::page')

@section('title', 'Customre List')

@section('content_header')
    <h1>Add new rental for <b>{{$customerDetails->name}} ({{$customerDetails->companyname}})</b>,</h1>
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
                            <a class="nav-link" href="{{ route('user.list') }}" role="tab" aria-controls="home"
                                aria-selected="true"><i class="fa fa-list" aria-hidden="true"></i> Customer List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('rental.create', ['customer' => $customerDetails->id]) }}" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fa fa-plus" aria-hidden="true"></i>
                                Create</a>
                        </li> --}}
                    </ul>
                    <form action="{{route('rental.store')}}" method="post">
                        <div class="mt-2">
                        </div>
                        @include('admin.rental.form')
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-25">Submit</button>
                        </div>
                    </form>
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
