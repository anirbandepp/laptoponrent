@extends('adminlte::page')

@section('title', 'Customer Details')

@section('content_header')
    <h1>Customer Details</h1>
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
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}" role="tab" aria-controls="home"
                                aria-selected="true"><i class="fa fa-list" aria-hidden="true"></i> Customer List</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.show', $customer->id) }}" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fa fa-user" aria-hidden="true"></i>
                                {{ $customer->name }}</a>
                        </li>

                        {{-- <li class="nav-item ml-0">
                            <a class="nav-link btn btn-success" href="{{route('rental.create', ['customer' => $customer->id])}}" role="tab"
                                aria-controls="home" aria-selected="true">Documents</a>
                        </li> --}}

                        {{-- <li class="nav-item ml-auto">
                            <a class="nav-link btn btn-primary"
                                href="#" onclick="createInvoice({{$customer->id}})" data-toggle="modal" data-target="#createInvoice" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fa fa-plus" aria-hidden="true"></i>
                                Invoice</a>
                        </li> --}}
                        <li class="nav-item ml-auto">
                            <a class="nav-link btn btn-primary"
                                href="{{ route('rental.create', ['customer' => $customer->id]) }}" role="tab"
                                aria-controls="home" aria-selected="true"><i class="fa fa-plus" aria-hidden="true"></i>
                                New Rental</a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="card direct-chat direct-chat-primary m-3 col-md-6">
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title font-weight-bold"> Customer Details</h3>
                                <div class="card-tools">
                                    {{-- <span title="3 New Messages" class="badge badge-primary">3</span> --}}
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button> --}}
                                </div>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="m-3">
                                    <label>Name:</label>
                                    <label>{{ $customer->name }}</label> <br>

                                    <label>Rental For:</label>
                                    <label class="text-capitalize">{{ $customer->rental_for }}</label> <br>

                                    <label>Company Name :</label>
                                    <label>{{ $customer->companyname }}</label> <br>

                                    <label>Email:</label>
                                    <label>{{ $customer->email }}</label> <br>

                                    <label>Mobile Number:</label>
                                    <label>{{ $customer->mobile }}</label> <br>

                                </div>
                            </div>
                        </div>
                        <div class="card direct-chat direct-chat-primary m-3 col-md-5">
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title font-weight-bold"> Address & Other Details</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: block;">
                                <div class="m-3">
                                    <label>Register Date:</label>
                                    <label>{{ $customer->created_at->format('M d, Y') }}</label><br>
                                    <label>Address:</label>
                                    <label>{{ $customer->address }},</label>
                                    <label>{{ $customer->city }},</label>
                                    <label>{{ $customer->state }},</label><br>
                                    <label>Post Code:</label>
                                    <label>{{ $customer->postcode }}</label><br>
                                    <label>Country:</label>
                                    <label>{{ $customer->country }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card direct-chat direct-chat-primary mr-4">
                                <div class="card-header ui-sortable-handle" style="cursor: move;">
                                    <h3 class="card-title font-weight-bold">Documents (personal)</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <div class="row">
                                        @if (!empty($customer->documents->adhar_card))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">Aadhar Card
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->adhar_card) }}"
                                                        target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->adhar_card) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->adhar_card }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>Aadhar Card </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($customer->documents->pan_card))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">PAN Card
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->pan_card) }}"
                                                        target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->pan_card) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->pan_card }}
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- <img src="{{ asset('storage/documents/' . $customer->documents->pan_card) }}"
                                                alt="" class="w-75 p-2 m-2"> --}}
                                                <!-- <label>PAN Card <a href="">Download</a></label> -->
                                                {{-- <br>
                                                <a
                                                    href="{{ route('document.verify', ['customer' => $customer->id, 'document_name' => 'pan_card']) }}">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('document.unverify', ['customer' => $customer->id, 'document_name' => 'pan_card']) }}"
                                                    class="text-danger">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </a> --}}
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>PAN Card </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($customer->documents->electricity_bill))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">Electricity Bill
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->electricity_bill) }}"
                                                            target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->electricity_bill) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->electricity_bill }}
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- <img src="{{ asset('storage/documents/' . $customer->documents->electricity_bill) }}"
                                                    alt="" class="w-75 p-2 m-2">
                                                <label>Electricity Bill </label>
                                                <br>
                                                <a
                                                    href="{{ route('document.verify', ['customer' => $customer->id, 'document_name' => 'electricity_bill']) }}">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('document.unverify', ['customer' => $customer->id, 'document_name' => 'electricity_bill']) }}"
                                                    class="text-danger">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </a> --}}
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>Electricity Bill</h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($customer->documents->property_tax_bill))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">Property Tax Bill
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->property_tax_bill) }}"
                                                            target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->property_tax_bill) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->property_tax_bill }}
                                                        </a>
                                                    </div>
                                                </div>
                                                {{-- <img src="{{ asset('storage/documents/' . $customer->documents->property_tax_bill) }}"
                                                    alt="" class="w-75 p-2 m-2">
                                                <label>Property Tax </label>
                                                <br>
                                                <a
                                                    href="{{ route('document.verify', ['customer' => $customer->id, 'document_name' => 'property_tax_bill']) }}">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('document.unverify', ['customer' => $customer->id, 'document_name' => 'property_tax_bill']) }}"
                                                    class="text-danger">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </a> --}}
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>Property Tax Bill </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card direct-chat direct-chat-primary mr-4">
                                <div class="card-header ui-sortable-handle" style="cursor: move;">
                                    <h3 class="card-title font-weight-bold"> Documents (corporate)</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <div class="row">
                                        @if (!empty($customer->documents->gst_certificate))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">GST Certificate
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->gst_certificate) }}"
                                                        target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->gst_certificate) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->gst_certificate }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>GST Certificate </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($customer->documents->corporate_pan_card))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">PAN Card
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->corporate_pan_card) }}"
                                                        target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->corporate_pan_card) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->corporate_pan_card }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>PAN Card </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($customer->documents->office_rental_agreement))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">Office Rental Agreement
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->office_rental_agreement) }}"
                                                        target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->office_rental_agreement) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->office_rental_agreement }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>Office Rental Agreement</h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($customer->documents->incorporation_certificate))
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="textSize">Incorporation Certificate
                                                            {{-- <a href="{{ url('/storage/documents/' . $customer->documents->incorporation_certificate) }}"
                                                            target="BLANK" >View</a> --}}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">
                                                        <a href="{{ url('/storage/documents/' . $customer->documents->incorporation_certificate) }}"
                                                            target="BLANK">
                                                            {{ $customer->documents->incorporation_certificate }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6>Incorporation Certificate </h6>
                                                    </div>
                                                    <div class="card-body" style="padding: 15px">

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mr-5">
                            <div class="card direct-chat direct-chat-primary mr-4">
                                <div class="card-header ui-sortable-handle" style="cursor: move;">
                                    <h3 class="card-title font-weight-bold"> Rentals</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Subscription Start</th>
                                                <th>Subscription End</th>
                                                <th>Rent</th>
                                                <th>Deposit</th>
                                                <th>Agreement</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($rentals as $key => $item)
                                                {{-- {{dd($item->depositAmounts[0]->deposit_amount)}} --}}
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ date('d M, Y', strtotime($item->subscription_date)) }}</td>
                                                    <td>
                                                        {{ $item->subscription_date_end == 'on' || empty($item->subscription_date_end) ? 'Until Cancelled' : date('d M, Y', strtotime($item->subscription_date_end)) }}
                                                    </td>
                                                    <td>&#8377;{{ number_format($item->total_amount) }}/{{ $item->time_period }}
                                                    </td>
                                                    <td>{{ empty($item->deposit_amount) ? '' : '₹ ' . number_format($item->deposit_amount, 2) }}
                                                    </td>
                                                    {{-- {{dd($item)}} --}}
                                                    <td>{!! (empty($item->agreement_sign)
                                                        ? '<a href="' . route('rental.show', $item->id) . '" class="mr-2"><b class="text-danger">Not yet signed!</b></a>'
                                                        : '<a href="' .
                                                            asset('storage/' . $item->agreement_doc) .
                                                            '" target="_black" class="mr-2"><b class="text-success">Singed on ' .
                                                            date('d M, Y h:m:s', str_replace(['sign/agreement_', '.png'], '', $item->agreement_sign))) . '</b>' !!}</td>
                                                    <td class="d-flex justify-content-center">
                                                        {{-- Agreement</a> --}}
                                                        <a href="{{ route('rental.edit', $item->id) }}"
                                                            class="">View</a>&nbsp;&nbsp;
                                                        <a href="#" role="tab" aria-controls="home"
                                                            aria-selected="true"><i class="fa fa-plus"
                                                                aria-hidden="true"></i>
                                                            Invoice</a>
                                                        {{-- <a href="#" onclick="createInvoice({{$customer->id}})" data-toggle="modal" data-target="#createInvoice" role="tab"
                                                            aria-controls="home" aria-selected="true"><i class="fa fa-plus" aria-hidden="true"></i>
                                                            Invoice</a> --}}
                                                        {{-- <form action="{{route('rental.destroy', $item->id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn"><i class="fa fa-trash"></i></button>
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
                    <div class="row">
                        <div class="col-md-12 mr-5">
                            <div class="card direct-chat direct-chat-primary mr-4">
                                <div class="card-header ui-sortable-handle" style="cursor: move;">
                                    <h3 class="card-title font-weight-bold"> Invoice & Payments</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row px-4 pt-2">
                                    <div class="col-md-6"><span class="text-danger">Total Pending:</span> Rs.
                                        {{ $pending }}</div>
                                    <div class="col-md-6"><span class="text-success">Total Paid:</span> Rs.
                                        {{ $paid }}</div>
                                </div>
                                <hr style="margin-bottom: 0">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Invoice#</th>
                                                <th>Invoice Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{dd($invoices)}} --}}
                                            @foreach ($invoices as $key => $item)
                                                {{-- {{dd($item)}} --}}
                                                <tr>
                                                    <td>{{ $item->rental_id }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                                    <td>{!! $item->description !!}</td>
                                                    <td>
                                                        &#8377; {{ number_format($item->payment, 2) }}
                                                    </td>
                                                    <td>
                                                        @if ($item->payment_status == 'Paid')
                                                            <span class="text-success">{{ $item->payment_status }}</span>
                                                        @else
                                                            <span class="text-danger">{{ $item->payment_status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->payment_paid_date != '')
                                                            {{ $item->payment_paid_date }}
                                                        @else
                                                            <a href="#"
                                                                onclick="emailPaymentLink('{{ $customer->email }}', {{ $item->id }})"
                                                                data-toggle="modal" data-target="#emailPaymentLink">Email
                                                                Client</a>&nbsp;&nbsp;
                                                            <a href="#" onclick="voidAmount({{ $item->id }})"
                                                                data-toggle="modal"
                                                                data-target="#voidModal">Void</a>&nbsp;&nbsp;
                                                            <a href="#"
                                                                onclick="getAmount({{ $item->payment }}, {{ $item->id }})"
                                                                data-toggle="modal" data-target="#exampleModal">Enter
                                                                Payment</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->payment_status == 'Paid')
                                                            <a href="{{ route('invoice.generatePDF', ['invoiceID' => $item->id]) }}"
                                                                class="btn btn-success">
                                                                Download
                                                            </a>
                                                        @else
                                                            --
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Invoice --}}
    <div class="modal fade" id="createInvoice" tabindex="-1" aria-labelledby="createInvoiceLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('invoice.create') }}" id="formModel" method="post">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createInvoiceLabel">Billing</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="setCustomerId" name="setCustomerId" value="">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice_amount">Amount</label>
                                    <input type="text" name="invoice_amount" id="invoice_amount"
                                        class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="invoice_details">Write Details</label>
                                <textarea name="invoice_details" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="py-2 p-4">
                        <div class="row">
                            <div class="col-md-6 text-left"><button type="button" class="btn btn-danger"
                                    data-dismiss="modal">Cancel</button></div>
                            <div class="col-md-6 text-right"><button type="submit" name="submit"
                                    class="btn btn-primary">Create</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Email Payment Link Model --}}
    <div class="modal fade" id="emailPaymentLink" tabindex="-1" aria-labelledby="emailPaymentLinkLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('payment.emailLink') }}" id="formModel" method="post">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailPaymentLinkLabel">Email Client</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="invoiceEmailId" name="invoiceEmailId" value="">
                    <div class="modal-body">
                        <h6 id="textCustomerEmail"><span></span></h6>
                    </div>
                    <div class="py-2 p-4">
                        <div class="row">
                            <div class="col-md-6 text-left"><button type="button" class="btn btn-danger"
                                    data-dismiss="modal">Cancel</button></div>
                            <div class="col-md-6 text-right"><button type="submit" name="submit"
                                    class="btn btn-primary">Send</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Void Amount Model --}}
    <div class="modal fade" id="voidModal" tabindex="-1" aria-labelledby="voidModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('payment.void') }}" id="formModel" method="post">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="voidModalLabel">PLEASE CONFIRM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="invoiceVoidId" name="invoiceVoidId" value="">
                    <div class="modal-body">
                        <h6 id="textCVoidMsg"><span></span></h6>
                    </div>
                    <div class="py-2 p-4">
                        <div class="row">
                            <div class="col-md-6 text-left"><button type="button" class="btn btn-danger"
                                    data-dismiss="modal">Cancel</button></div>
                            <div class="col-md-6 text-right"><button type="submit" name="submit"
                                    class="btn btn-primary">Confirm</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Payment Model --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('payment.pay') }}" id="formModel" method="post">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="invoiceId" name="invoiceId" value="">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_amount">Amount</label>
                                    <input type="text" name="payment_amount" id="payment_amount" readonly
                                        value="&#8377;" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_paid_date">Payment Date</label>
                                    <input type="date" name="payment_paid_date" value="<?php echo date('Y-m-d'); ?>"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="write_details">Write Details</label>
                                <textarea name="write_details" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="py-2 p-4">
                        <div class="row">
                            <div class="col-md-6 text-left"><button type="button" class="btn btn-danger"
                                    data-dismiss="modal">Close</button></div>
                            <div class="col-md-6 text-right"><button type="submit" name="submit"
                                    class="btn btn-primary">Submit</button></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@stop

@section('js')
    <script>
        function createInvoice(id) {
            $('#setCustomerId').val(id);
        }

        function emailPaymentLink(email, id) {
            $('#textCustomerEmail').html('Email sent to ' + email);
            $('#invoiceEmailId').val(id);
        }

        function voidAmount(voidId) {
            $('#invoiceVoidId').val(voidId);
            $('#textCVoidMsg').html('Are you sure you want to cancel this invoice# ' + voidId);
        }

        function getAmount(amount, id) {
            var setAmount = '₹ ' + amount;
            $('#payment_amount').val(setAmount);
            $('#invoiceId').val(id);
        }
    </script>
@endsection
