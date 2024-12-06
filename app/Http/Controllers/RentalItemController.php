<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Agreement;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use App\Models\DepositAmount;

class RentalItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, RentalItem $rentalItem)
    {
        return view(
            'admin.rental.create',
            ['customerDetails' => Customer::findorFail($request->customer), 'rentalItem' => $rentalItem]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;

        $data = $request->validate([
            'subscription_date' => 'required',
            'subscription_date_end' => 'nullable',
            'unique_rental_id' => 'nullable',
            'time_period' => 'required',
            'customer_id' => 'required',
            'category.*' => 'required',
            'quantity.*' => 'required | numeric | between:1,99999',
            'rent_quantity.*' => 'required | numeric | between:1,99999999999',
            'amount.*' => 'required',
            'description.*' => 'required',
            'name.*' => 'required',
            'deposit_amount' => 'required | numeric | between:1,99999999999',
        ]);

        $newRequest = [];
        $total_amount = 0;
        $total_chq = count($request->name);
        for ($i = 0; $i < $total_chq; $i++) {

            if ($request->category) {
                $newRequest[$i]['category'] = $request->category[$i];
            }
            if ($request->quantity) {
                $newRequest[$i]['quantity'] = $request->quantity[$i];
            }
            if ($request->rent_quantity) {
                $newRequest[$i]['rent_quantity'] = $request->rent_quantity[$i];
                $newRequest[$i]['amount'] = $request->quantity[$i] * $request->rent_quantity[$i];
                $total_amount = $total_amount + ($request->quantity[$i] * $request->rent_quantity[$i]);
            }
            if ($request->description) {
                $newRequest[$i]['description'] = $request->description[$i];
            }
            if ($request->name) {
                $newRequest[$i]['name'] = $request->name[$i];
            }
        }

        $unique_rental_id = '10' . rand('1111111', '9999999') . $data['customer_id'];
        $data['total_amount'] = $total_amount;
        $data['status'] = 'Pending';
        $data['unique_rental_id'] = $unique_rental_id;

        $rental = Rental::create($data);

        foreach ($newRequest as $value) {
            $value['rental_id'] = $rental->id;
            $value['customer_id'] = $request->customer_id;
            $obj = RentalItem::create($value);
            dd($obj);
        }

        $deposit['rental_id'] = $rental['id'];
        $deposit['payment'] = $rental['deposit_amount'];
        $deposit['payment_status'] = $rental['status'];
        $deposit['description'] = 'Deposit for Rental ID ' . $rental['id'];
        $deposit['customer_id'] = $rental['customer_id'];
        $deposit['reference_id'] = 'TS' . rand(11111, 99999) . $rental['id'];

        $customer = Customer::where('id', $value['customer_id'])->first();

        $responseDepositData = $this->getPaymentDetails(
            $deposit['payment'],
            $deposit['reference_id'],
            $deposit['description'],
            $customer['name'],
            $customer['email'],
            $customer['mobile'],
        );
        $responseGetData = json_decode($responseDepositData);
        $deposit['payment_link'] = $responseGetData->short_url;
        $deposit['payment_link_id'] = $responseGetData->id;

        Invoice::create($deposit);

        if ($data['time_period'] == 'Daily') {
            $day = date('d', strtotime($request->subscription_date));
            $month = date('m', strtotime($request->subscription_date));
            $year = date('Y', strtotime($request->subscription_date));
            $dayOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $countStartDays = $dayOfMonth - $day;

            $currDay = date('d', strtotime($data['subscription_date_end']));
            $endMonth = date('m', strtotime($data['subscription_date_end']));
            $endYear = date('Y', strtotime($data['subscription_date_end']));
            $endDayOfMonth = cal_days_in_month(CAL_GREGORIAN, $endMonth, $endYear);
            $totalDays = $countStartDays + $currDay;
            $rentalAmont['payment'] = $data['total_amount'] * $totalDays;
            $date = "$currDay-$endMonth-$endYear";
        } else {
            $day = date('d', strtotime($request->subscription_date));
            $month = date('m', strtotime($request->subscription_date));
            $year = date('Y', strtotime($request->subscription_date));
            $dayOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $countDays = $dayOfMonth - $day;
            $payForDay =  $data['total_amount'] / $dayOfMonth;
            $rentalAmont['payment'] = $payForDay * $countDays;

            $date = "$dayOfMonth-$month-$year";
        }

        $rentalAmont['rental_id'] = $rental['id'];
        // $rentalAmont['payment'] = $proRate;
        $rentalAmont['payment_status'] = $rental['status'];
        $rentalAmont['description'] = 'Rental for ' . date('d-m-Y', strtotime($request->subscription_date)) . ' to ' . $date . ' Rental ID ' . $rental['id'];
        $rentalAmont['customer_id'] = $rental['customer_id'];
        $rentalAmont['reference_id'] = 'TS' . rand(11111, 99999) . $rental['id'];

        $responseData = $this->getPaymentDetails(
            $rentalAmont['payment'],
            $rentalAmont['reference_id'],
            $rentalAmont['description'],
            $customer['name'],
            $customer['email'],
            $customer['mobile'],
        );
        $responseRentalData = json_decode($responseData);
        $rentalAmont['payment_link'] = $responseRentalData->short_url;
        $rentalAmont['payment_link_id'] = $responseRentalData->id;

        Invoice::create($rentalAmont);

        return redirect(route('customer.show', $request->customer_id))->with('success', 'Rental Item Successfully Insert');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RentalItem  $rental
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $rental)
    {
        $agreement = Agreement::where('status', 1)->whereId(1)->first();
        $customerDetails = Customer::findorFail($rental->customer_id);
        $address = "$customerDetails->address, $customerDetails->city, $customerDetails->state, $customerDetails->country, $customerDetails->postcode";
        $description = '';
        foreach ($rental->rentals as $item) {
            $description .= '<b>Product Name:</b> ' . $item->name . ', Category: ' . $item->category . ', Quantity: ' . $item->quantity . ', Rent: ₹ ' . $item->rent_quantity . ' each<br>';
            $description .= "<b>Product Details:</b> " . $item->description . '<br>';
            $description .= "<b>Total Rent:</b> ₹" . $item->amount . '/' . $rental->time_period . '<br><br/>';
        }
        $sign = '<b> Lessor still not sign this agreement</b>';
        $enddate = empty($rental->subscription_date_end) ? '<b> until cancelled</b>' : $rental->subscription_date_end;
        $name = $customerDetails->rental_for == 'corporate' ? $customerDetails->companyname : $customerDetails->name;
        $agreementNew = str_replace(["{{starting}}", "{{companyname}}", "{{address}}", "{{description}}", "{{signdate}}", "{{enddate}}", "{{name}}", "{{totalamount}}", "{{billingperiod}}", "{{startdate}}", "{{deposit}}"], [date('d M, Y', strtotime($rental->subscription_date)), $customerDetails->companyname, $address, $description, $sign, $enddate, $name, $rental->total_amount, $rental->time_period, $rental->subscription_date, $rental->deposit_amount], $agreement->content);
        return view('admin.rental.show', [
            'rental' => $rental,
            'agreement' => $agreementNew,
            'customerDetails' => $customerDetails
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RentalItem  $rentalItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Rental $rental)
    {
        return view('admin.rental.edit', ['customerDetails' => Customer::findorFail($rental->customer_id), 'rentalItem' => $rental]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RentalItem  $rentalItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rental $rental)
    {
        $newRequest = [];
        $total_amount = 0;
        $total_chq = count($request->name);
        for ($i = 0; $i < $total_chq; $i++) {
            if ($request->category) {
                $newRequest[$i]['category'] = $request->category[$i];
            }
            if ($request->quantity) {
                $newRequest[$i]['quantity'] = $request->quantity[$i];
            }
            if ($request->rent_quantity) {
                $newRequest[$i]['rent_quantity'] = $request->rent_quantity[$i];
                $newRequest[$i]['amount'] = $request->quantity[$i] * $request->rent_quantity[$i];
                $total_amount = $total_amount + ($request->quantity[$i] * $request->rent_quantity[$i]);
            }
            if ($request->description) {
                $newRequest[$i]['description'] = $request->description[$i];
            }
            if ($request->name) {
                $newRequest[$i]['name'] = $request->name[$i];
            }
            if ($request->productIds) {
                $newRequest[$i]['id'] = $request->productIds[$i];
            }
        }
        $data = $request->validate([
            'subscription_date' => 'required',
            'subscription_date_end' => 'nullable',
            'time_period' => 'required',
            'customer_id' => 'required',
            'category.*' => 'required',
            'quantity.*' => 'required',
            'rent_quantity.*' => 'required',
            'amount.*' => 'required',
            'description.*' => 'required',
            'name.*' => 'required',
            'deposit_amount' => 'nullable',
        ]);
        $data['total_amount'] = $total_amount;
        $data['deposit_amount'] = $data['deposit_amount'];
        $rental->update($data);
        foreach ($newRequest as $key => $value) {
            $rentalitem = RentalItem::where('id', $value['id'])->first();
            $rentalitem->update([
                'category' => $value['category'],
                'quantity' => $value['quantity'],
                'rent_quantity' => $value['rent_quantity'],
                'amount' => $value['amount'],
                'description' => $value['description'],
                'name' => $value['name'],
            ]);
        }
        return redirect(route('customer.show', $rental->customer_id))->with('success', 'Rental Item Successfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RentalItem  $rentalItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $rental)
    {
        $rental->delete();
        return redirect(route(route('customer.show', $rental->customer_id)))->with('success', 'Rental Item Successfully Detele');
    }

    protected function validateRequest($request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'category' => 'required',
            'quantity' => 'required',
            'rent_quantity' => 'required',
            'customer_id' => 'required',
        ]);
    }

    // Send Payment Link on Razor Pay
    protected function getPaymentDetails($payment, $reference_id, $description, $name, $email, $mobile)
    {
        $payableAmount = round($payment * 100);
        $myUrl = url('/');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.razorpay.com/v1/payment_links/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "amount": ' . $payableAmount . ',
            "currency": "INR",
            "accept_partial": true,
            "first_min_partial_amount": 100,
            "expire_by": 1691097057,
            "reference_id": "' . $reference_id . '",
            "description": "' . $description . '",
            "customer": {
                "name": "' . $name . '",
                "contact": "' . $mobile . '",
                "email": "' . $email . '"
            },
            "notify": {
                "sms": true,
                "email": true
            },
            "reminder_enable": true,
            "notes": {
                "policy_name": "laptoponrent.biz"
            },
            "callback_url": "' . $myUrl . '/payment-status",
            "callback_method": "get"
            }',
            CURLOPT_HTTPHEADER => array(
                // 'Authorization: Basic cnpwX2xpdmVfTTB3cG4zejdHa1hOTjY6SVRJZGNZYWN1UENiMFdjNDdYTW1uTkxv',
                'Authorization: Basic cnpwX3Rlc3RfZjhKMG1zTVZjNGJVOUI6MDlOZEkzQ2NNZEZrcVI1cVh1Z2VlVXo0',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
