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
                        <a class="nav-link" href="{{ route('agreement.index') }}" role="tab" aria-controls="home"
                            aria-selected="true"><i class="fa fa-list" aria-hidden="true"></i> Agreement List</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('agreement.create') }}" role="tab"
                            aria-controls="home" aria-selected="true"><i class="fa fa-plus" aria-hidden="true"></i>Create</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('agreement.show', $agreement->id) }}" role="tab"
                            aria-controls="home" aria-selected="true"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('agreement.edit', $agreement->id) }}" role="tab"
                            aria-controls="home" aria-selected="true"><i class="fa fa-edit" aria-hidden="true"></i>Edit</a>
                    </li> --}}
                </ul>
                <div class="mx-4 my-4">
                    {!!$agreement->content!!}
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
    <script> console.log('Hi!'); </script>
@stop