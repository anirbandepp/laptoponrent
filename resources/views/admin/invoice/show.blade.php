@extends('adminlte::page')

@section('title', 'Client Invoice')

@section('content_header')
    {{-- <h1>Client Invoice</h1> --}}
    {{-- @foreach ($invoices as $key => $item)
        <select name="" id="">
            <option value="">{{ $item->customer->name }}</option>
        </select>
    @endforeach   --}}
    <div class="row">
        <div class="col-md-5" style="padding-right: 0">
            <h1>Client Invoice</h1>
        </div>
        <div class="col-md-7 my-2">
            <form action="{{ route('invoices.nameFilter') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-4 text-right"><label for="">Filter By </label></div>
                    <div class="col-sm-4" id="">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                            placeholder="Client name" required />
                    </div>
                    <div class="col-sm-4"><button type="submit" class="btn btn-success">Submit</button></div>
                </div>
            </form>
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-md-12">
            <div class="col-md-4 float-left ">
                <div class="card cardbg">
                    <div class="card-body">
                        <span class="fontPriceSpan">
                            Total Income
                            <select name="filter_amount" id="customFilter" onchange="filterPrice()">
                                <option value="today">Today</option>
                                <option value="week" selected>This week</option>
                                <option value="month">This month</option>
                                <option value="year">This year</option>
                                {{-- <option value="custom">Custom</option> --}}
                            </select>
                        </span>
                        <p class="fontPriceSize font-weight-bold">
                            &#8377;
                            <span id="setFiterPaidAmount">{{ number_format($paid, 2) }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 float-left ">
                <div class="card cardbg">
                    <div class="card-body">
                        <span class="fontPriceSpan">Total Due </span>
                        <p class="fontPriceSize font-weight-bold">
                            &#8377; {{ number_format($pending, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @if (isset($filteredData['pending']))
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body pt-0 pb-2">
                        <div class="row px-4 pt-2">
                            <div class="col-md-6"><span class="text-danger">Pending:</span> Rs.
                                {{ $filteredData['pending'] }}</div>
                            <div class="col-md-6"><span class="text-success">Paid:</span> Rs. {{ $filteredData['paid'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}
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
                                    {{-- <br>
                                    <div class="row">
                                        <div class="col-md-6">Total Pending: $15,000 </div>
                                        <div class="col-md-6">Total Paid: Rs.30,000</div>
                                    </div> --}}
                                </div>
                                {{-- <div class="row px-4 pt-2">
                                    <div class="col-md-6"><span class="text-danger">Total Pending:</span> &#8377; {{$pending}}</div>
                                    <div class="col-md-6"><span class="text-success">Total Paid:</span> &#8377; {{$paid}}</div>
                                </div>
                                <hr style="margin-bottom: 0"> --}}
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                {{-- <td>#</td> --}}
                                                <th>Invoice#</th>
                                                <th>Client Name</th>
                                                <th>Rental ID</th>
                                                <th>Invoice Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($invoices))


                                                @foreach ($invoices as $key => $item)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $item->customer->name }}</td>
                                                        <td>{{ $item->rental_id }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                                        <td>{!! $item->description !!}</td>
                                                        <td style="width: 100px">
                                                            &#8377; {{ number_format($item->payment) }}
                                                        </td>
                                                        <td>
                                                            @if ($item->payment_status == 'Paid')
                                                                <span
                                                                    class="text-success">{{ $item->payment_status }}</span>
                                                            @else
                                                                <span
                                                                    class="text-danger">{{ $item->payment_status }}</span>
                                                            @endif
                                                        </td>
                                                        <td style="width: 260px">
                                                            @if ($item->payment_paid_date != '')
                                                                {{ $item->payment_paid_date }}
                                                            @else
                                                                <a href="#"onclick="emailPaymentLink('{{ $item->customer->email }}',{{ $item->id }})"
                                                                    data-toggle="modal"
                                                                    data-target="#emailPaymentLink">Email
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
                                            @else
                                                <tr class="text-center" style="height: 180px">
                                                    <td colspan="7"><span class="notFoundFont">Invoice not found for this
                                                            Client</span></td>
                                                </tr>

                                            @endif
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

    {{-- Email Payment Link Model --}}
    <div class="modal fade" id="emailPaymentLink" tabindex="-1" aria-labelledby="emailPaymentLinkLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('invoice.emailLink') }}" id="formModel" method="post">
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
            <form action="{{ route('invoice.void') }}" id="formModel" method="post">
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
            <form action="{{ route('invoice.pay') }}" id="formModel" method="post">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Enter Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="invoiceId" name="invoiceId">
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .fontPriceSize {
            font-size: 50px;
        }

        .fontPriceSpan {
            font-size: 15px;
        }

        .cardbg {
            background-color: lightblue;
        }

        .notFoundFont {
            font-size: 50px;
            line-height: 180px;
            font-weight: 800;
            color: #8f4f4f6e;
        }
    </style>
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
@stop

@section('js')
    <script>
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

        $('#customFilter').change(function() {
            var $option = $(this).find('option:selected');
            var value = $option.val();
            var text = $option.text();
            if (value == 'custom') {
                $('#adddatesFilter').html(
                    '<input type="date" name="startDate" class="form-control" required/><input type="date" name="endDate" class="form-control" required/>'
                )
            }
            if (value == 'name') {
                $('#adddatesFilter').html(
                    '<input type="text" name="name" class="form-control" placeholder="Enter client name" required/>'
                )
            }
        });

        function viewDocument(img, value) {
            $("#documentModel").modal('show');
        }

        function filterPrice() {
            customFilterVal = $('#customFilter').val();
            // alert($('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                type: "POST",
                url: "{{ route('invoice.filter') }}",
                data: {
                    filter_amount: customFilterVal,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status) {
                        paidFilterAmount = response.filteredData.paid.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                            '$&,');
                        $('#setFiterPaidAmount').html(paidFilterAmount);
                    }
                    // console.log(response);
                }
            });
        }
    </script>
@endsection
