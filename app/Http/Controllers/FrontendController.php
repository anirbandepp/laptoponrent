<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Agreement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSign(Request $request, Rental $rental)
    {
        $file_name = 'sign/agreement_' . time() . '.png';
        Storage::disk('public')->put($file_name, base64_decode(str_replace('data:image/png;base64,','',$request->sign)));
        return $rental->update(['agreement_sign' => $file_name]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RentalItem  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rental $id)
    {
        set_time_limit(300);
        $agreementNew = '';
        if (empty($id->agreement_doc) && empty($id->agreement_sign)) {
          $agreementNew = $this->agreementHtml($id, '<b> NOT YET SIGNED BY THE LESSOR!</b>');
        }else{
            if (empty($id->agreement_doc) ) {
                $agreementNew = $this->agreementHtml($id, '<img src="'.asset('storage/'.$id->agreement_sign).'" class="w-100" alt="">');
                $pdf = Pdf::loadHTML($this->htmlPDf($agreementNew));
                $pdf->setOptions(['isRemoteEnabled' => true]);
                $pdf->getDomPDF()->setProtocol($_SERVER['DOCUMENT_ROOT']);
                $file_name = 'agreements/'.time().'.pdf';
                Storage::disk('public')->put($file_name, $pdf->output());
                $id->update([
                    'agreement_doc' => $file_name
                ]);
            }
        }
        return view('customer.rental.show', ['rental' => $id, 'agreement' => $agreementNew]);
    }

    public function agreementHtml($rentalValue, $sign)
    {
        $agreement = Agreement::where('status', 1)->whereId(1)->first();
            $customerDetails = Customer::findorFail($rentalValue->customer_id);
            $address = "$customerDetails->address, $customerDetails->city, $customerDetails->state, $customerDetails->country, $customerDetails->postcode";
            $description = '';
            foreach ($rentalValue->rentals as $key => $item) {
                $description.= '<b>Product Name:</b> '.$item->name. ', Category: '.$item->category. ', Quantity: '.$item->quantity. ', Rent: ₹ '.$item->rent_quantity.' each<br>';
                $description.= "<b>Product Details:</b> ".$item->description.'<br>';
                $description.= "<b>Total Rent:</b> ₹".$item->amount.'/'. $rentalValue->time_period.'<br><br/>';
            }
            $enddate = empty($rentalValue->subscription_date_end) ? '<b> until cancelled</b>' : '<b>'. date('d M, Y', strtotime($rentalValue->subscription_date_end)).'</b>';
            $name = $customerDetails->rental_for == 'corporate' ? $customerDetails->companyname : $customerDetails->name;
            return $agreementNew = str_replace(["{{starting}}", "{{companyname}}", "{{address}}", "{{description}}", "{{signdate}}", "{{enddate}}", "{{name}}", "{{totalamount}}", "{{billingperiod}}", "{{startdate}}", "{{deposit}}"], [date('d M, Y', strtotime($rentalValue->subscription_date)), $customerDetails->companyname,$address, $description, $sign, $enddate, $name, $rentalValue->total_amount, $rentalValue->time_period,$rentalValue->subscription_date, $rentalValue->deposit_amount], $agreement->content);    
    }

    public function htmlPDf($body)
    {
        return '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>PDF</title>
        </head>
        <body>'
        . $body .
        '</body>
        </html>';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
