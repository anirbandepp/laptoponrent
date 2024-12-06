@csrf
<input type="hidden" name="customer_id" value="{{ $customerDetails->id }}">
<div class="row form-group">
    <div class="col-md-2">
        <label for="subscription_date">Start Date:</label><span class="text-danger">*</span>
        <input type="date" name="subscription_date" id="subscription_date"
            class="form-control @error('subscription_date') is-invalid @enderror"
            value="{{ old('subscription_date') ?? $rentalItem->subscription_date }}" />
        <span class="text-danger" id="startDateErr"></span>
        @error('subscription_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-4" id="subscription_date_end_data">
        <div class="form-group">
            <label for="subscription_date_end">End Date:</label>
            <div class="d-flex">
                <div>
                    <input type="date" name="subscription_date_end" id="subscription_date_end"
                        class="form-control @error('subscription_date_end') is-invalid @enderror"
                        value="{{ old('subscription_date_end') ?? $rentalItem->subscription_date_end }}" required />
                    <span class="text-danger" id="endDateErr"></span>
                </div>
                {{-- @error('subscription_date_end')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror --}}
                <span class="invalid-feedback endDateMessage" role="alert">
                    <strong>Select end date</strong>
                </span>
                <input type="checkbox" class="form-control" style="width: 8%;margin-left: 60px;"
                    name="subscription_date_end" id="check_end_date" value=""><br />
                <label for="subscription_date_end" class="mt-2 ml-1">Until Cancelled</label>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <label for="time_period">Billing Cycle</label><span class="text-danger">*</span>
        <select class="form-control @error('time_period') is-invalid @enderror"name="time_period" id="time_period"
            onchange="checkSetVal()">
            <option value="">Select Billing Cycle Period</option>
            {{-- <option value="Yearly">Yearly</option> --}}
            <option value="Monthly">Monthly</option>
            <option value="Daily">Daily</option>
        </select>
        @error('time_period')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-3" style="padding: 0">
        <label for="totalamount">Total Rental per billing cycle</label>
        <input type="text" hidden id="arrayValue" name="arrayValue" class="form-control"
            value="{{ old('arrayValue') }}">
        <input type="text" disabled id="totalAmountDisplay" name="totalAmountDisplay"
            value="{{ old('totalAmount') ?? 0 }}" class="form-control">
        <input type="text" hidden id="totalAmount" name="totalAmount" value="{{ old('totalAmount') ?? 0 }}"
            class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        <button class="btn btn-success" type="button" onclick="add()"><i class="fa fa-plus"
                aria-hidden="true"></i></button>
        {{-- <button class="btn btn-danger" type="button" onclick="remove()"><i class="fa fa-minus"
                aria-hidden="true"></i></button> --}}
    </div>
</div>
{{-- {{dd(isset(old('name')))}} --}}
@if (empty(old('name')))
    <label>Item Number: 1</label>
    <div class="form-group row mt-2">
        <div class="col-md-4">
            <label for="name">Product Name</label><span class="text-danger">*</span>
            <input type="text" name="name[]" id="name"
                class="form-control @error('name.0') is-invalid @enderror"
                value="{{ old('name.0') ?? $rentalItem->name }}">
            @error('name.0')
                <span class="invalid-feedback" role="alert">
                    <strong>Enter value.</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="category">Category</label><span class="text-danger">*</span>
            <input type="text" name="category[]" id="category"
                class="form-control @error('category.0') is-invalid @enderror"
                value="{{ old('category.0') ?? $rentalItem->category }}">
            @error('category.0')
                <span class="invalid-feedback" role="alert">
                    <strong>Enter value.</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-1">
            <label for="quantity">Quantity</label><span class="text-danger">*</span>
            <input type="number" name="quantity[]" id="quantity0" onKeyUp="multiply('0')"
                class="form-control @error('quantity.0') is-invalid @enderror"
                value="{{ old('quantity.0') ?? $rentalItem->quantity }}">
            @error('quantity.0')
                <span class="invalid-feedback" role="alert">
                    <strong>Enter value.</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-2">
            <label for="rent_quantity">Rent/quantity</label><span class="text-danger">*</span>
            <input type="number" name="rent_quantity[]" id="rent_quantity0"
                class="form-control @error('rent_quantity.0') is-invalid @enderror"
                value="{{ old('rent_quantity.0') ?? $rentalItem->rent_quantity }}" onKeyUp="multiply('0')">
            @error('rent_quantity.0')
                <span class="invalid-feedback" role="alert">
                    <strong>Enter value.</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-3" style="padding: 0">
            <label for="amount">Amount</label>
            <input type="number" name="amount[]" id="amount0"
                class="form-control rentamt numberSystem @error('amount.0') is-invalid @enderror" disabled
                onchange="addAmount(this)" value="{{ old('amount.0') ?? $rentalItem->amount }}">
            @error('amount.0')
                <span class="invalid-feedback" role="alert">
                    <strong>Enter value.</strong>
                </span>
            @enderror
        </div>
        <div class="col-md-12">
            <label for="description">Description</label><span class="text-danger">*</span>
            <textarea class="form-control @error('description.0') is-invalid @enderror" name="description[]" id="description"
                rows="7">{{ old('description.0') ?? $rentalItem->description }}</textarea>
            @error('description.0')
                <span class="invalid-feedback" role="alert">
                    <strong>Enter value.</strong>
                </span>
            @enderror
        </div>
    </div>
@else
    @for ($i = 0; $i < count(old('category')); $i++)
        <label>Item Number: {{ $i + 1 }}</label>
        <div class="form-group row mt-2">
            <div class="col-md-4">
                <label for="name">Product Name</label><span class="text-danger">*</span>
                <input type="text" name="name[]" id="name"
                    class="form-control @error('name.' . $i) is-invalid @enderror"
                    value="{{ old('name.' . $i) ?? $rentalItem->name }}">
                @error('name.' . $i)
                    <span class="invalid-feedback" role="alert">
                        <strong>Enter value.</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="category">Category</label><span class="text-danger">*</span>
                <input type="text" name="category[]" id="category"
                    class="form-control @error('category.' . $i) is-invalid @enderror"
                    value="{{ old('category.' . $i) ?? $rentalItem->category }}">
                @error('category.' . $i)
                    <span class="invalid-feedback" role="alert">
                        <strong>Enter value.</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-1">
                <label for="quantity">Quantity</label><span class="text-danger">*</span>
                <input type="number" name="quantity[]" id="quantity{{ $i }}"
                    class="form-control @error('quantity.' . $i) is-invalid @enderror"
                    onKeyUp="multiply({{ $i }})"
                    value="{{ old('quantity.' . $i) ?? $rentalItem->quantity }}">
                @error('quantity.' . $i)
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="rent_quantity">Rent/quantity</label><span class="text-danger">*</span>
                <input type="number" name="rent_quantity[]" id="rent_quantity{{ $i }}"
                    class="form-control @error('rent_quantity.0') is-invalid @enderror"
                    value="{{ old('rent_quantity.0') ?? $rentalItem->rent_quantity }}"
                    onKeyUp="multiply({{ $i }})">
                @error('rent_quantity.0')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-3" style="padding: 0">
                <label for="amount">Amount</label>
                <input type="text" name="amount[]" id="amount{{ $i }}"
                    class="form-control numberSystem @error('amount.' . $i) is-invalid @enderror" disabled
                    onchange="addAmount(this)" value="{{ old('amount.' . $i) ?? $rentalItem->amount }}">
                @error('amount.' . $i)
                    <span class="invalid-feedback" role="alert">
                        <strong>Enter value.</strong>
                    </span>
                @enderror
            </div>
            <div class="col-md-12">
                <label for="description">Description</label><span class="text-danger">*</span>
                <textarea class="form-control @error('description.' . $i) is-invalid @enderror" name="description[]"
                    id="description" rows="7">{{ old('description.' . $i) ?? $rentalItem->description }}</textarea>
                @error('description.' . $i)
                    <span class="invalid-feedback" role="alert">
                        <strong>Enter value.</strong>
                    </span>
                @enderror
            </div>
        </div>
    @endfor
@endif
<div id="new_chq">
</div>
<input type="hidden" value="1" name="total_chq" id="total_chq">

{{-- Deposit Section --}}
<hr>
<label>Payments</label>
<div class="form-group row mt-2">
    <div class="col-md-4">
        <label for="deposit_amount">Deposit Amount</label><span class="text-danger">*</span>
        <input type="text" name="deposit_amount" id="deposit_amount"
            class="form-control @error('deposit_amount') is-invalid @enderror"
            value="{{ old('deposit_amount') ?? $rentalItem->deposit_amount }}">
        @error('deposit_amount')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

@section('js')
    <script>
        function checkSetVal() {
            var timePeriod = $('#time_period').val();
            // alert(timePeriod);
            if (timePeriod == 'Daily') {
                $("#subscription_date_end").removeAttr('disabled');
                $('#check_end_date').show().prop('disabled', 'true');
                $('#subscription_date_end').show().prop('required', 'true');
            }
            if (timePeriod == 'Monthly') {
                $("#check_end_date").removeAttr('disabled');
                $('#subscription_date_end').show().prop('required', 'false');
                $("#startDateErr").text("");
                $("#endDateErr").text("");
            }
        }

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
                } else {
                    $("#subscription_date_end").removeAttr('disabled');
                }
            });
        });

        var new_chq_no = 1;

        function add() {
            new_chq_no++;
            // var new_chq_no = parseInt($('#total_chq').val());
            var new_input = `
                            <div class="form-group row mt-2" id="new_${new_chq_no}">
                                <div class="col-md-12">
                                    <hr> 
                                   <div class="row">
                                    <div class="col-md-6 text-left">
                                        <label>Item Number: ${new_chq_no}</label>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button class="btn btn-danger" type="button" onclick="remove_more('${new_chq_no}')"><i class="fa fa-minus"
                                            aria-hidden="true"></i></button>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Product Name</label><span class="text-danger">*</span>
                                    <input type="text" name="name[]" id="name" class="form-control"
                                        value="{{ $rentalItem->name }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="category">Category</label><span class="text-danger">*</span>
                                    <input type="text" name="category[]" id="category"
                                        class="form-control"
                                        value="{{ $rentalItem->category }}">
                                </div>
                                <div class="col-md-1">
                                    <label for="quantity">Quantity</label><span class="text-danger">*</span>
                                    <input type="number" name="quantity[]" id="quantity${new_chq_no}"
                                        class="form-control"
                                        value="{{ $rentalItem->quantity }}" onKeyUp="multiply(${new_chq_no})">
                                </div>
                                <div class="col-md-2">
                                    <label for="rent_quantity">Rent/quantity</label><span class="text-danger">*</span>
                                    <input type="number" name="rent_quantity[]" id="rent_quantity${new_chq_no}"
                                        class="form-control @error('rent_quantity.0') is-invalid @enderror"
                                        value="{{ $rentalItem->rent_quantity }}" onKeyUp="multiply(${new_chq_no})">
                                   
                                </div>
                                <div class="col-md-3 amountDiv" style="padding: 0">
                                    <label for="amount">Amount</label><span class="text-danger">*</span>
                                    <input type="number" name="amount[]" id="amount${new_chq_no}" onchange="addAmount(this)" disabled class="form-control numberSystem"
                                        value="{{ $rentalItem->amount }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="description">Description</label><span class="text-danger">*</span>
                                    <textarea class="form-control" name="description[]" id="description"
                                        rows="7">{{ $rentalItem->description }}</textarea>
                                </div>
                            </div>`;

            $('#new_chq').append(new_input);

            $('#total_chq').val(new_chq_no);
        }

        function remove_more(idDivNum) {

            // var currId = $('#remove_attr_').val(); 
            jQuery('#new_' + idDivNum).remove();

        }

        // function remove() {
        //     var last_chq_no = $('#total_chq').val();
        //     if (last_chq_no > 1) {
        //         var amount = {
        //             id: '',
        //             value: 0
        //         };
        //         amount.id = $("#new_" + last_chq_no + " div.amountDiv input").attr('id');
        //         amount.value = $("#new_" + last_chq_no + " div.amountDiv input").val();
        //         addAmount(amount, "true")
        //         $('#new_' + last_chq_no).remove();
        //         $('#total_chq').val(last_chq_no - 1);
        //     }
        // }

        function addAmount(value, del = 'false') {
            oldValue = $('#totalAmount').val();
            arrayString = $('#arrayValue').val();
            arrayCovent = arrayString.split(',');
            amountIndex = value.id.replace('amount', '');
            console.log(arrayCovent, arrayString, amountIndex);
            // if (typeof arrayCovent[amountIndex] === 'undefined') {
            // } else 
            if (del == "true") {
                newOldValue = parseInt(oldValue) - parseInt(arrayCovent[amountIndex]);
                arrayCovent[amountIndex] = value.value;
                newValue = parseInt(newOldValue) + parseInt(value.value);
                $('#arrayValue').val(arrayCovent.toString());

                // newValue = parseInt(oldValue) - parseInt(value.value);
                // delete arrayCovent[amountIndex];
                // $('#arrayValue').val(arrayCovent.toString());
            } else {
                console.log("else");
                newValue = parseInt(oldValue) + parseInt(value.value);
                $('#arrayValue').val(arrayString + ',' + value.value);


            }

            $('#totalAmountDisplay').val(newValue);
            $('#totalAmount').val(newValue);
        }

        // Qty*amount
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
                console.log($('#arrayValue').val());
                if ($(`#amount${id}`).val() != 0) {
                    newOldValue = parseInt(oldValue) - parseInt($(`#amount${id}`).val());
                    $(`#amount${id}`).val(totalamount);
                    newValue = parseInt(newOldValue) + parseInt(totalamount);
                } else {
                    console.log("here");
                    $(`#amount${id}`).val(totalamount);
                    // newOldValue = parseInt(oldValue) - parseInt($(`#amount${id}`).val());
                    newValue = parseInt(oldValue) + parseInt(totalamount);
                }
                $('#totalAmount').val(newValue);
                $('#totalAmountDisplay').val(newValue);
                dateDiffCalculationMultiple();
            }
        }

        function dateDiffCalculationMultiple() {
            cycleType = $('#time_period').val();
            var startDate = $("#subscription_date").val();
            var endDate = $("#subscription_date_end").val();
            var totalAmountDisplay = $("#totalAmount").val();

            if (cycleType === 'Daily') {
                if (startDate.length == 0) {
                    $("#startDateErr").text("Please select start date");
                } else {
                    $("#startDateErr").text("");
                }
                if (endDate.length == 0) {
                    $("#endDateErr").text("Please select end date");
                } else {
                    $("#endDateErr").text("");
                }
                if (startDate != '' && endDate != '') {
                    var sdate = new Date(startDate);
                    var edate = new Date(endDate);
                    var dateDiff = edate - sdate;
                    var days = (dateDiff / 1000 / 60 / 60 / 24) + 1;

                    var totalRentalPerBillingCycle = totalAmountDisplay * days;
                    $('#totalAmountDisplay').val(totalRentalPerBillingCycle);
                }
            }
        }

        function dateDiffCalculation() {
            var startDate = $("#subscription_date").val();
            var endDate = $("#subscription_date_end").val();
            var totalAmountDisplay = $("#totalAmount").val();


            var sdate = new Date(startDate);
            var edate = new Date(endDate);
            var dateDiff = edate - sdate;
            var days = (dateDiff / 1000 / 60 / 60 / 24) + 1;

            var totalRentalPerBillingCycle = totalAmountDisplay * days;

            console.log(days);
            console.log(totalAmountDisplay);
            console.log(totalRentalPerBillingCycle);

            $('#totalAmountDisplay').val(totalRentalPerBillingCycle);
        }

        $(document).on('change', '#time_period', function(e) {

            cycleType = $('#time_period').val();
            var startDate = $("#subscription_date").val();
            var endDate = $("#subscription_date_end").val();

            if (cycleType === 'Daily') {
                if (startDate.length == 0) {
                    $("#startDateErr").text("Please select start date");
                } else {
                    $("#startDateErr").text("");
                }
                if (endDate.length == 0) {
                    $("#endDateErr").text("Please select end date");
                } else {
                    $("#endDateErr").text("");
                }

                if (startDate != '' && endDate != '') {
                    dateDiffCalculation();
                }
            } else {

            }
            // console.log(cycleType);
        });


        $(document).on('change', '#subscription_date', function(e) {

            cycleType = $('#time_period').val();
            var startDate = $("#subscription_date").val();
            var endDate = $("#subscription_date_end").val();

            if (cycleType === 'Daily') {
                if (startDate.length == 0) {
                    $("#startDateErr").text("Please select start date");
                } else {
                    $("#startDateErr").text("");
                }
                if (endDate.length == 0) {
                    $("#endDateErr").text("Please select end date");
                } else {
                    $("#endDateErr").text("");
                }

                if (startDate != '' && endDate != '') {
                    dateDiffCalculation();
                }
            }
        });

        $(document).on('change', '#subscription_date_end', function(e) {

            cycleType = $('#time_period').val();
            var startDate = $("#subscription_date").val();
            var endDate = $("#subscription_date_end").val();

            if (cycleType === 'Daily') {
                if (startDate.length == 0) {
                    $("#startDateErr").text("Please select start date");
                } else {
                    $("#startDateErr").text("");
                }
                if (endDate.length == 0) {
                    $("#endDateErr").text("Please select end date");
                } else {
                    $("#endDateErr").text("");
                }

                if (startDate != '' && endDate != '') {
                    dateDiffCalculation();
                }
            }
        });
    </script>
@endsection
