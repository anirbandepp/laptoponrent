<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }

    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .rtl table {
        text-align: right;
    }

    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
</style>

<div>

    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="7">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://laptoponrent.biz/rental/assets/img/logo.png" alt="Company logo"
                                    style="width: 100%; max-width: 200px" />
                            </td>
                            <td>
                                <h1 style="font-size:54px;">Invoice</h1>
                                <b>Invoice Number:</b> {{ $invoiceID }} <br>
                                <b>Date:</b> {{ $date }}<br>
                                @if ($user[0]['rental_for'] == 'corporate')
                                    <b>Company Name:</b> {{ $user[0]['companyname'] }}<br>
                                @else
                                    <b>Client Name:</b> {{ $user[0]['name'] }}<br>
                                    <b>Company Name:</b> {{ $user[0]['companyname'] }}<br>
                                @endif

                                <b>Address:</b> {{ $user[0]['address'] }},{{ $user[0]['postcode'] }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td style="text-align:center;">
                    No.
                </td>
                <td style="text-align:center;">
                    Product Name
                </td>
                <td style="text-align:center;">
                    Category
                </td>
                <td style="text-align:center; width: 20%;">
                    Description
                </td>
                <td style="text-align:center;">
                    Quantity
                </td>
                <td style="text-align:center;">
                    Unit Price
                </td>
                <td style="text-align:center;">
                    Total Amount
                </td>
            </tr>

            @foreach ($data as $item)
                <tr class="item" style="width:50%; text-align:center;">
                    <td>{{ $loop->index + 1 }}</td>
                    <td class="border" style="text-align:center;"> {{ $item['name'] }}</td>
                    <td class="border" style="text-align:center;"> {{ $item['category'] }}</td>
                    <td class="border" style="text-align:center;"> {{ $item['description'] }}</td>
                    <td class="border" style="text-align:center;"> {{ $item['quantity'] }}</td>
                    <td class="border" style="text-align:center;"><span
                            style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $item['rent_quantity'] }}
                    </td>
                    <td class="border" style="text-align:center;"><span
                            style="font-family: DejaVu Sans; sans-serif;">&#8377;</span> {{ $item['amount'] }}
                    </td>
                </tr>
            @endforeach

        </table>
        <table cellpadding="2" cellspacing="2">
            <td colspan="5">
                <table>
                    <tr class="total">
                        <td class="title">
                        </td>
                        <td>Total Amount:</td>
                        <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $total }}</td>
                    </tr>
                </table>
            </td>
        </table>
        <hr>
        <table class="footer">
            <tr>
                <td style="text-align:center;">RegreenCycle</td>
            </tr>
            <tr>
                <td style="text-align:center;">Street Address City, ST ZIP Code</td>
            </tr>
        </table>
    </div>
</div>
