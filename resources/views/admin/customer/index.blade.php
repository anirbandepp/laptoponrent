@extends('adminlte::page')

@section('title', 'Customre List')

@section('content_header')
<div class="row">
    <div class="col-md-5"><h1>Customer List</h1></div>
    <div class="col-md-7 my-2">
        <form action="{{ route('home') }}" method="post">
            @csrf
            {{-- @method('post') --}}
            <div class="row">
                <div class="col-sm-6"><label for="">Search by any name, phone, and email </label></div>
                <div class="col-sm-4"><input type="text" name="search" placeholder="" class="form-control">
                    @error('search')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-2"><button type="submit" class="btn btn-success">Search</button></div>
            </div>
        </form>
    </div>
</div>
   
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
            <div class="col-md-12">
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $message }}</strong>
                </div>
            </div>
            @endif                            
        </div>
        <div class="col-md-12">
            {{-- <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-7 my-2">
                    <form action="{{ route('home') }}" method="post">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-sm-6"><label for="">Search by any name, phone, and email </label></div>
                            <div class="col-sm-4"><input type="text" name="search" placeholder="" class="form-control">
                                @error('search')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-2"><button type="submit" class="btn btn-success">Search</button></div>
                        </div>
                    </form>
                </div>
            </div> --}}
            <div class="card">
                <div class="card-body">
                    {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" href="{{route("home")}}" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-list" aria-hidden="true"></i> Customer List</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                        </li>
                      </ul> --}}
                      <table class="table">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Name / Company Name</td>
                                <td>Email</td>
                                <td>Number</td>
                                <td>Address</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer as $key => $item)
                                <tr>
                                    <td>
                                        <a href="{{route('customer.show', $item->id)}}" class="">
                                            {{$key+1}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('customer.show', $item->id)}}" class="">
                                            {{$item->name}} ({{$item->companyname}})
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('customer.show', $item->id)}}" class="">
                                            {{$item->email}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('customer.show', $item->id)}}" class="">
                                            {{$item->mobile}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('customer.show', $item->id)}}" class="">
                                            {{$item->city}}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($item->status == 'Active')
                                            <span class="text-success">{{$item->status}}</span>
                                        @endif
                                        @if ($item->status == 'Inactive')
                                            <a href="{{url('admin/customer/status/Inactive')}}/{{$item->id}}" class="text-warning">
                                                {{$item->status}}
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{route('customer.show', $item->id)}}" class="">View</a>
                                            {{-- <a href="{{route('rental.create', ['customer' => $item->id])}}" class="btn"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .error{
            color: red;
        }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop