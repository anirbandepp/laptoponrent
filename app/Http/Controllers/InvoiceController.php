<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rental;
use App\Models\RentalItem;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class InvoiceController extends Controller
{

    public function getInvoice(Request $request)
    {
        if ($request->input('name')) {
            $customer = Customer::where('name', $request->input('name'))->first();
            if ($customer != '') {
                $filterClientData = Invoice::where('customer_id', $customer['id'])->orderBy('id', 'DESC')->get();
                $pending = DB::table('invoices')
                    ->where('customer_id', $customer['id'])
                    ->where('payment_status', 'Pending')
                    ->sum('payment');
                $paid = DB::table('invoices')
                    ->where('customer_id', $customer['id'])
                    ->where('payment_status', 'Paid')
                    ->sum('payment');
            } else {
                $filterClientData = [];
                $pending = Invoice::where(['payment_status' => 'Pending'])->sum('payment');
                $paid = DB::table('invoices')
                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                    ->where('payment_status', 'Paid')
                    ->sum('payment');
            }
        } else {
            $filterClientData = Invoice::orderBy('id', 'DESC')->get();
            $pending = Invoice::where(['payment_status' => 'Pending'])->sum('payment');
            $paid = DB::table('invoices')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->where('payment_status', 'Paid')
                ->sum('payment');
        }

        return view('admin.invoice.show', ['invoices' => $filterClientData, 'pending' => $pending, 'paid' => $paid]);
    }

    public function getFilterData(Request $request)
    {
        // dd($request->input());
        $filteredData = [];
        if ($request->input('filter_amount') == 'today') {
            $filteredData['pending'] = Invoice::whereDay('created_at', date('d'))->where('payment_status', 'Pending')->sum('payment');
            $filteredData['paid'] = Invoice::whereDay('created_at', date('d'))->where('payment_status', 'Paid')->sum('payment');
        }
        if ($request->input('filter_amount') == 'week') {
            $filteredData['pending'] = DB::table('invoices')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->where('payment_status', 'Pending')
                ->sum('payment');
            $filteredData['paid'] = DB::table('invoices')
                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                ->where('payment_status', 'Paid')
                ->sum('payment');
        }
        if ($request->input('filter_amount') == 'month') {
            $filteredData['pending'] = Invoice::whereMonth('created_at', date('m'))
                ->where('payment_status', 'Pending')
                ->sum('payment');
            $filteredData['paid'] = Invoice::whereMonth('created_at', date('m'))
                ->where('payment_status', 'Paid')
                ->sum('payment');
        }
        if ($request->input('filter_amount') == 'year') {
            $filteredData['pending'] = Invoice::whereYear('created_at', date('Y'))->where('payment_status', 'Pending')->sum('payment');
            $filteredData['paid'] = Invoice::whereYear('created_at', date('Y'))->where('payment_status', 'Paid')->sum('payment');
        }
        if ($request->input('startDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $filteredData['pending'] = DB::table('invoices')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'Pending')
                ->sum('payment');
            $filteredData['paid'] = DB::table('invoices')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'Paid')
                ->sum('payment');
        }
        $pending = Invoice::where(['payment_status' => 'Pending'])->sum('payment');
        // $paid = Invoice::where(['payment_status' => 'Paid'])->sum('payment');
        $paid = DB::table('invoices')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->where('payment_status', 'Paid')
            ->sum('payment');
        // dd($paid);
        if ($request->ajax()) {
            return response(['status' => true, 'filteredData' => $filteredData], 200);
        }
        return view('admin.invoice.show', ['invoices' => Invoice::orderBy('id', 'DESC')->get(), 'pending' => $pending, 'paid' => $paid]);
        // return view('admin.invoice.show', ['invoices' => Invoice::orderBy('id', 'DESC')->get(), 'pending' => $pending, 'paid' => $paid, 'filteredData' => $filteredData]);
    }

    // INVOICE PAGE
    public function invoicePayment(Request $request)
    {
        $invoices = Invoice::where('id', $request->input('invoiceId'))->first();

        $rental = Rental::where('id', $invoices['customer_id'])->first();
        $month = date('m', strtotime($rental['subscription_date']));
        $year = date('Y', strtotime($rental['subscription_date']));
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $date = "$days-$month-$year";

        $cencelUrlData = $this->cancelPaymentLink($invoices['payment_link_id']);

        $invoices->update([
            'payment_paid_date' => 'Via manual on ' . $request->input('payment_paid_date'),
            'payment_status' => 'Paid',
            'description' => $request->input('write_details') . '<br/>Rental for ' . $rental['subscription_date'] . ' to ' . $date . ' Rental ID ' . $invoices['rental_id'],
        ]);
        return redirect(route('invoices', $invoices->customer_id))->with('success', 'Payment Successfully Update');
    }

    public function voidInvoicePayment(Request $request)
    {
        $invoices = Invoice::where('id', $request->input('invoiceVoidId'))->first();
        $cencelUrlData = $this->cancelPaymentLink($invoices['payment_link_id']);
        $invoices->update([
            'payment_paid_date' => 'Cancelled on ' . date('d-m-Y'),
            'payment_status' => 'Cancelled',
        ]);
        return redirect(route('invoices', $invoices->customer_id))->with('success', 'Payment Successfully Update');
    }

    public function emailInvoicePaymentLink(Request $request)
    {
        $invoices = Invoice::where('id', $request->input('invoiceEmailId'))->first();
        $reference_id['reference_id'] = 'TS' . rand(11111, 99999) . $invoices['id'];
        $customer = Customer::where('id', $invoices['customer_id'])->first();
        $responseData = $this->getPaymentDetails(
            $invoices['payment'],
            $reference_id['reference_id'],
            $invoices['description'],
            $customer['name'],
            $customer['email'],
            $customer['mobile'],
        );
        $responseRentalData = json_decode($responseData);
        $invoices['payment_link'] = $responseRentalData->short_url;
        $invoices['payment_link_id'] = $responseRentalData->id;
        $invoices->update([
            'payment_status' => 'Pending',
            'payment_link' => $responseRentalData->short_url,
            'payment_link_id' => $responseRentalData->id,
            'reference_id' => $reference_id['reference_id'],
        ]);
        return redirect(route('invoices', $invoices->customer_id))->with('success', 'Payment link sent via Email');
    }


    // CLIENT PAGE
    public function emailPaymentLink(Request $request)
    {
        $invoices = Invoice::where('id', $request->input('invoiceEmailId'))->first();
        $reference_id['reference_id'] = 'TS' . rand(11111, 99999) . $invoices['id'];
        $customer = Customer::where('id', $invoices['customer_id'])->first();
        $responseData = $this->getPaymentDetails(
            $invoices['payment'],
            $reference_id['reference_id'],
            $invoices['description'],
            $customer['name'],
            $customer['email'],
            $customer['mobile'],
        );
        $responseRentalData = json_decode($responseData);
        $invoices['payment_link'] = $responseRentalData->short_url;
        $invoices['payment_link_id'] = $responseRentalData->id;
        $invoices->update([
            'payment_status' => 'Pending',
            'payment_link' => $responseRentalData->short_url,
            'payment_link_id' => $responseRentalData->id,
            'reference_id' => $reference_id['reference_id'],
        ]);
        return redirect(route('customer.show', $invoices->customer_id))->with('success', 'Payment link sent via Email');
    }

    public function submitPayment(Request $request)
    {
        $invoices = Invoice::where('id', $request->input('invoiceId'))->first();

        $rental = Rental::where('id', $invoices['customer_id'])->first();
        $month = date('m', strtotime($rental['subscription_date']));
        $year = date('Y', strtotime($rental['subscription_date']));
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $this->cancelPaymentLink($invoices['payment_link_id']);

        $invoices->update([
            'payment_paid_date' => 'Via manual on ' . $request->input('payment_paid_date'),
            'payment_status' => 'Paid',
            'description' => $request->input('write_details') . '<br/>Rental for ' . $rental['subscription_date'] . ' to ' . $days . '-' . $month . '-' . $year . ' Rental ID ' . $invoices['rental_id'],
        ]);

        return redirect(route('customer.show', $invoices->customer_id))->with('success', 'Payment Successfully Update');
    }

    public function voidPayment(Request $request)
    {
        $invoices = Invoice::where('id', $request->input('invoiceVoidId'))->first();
        $cencelUrlData = $this->cancelPaymentLink($invoices['payment_link_id']);
        $invoices->update([
            'payment_paid_date' => 'Cancelled on ' . date('d-m-Y'),
            'payment_status' => 'Cancelled',
        ]);
        return redirect(route('customer.show', $invoices->customer_id))->with('success', 'Invoice Cancelled');
    }

    // CREATE INVOICE
    public function createInvoice(Request $request)
    {
        $customer = Customer::where('id', $request->input('setCustomerId'))->first();

        $date = date('d-m-Y');
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $dayOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $till = "$dayOfMonth-$month-$year";

        $invoices['payment'] = $request->input('invoice_amount');
        $invoices['payment_status'] = 'Pending';
        $invoices['description'] = $request->input('invoice_details') . '<br/>Rental for ' . $date . ' to ' . $till;
        $invoices['reference_id'] = 'TS' . rand(11111, 99999) . $request->input('setCustomerId');
        $invoices['customer_id'] = $request->input('setCustomerId');

        $responseData = $this->getPaymentDetails(
            $invoices['payment'],
            $invoices['reference_id'],
            $invoices['description'],
            $customer['name'],
            $customer['email'],
            $customer['mobile'],
        );
        $responseRentalData = json_decode($responseData);
        $invoices['payment_link'] = $responseRentalData->short_url;
        $invoices['payment_link_id'] = $responseRentalData->id;

        Invoice::create($invoices);
        return redirect(route('customer.show', $customer['id']))->with('success', 'Invoice create successfully.');
    }


    // Cancel Payment Link on Razor Pay
    protected function cancelPaymentLink($urlid)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.razorpay.com/v1/payment_links/' . $urlid . '/cancel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                // 'Authorization: Basic cnpwX2xpdmVfTTB3cG4zejdHa1hOTjY6SVRJZGNZYWN1UENiMFdjNDdYTW1uTkxv',
                'Authorization: Basic cnpwX3Rlc3RfZjhKMG1zTVZjNGJVOUI6MDlOZEkzQ2NNZEZrcVI1cVh1Z2VlVXo0',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
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

    protected function getDetailsFromApi()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.razorpay.com/v1/payment_links/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                // 'Authorization: Basic cnpwX2xpdmVfTTB3cG4zejdHa1hOTjY6SVRJZGNZYWN1UENiMFdjNDdYTW1uTkxv',
                'Authorization: Basic cnpwX3Rlc3RfZjhKMG1zTVZjNGJVOUI6MDlOZEkzQ2NNZEZrcVI1cVh1Z2VlVXo0'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function paymentStatus(Request $request)
    {
        $getAmountPaidStatusJson = $this->getDetailsFromApi();
        $getAmountPaidStatus = json_decode($getAmountPaidStatusJson);
        $recievedAmount = $getAmountPaidStatus->payment_links['0']->amount_paid / 100;
        // dd($recievedAmount);
        $invoice = Invoice::where('payment_link_id', $request->razorpay_payment_link_id)->first();
        if ($invoice->payment_status != 'Paid') {
            if ($request->razorpay_payment_link_status == 'paid') {
                $invoice->update([
                    'payment_status' => 'Paid',
                    'payment_paid_date' => 'Via razorpay on ' . Carbon::now()->format('d-m-Y')
                ]);
                return view('paymentstatus', ['status' => true, 'message' => 'We have received the payment of ₹ ' . $recievedAmount]);
            }
            if ($request->razorpay_payment_link_status == 'partially_paid') {
                return view('paymentstatus', ['status' => true, 'message' => 'We have received the payment of ₹ ' . $recievedAmount]);
            }
        }
        return view('paymentstatus', ['status' => false, 'message' => 'To retry the payment, please click the payment link sent you via email.']);
    }

    public function generatePDF($invoiceID)
    {
        $obj = Invoice::where('id', $invoiceID)->where('payment_status', 'Paid')->first();
        // return $obj;

        $rental_id = $obj->rental_id;
        $customer_id = $obj->customer_id;
        $payment = $obj->payment;

        $invoiceObj = RentalItem::where('rental_id', $rental_id)->get()->toArray();

        $total = 0;

        foreach ($invoiceObj as $item) {
            $total += $item['quantity'] * $item['rent_quantity'];
        }

        $user = Customer::where('id', $customer_id)->get()->toArray();

        $date = Carbon::now()->format("m-d-Y");

        // return view('myPDF')->with(['data' => $invoiceObj, 'user' => $user, 'date' => $date, 'invoiceID' => $invoiceID, 'payment' => $payment, 'total' => $total]);

        try {
            $pdf = PDF::loadView('myPDF', ['data' => $invoiceObj, 'user' => $user, 'date' => $date, 'invoiceID' => $invoiceID, 'total' => $total])
                ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true])
                ->setPaper('a4', 'portrait');

            return $pdf->download('invoice.pdf');
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
}
