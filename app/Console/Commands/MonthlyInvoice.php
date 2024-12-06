<?php

namespace App\Console\Commands;

use App\Models\Rental;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Console\Command;

class MonthlyInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:monthly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to send monthly invoice';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('d-m-Y');
        $month = date('m', strtotime($date));
        $year = date('Y', strtotime($date));
        $dayOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $till = "$dayOfMonth-$month-$year";

        $rental = Rental::where('time_period', 'Monthly')->get();
        foreach ($rental as $key => $value) {
            $rentalAmont['rental_id'] = $value['unique_rental_id'];
            $rentalAmont['payment'] = $value['total_amount'];
            $rentalAmont['payment_status'] = $value['status'];
            $rentalAmont['description'] = 'Rental for '.$date.' to '.$till.' Rental ID '.$value['unique_rental_id'];
            $rentalAmont['customer_id'] = $value['customer_id'];
            $rentalAmont['reference_id'] = 'TS'.rand(11111,99999).$value['id'];

            $customer = Customer::where('id', $value['customer_id'])->first();

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
        }
        
    }

    // Send Payment Link on Razor Pay
    protected function getPaymentDetails($payment, $reference_id, $description, $name, $email, $mobile)
    {
        $payableAmount = round($payment*100);
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
            CURLOPT_POSTFIELDS =>'{
            "amount": '.$payableAmount.',
            "currency": "INR",
            "accept_partial": true,
            "first_min_partial_amount": 100,
            "expire_by": 1691097057,
            "reference_id": "'.$reference_id.'",
            "description": "'.$description.'",
            "customer": {
                "name": "'.$name.'",
                "contact": "'.$mobile.'",
                "email": "'.$email.'"
            },
            "notify": {
                "sms": true,
                "email": true
            },
            "reminder_enable": true,
            "notes": {
                "policy_name": "laptoponrent.biz"
            },
            "callback_url":  "'.$myUrl.'/payment-status",
            "callback_method": "get"
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic cnpwX2xpdmVfTTB3cG4zejdHa1hOTjY6SVRJZGNZYWN1UENiMFdjNDdYTW1uTkxv',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
