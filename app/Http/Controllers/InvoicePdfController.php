<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\RentalItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class InvoicePdfController extends Controller
{
    public function generatePDF($invoiceID)
    {
        $obj = Invoice::where('id', $invoiceID)->where('payment_status', 'Paid')->first();
        // dd($obj);
        $rental_id = $obj->rental_id;
        $customer_id = $obj->customer_id;

        $invoiceObj = RentalItem::where('rental_id', $rental_id)
            ->get()
            ->toArray();

        $user = Customer::where('id', $customer_id)->get()->toArray();

        $date = Carbon::now()->format("m-d-Y");

        // return view('myPDF')->with(['data' => $invoiceObj, 'user' => $user, 'date' => $date, 'invoiceID' => $invoiceID]);

        try {
            $pdf = PDF::loadView('myPDF', ['data' => $invoiceObj, 'user' => $user, 'date' => $date, 'invoiceID' => $invoiceID])
                ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);;

            return $pdf->download('invoice.pdf');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
