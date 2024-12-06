@extends('adminlte::page')

@section('title', 'Agreement List')

@section('content_header')
    <h1>Agreement List</h1>
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
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('agreement.index') }}" role="tab" aria-controls="home"
                            aria-selected="true"><i class="fa fa-list" aria-hidden="true"></i> Agreement List</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('agreement.create') }}" role="tab"
                            aria-controls="home" aria-selected="true"><i class="fa fa-plus" aria-hidden="true"></i>Create</a>
                    </li> --}}
                </ul>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Agreement Name</td>
                            <td>Agreement Date</td>
                            <td>Status</td>
                            <td style="width:5%">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agreement as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->created_at->format('d M Y')}}</td>
                                <td>{{$item->status == 1 ? 'Active' : 'Inactive'}}</td>
                                <td class="d-flex">
                                    <a href="{{route('agreement.show', $item->id)}}" class="btn text-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="{{route('agreement.edit', $item->id)}}" class="btn text-warning"><i class="fas fa-edit"></i></a>
                                    {{-- <form action="{{route('agreement.destroy', $item->id)}}" method="post">
                                        @csrf @method('DELETE')
                                        <button class="btn text-danger" type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </form> --}}
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
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop