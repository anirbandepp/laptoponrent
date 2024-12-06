@extends('adminlte::page')

@section('title', 'Customre List')

@section('content_header')
    <h1>Update Rental Details</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.show', $customerDetails->id) }}" role="tab" aria-controls="home"
                                aria-selected="true"><i class="fa fa-list" aria-hidden="true"></i> Back</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('rental.create', ['customer' => $customerDetails->id]) }}"
                                role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-plus"
                                    aria-hidden="true"></i>
                                Create</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('rental.edit', $rentalItem->id) }}" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fa fa-eye" aria-hidden="true"></i>
                                Edit/View</a>
                        </li>
                    </ul>
                    <form action="{{ route('rental.update', $rentalItem->id) }}" method="post">
                        <div class="mt-2">
                            For <b>{{ $customerDetails->name }}</b>,
                        </div>
                        @csrf
                        @method('patch')
                        <input type="hidden" name="customer_id" value="{{ $customerDetails->id }}">
                        <div class="row form-group">
                            <div class="col-md-2">
                                <label for="subscription_date">Start Date:</label><span class="text-danger">*</span>
                                <input type="date" name="subscription_date" id="subscription_date"
                                    class="form-control @error('subscription_date') is-invalid @enderror"
                                    value="{{ old('subscription_date') ?? $rentalItem->subscription_date }}"
                                    placeholder="Enter subscription start date">
                                @error('subscription_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- {{dd($rentalItem->subscription_date_end)}} --}}
                            @php
                                if($rentalItem->subscription_date_end == null){
                                    $rentalItem->subscription_date_end2 = 'checked';
                                    $rentalItem->subscription_date_end1 = 'disabled';
                                }else{
                                    $rentalItem->subscription_date_end2 = '';
                                    $rentalItem->subscription_date_end1 = '';
                                }
                                
                            @endphp
                            <div class="col-md-4" id="subscription_date_end_data">
                                <div class="form-group">
                                    <label for="subscription_date_end">End Date:</label>  
                                    <div class="d-flex">
                                        <input type="date" name="subscription_date_end" id="subscription_date_end"
                                            class="form-control w-50 mr-4 @error('subscription_date_end') is-invalid @enderror"
                                            value="{{ old('subscription_date_end') ?? $rentalItem->subscription_date_end }}" {{$rentalItem->subscription_date_end1}}>
                                        @error('subscription_date_end')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        
                                        {{-- {{dd()}} --}}
                                        <input type="checkbox" class="form-control" style="width: 8%" name="subscription_date_end" id="check_end_date" value="" {{$rentalItem->subscription_date_end2}}><br/>
                                        <label for="subscription_date_end" class="mt-2">Until Cancelled</label> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="time_period">Billing</label><span class="text-danger">*</span>
                                <select class="form-control @error('time_period') is-invalid @enderror"name="time_period"
                                    id="time_period">
                                    <option value="">Select Billing Period</option>
                                    {{-- <option value="Yearly" {{ $rentalItem->time_period == 'Yearly' ? 'selected' : '' }}>Yearly</option> --}}
                                    <option value="Monthly" {{$rentalItem->time_period == 'Monthly' ? 'selected' : ''}}>Monthly</option>
                                    <option value="Daily" {{$rentalItem->time_period == 'Daily' ? 'selected' : ''}}>Daily</option>
                                    {{-- <option>Days</option> --}}
                                </select>
                                @error('time_period')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="timeperiod">Total Rental per billing cycle</label>
                                <input type="text" hidden id="arrayValue" name="arrayValue" class="form-control">
                                <input type="text" disabled id="totalAmountDisplay" name="totalAmountDisplay" value="{{$rentalItem->total_amount}}" class="form-control">
                                <input type="text" hidden id="totalAmount" name="totalAmount" value="{{$rentalItem->total_amount}}" class="form-control">
                            </div>
                        </div>
                        @php
                            $arrayAmount = [];
                            $arrayString = '';
                        @endphp
                        @foreach ($rentalItem->rentals as $key => $item)
                        <label>Item Number: {{$key+1}}</label>
                        <div class="form-group row mt-2">
                            <input type="text" hidden name="productIds[]" value="{{$item->id}}" id="">
                            <div class="col-md-4">
                                <label for="name">Product Name</label><span class="text-danger">*</span>
                                <input type="text" name="name[]" id="name" class="form-control @error('name.'.$key) is-invalid @enderror"
                                    value="{{ $item->name }}">
                                @error('name.'.$key)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Enter value.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="category">Category</label><span class="text-danger">*</span>
                                <input type="text" name="category[]" id="category"
                                    class="form-control @error('category.'.$key) is-invalid @enderror"
                                    value="{{ $item->category }}">
                                @error('category.'.$key)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Enter value.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <label for="quantity">Quantity</label><span class="text-danger">*</span>
                                <input type="text" name="quantity[]" id="quantity{{$key+1}}"
                                    class="form-control @error('quantity.'.$key) is-invalid @enderror"
                                    value="{{ $item->quantity }}" onKeyUp="multiply({{$key+1}})">
                                @error('quantity.'.$key)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Enter value.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="rent_quantity">Rent/quantity</label><span class="text-danger">*</span>
                                <input type="text" name="rent_quantity[]" id="rent_quantity{{$key+1}}"
                                    class="form-control @error('rent_quantity.'.$key) is-invalid @enderror"
                                    value="{{ $item->rent_quantity }}" onKeyUp="multiply({{$key+1}})" >
                                @error('rent_quantity.'.$key)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Enter value.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-3" style="padding: 0">
                                <label for="amount">Amount</label><span class="text-danger">*</span>
                                <input type="text" name="amount[]" id="amount{{$key+1}}" class="form-control numberSystem @error('amount.'.$key) is-invalid @enderror" disabled onchange="addAmount(this)"
                                    value="{{ $item->amount }}">
                                    @php
                                    $arrayAmount[$key] = $item->amount;
                                    if (count($rentalItem->rentals) == ($key+1)) {
                                        $arrayString = implode(',', $arrayAmount);
                                        // echo '<script> $("#arrayValue").val('.$arrayString.');</script>';
                                    }
                                @endphp
                                @error('amount.'.$key)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Enter value.</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="description">Description</label><span class="text-danger">*</span>
                                <textarea class="form-control @error('description.'.$key) is-invalid @enderror" name="description[]" id="description"
                                    rows="7">{{ $item->description }}</textarea>
                                @error('description.'.$key)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Enter value.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                        <input type="hidden" value="{{count($rentalItem->rentals)}}" name="total_chq" id="total_chq">
                        {{-- Deposit Section --}}
                        <hr>
                        <label>Payments</label>
                        <div class="form-group row mt-2">
                            <div class="col-md-4">
                                <label for="deposit_amount">Deposit Amount</label><span class="text-danger">*</span>
                                <input type="text" name="deposit_amount" id="deposit_amount" class="form-control @error('deposit_amount') is-invalid @enderror"
                                    value="{{ old('deposit_amount') ?? $rentalItem->deposit_amount }}">
                                @error('deposit_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>Enter value.</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-25">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    
      
    
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('input.numberSystem').keypress(function(e) {
                var a = [];
                var k = e.which;

                for (i = 48; i < 58; i++)
                    a.push(i);

                if (!(a.indexOf(k) >= 0))
                    e.preventDefault();
            });
            $('#check_end_date').click(function() {
                if ($(this).prop("checked") == true) {
                    $('#subscription_date_end').attr('disabled', 'disabled');
                    $('#subscription_date_end').val('');
                }else{
                    $("#subscription_date_end").removeAttr('disabled');
                }
            });
            $("#arrayValue").val("{{$arrayString}}");
        });

        function addAmount(value, del='false') {
            oldValue = $('#totalAmount').val();
            arrayString = $('#arrayValue').val();
            arrayCovent = arrayString.split(',');
            amountIndex = value.id.replace('amount', '');
            if(typeof arrayCovent[amountIndex] === 'undefined') {
                newValue = parseInt(oldValue)+parseInt(value.value);
                $('#arrayValue').val(arrayString+','+value.value);
            }else if(del == "true"){
                newValue = parseInt(oldValue) - parseInt(value.value);
                delete arrayCovent[amountIndex];
                $('#arrayValue').val(arrayCovent.toString());
            }else {
                newOldValue = parseInt(oldValue) - parseInt(arrayCovent[amountIndex]);
                arrayCovent[amountIndex] = value.value;
                newValue = parseInt(newOldValue)+parseInt(value.value);
                $('#arrayValue').val(arrayCovent.toString());
            }
            $('#totalAmountDisplay').val(newValue);
            $('#totalAmount').val(newValue);
        }        
        $("#arrayValue").val("{{$arrayString}}");

        function multiply(id) {
            var totalamount = parseInt($(`#quantity${id}`).val()) * parseInt($(`#rent_quantity${id}`).val());
            if (isNaN(totalamount)) {
                $(`#amount${id}`).val(0);
            } else {
                let value = {
                    id: `amount${id}`,
                    value: totalamount,
                };
                console.log($(`#amount${id}`).val());
                oldValue = $('#totalAmount').val();
                if ($(`#amount${id}`).val() != 0) {
                    newOldValue = parseInt(oldValue) - parseInt($(`#amount${id}`).val());
                    $(`#amount${id}`).val(totalamount);
                    newValue = parseInt(newOldValue) + parseInt(totalamount);

                    // addAmount(value, "true")
                } else {
                    $(`#amount${id}`).val(totalamount);
                    newValue = parseInt(oldValue) + parseInt(totalamount);
                }
                $('#totalAmount').val(newValue);
                $('#totalAmountDisplay').val(newValue);

            }
        }
    </script>
@endsection
