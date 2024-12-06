@extends('adminlte::page')

@section('title', 'Agreement List')

@section('content_header')
    <h1>Agreement List</h1>
@stop

@section('content')
<div class="row">
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
                        <a class="nav-link active" href="{{ route('agreement.edit', $agreement->id) }}" role="tab"
                            aria-controls="home" aria-selected="true"><i class="fa fa-edit" aria-hidden="true"></i>Edit</a>
                    </li>
                </ul>
                <form action="{{route('agreement.update', $agreement->id)}}" method="post">
                    @method('PATCH')
                    @include('admin.agreement.form')
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-lg">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop