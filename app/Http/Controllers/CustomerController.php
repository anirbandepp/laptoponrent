<?php

namespace App\Http\Controllers;

use Crypt;
use App\Models\Rental;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Document;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\EmailVerificationMail;
use App\Mail\SendForgetPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class CustomerController extends Controller
{
    // view login page
    public function login(Request $request)
    {
        if ($request->session()->has('ADMIN_LOGIN')) {
            return redirect('customer/dashboard');
        } else {
            return view('customer.login');
        }
        return view('customer.login');
    }


    // login 
    public function user_login(Request $request)
    {
        $request->validate([
            'email' => 'required ',
            'password' => 'required'
        ]);
        $email = $request->post('email');
        $password = $request->post('password');

        $result = Customer::where(['email' => $email])->first();
        if ($result) {
            $request->session()->put('ADMIN_LOGIN', true);
            $request->session()->put('ADMIN_EMAIL', $result->id);
            $request->session()->put('ADMIN_NAME', $result->name);
            return redirect('customer/dashboard');
        } else {
            $request->session()->flash('error', 'Please enter valid Email or verify your email');
            return redirect('/');
        }
    }


    // Send email for forget password view
    public function forget_password_page()
    {
        return view('customer.forget_password_page');
    }


    public function sendforgetpasswordmail(Request $request)
    {
        $request->validate([
            'email' => 'required',
        ]);

        $result = Customer::where(['email' => $request->email])->first();
        if ($result != '') {
            $data = ['name' => $result->name, 'email' => $result->email, 'rand_id' => rand(111111111, 999999999)];
            $result->password = Hash::make($data['rand_id']);
            $result->update();
            Mail::to($data['email'])->send(new SendForgetPasswordMail($data));
            return view('emails.sendforgetpasswordmails');
        } else {
            $request->session()->flash('error', 'Email not found!');
            return redirect()->back();
        }
    }
    // Forget password process



    // registration page view
    public function registration(Request $request)
    {
        if ($request->session()->has('ADMIN_LOGIN')) {
            return view('customer/dashboard');
        }
        return view('customer.register');
    }

    // Store regsitration data in session
    public function store_data(Request $request)
    {
        $request->validate([
            'name' => 'required | string',
            'rental_for' => 'required',
            'companyname' => 'nullable | string',
            'mobile' => 'required | unique:customers,mobile',
            'email' => 'required | email | string | max:255 | unique:customers,email',
            'password' => 'required| min:6|max:25 | confirmed ',
            'address' => 'required | string | max:255',
            'city' => 'required | string | max:255',
            'postcode' => 'required | max:6',
            'state' => 'required',
            'country' => 'required',
            'aadhar' => 'nullable | min:14',
        ]);
        // dd($request->input());
        $rand_id = rand(111111111, 999999999);

        $result['name'] = $request->input('name');
        $result['rental_for'] = $request->input('rental_for');
        $result['companyname'] = $request->input('companyname');
        $result['mobile'] = $request->input('mobile');
        $result['email'] = $request->input('email');
        $result['status'] = "Inactive";
        $result['email_verified'] = "0";
        $result['rand_id'] = "$rand_id";
        $result['password'] = Hash::make($request->input('password'));
        $result['password_confirmation'] = $request->input('password_confirmation');
        $result['address'] = $request->input('address');
        $result['city'] = $request->input('city');
        $result['postcode'] = $request->input('postcode');
        $result['state'] = $request->input('state');
        $result['country'] = $request->input('country');

        $data = Customer::create($result);

        $data = ['name' => $data['name'], 'rand_id' => $result['rand_id']];
        Mail::to($result['email'])->send(new EmailVerificationMail($data));
        $request->session()->flash('msg', 'A verification email is sent to your email address. Please click an activation link in the email to login.');
        return redirect('/register_thank_you');

        // $request->session()->put('name', $request->input('name'));
        // if ($request->input('companyname') != '') {
        //     $request->session()->put('companyname', $request->input('companyname'));
        // }else{
        //     $request->session()->put('companyname', '');
        // }

        // $request->session()->put('mobile', $request->input('mobile'));
        // $request->session()->put('email', $request->input('email'));
        // $request->session()->put('password', $request->input('password'));
        // $request->session()->put('password_confirmation', $request->input('password_confirmation'));
        // $request->session()->put('address', $request->input('address'));
        // $request->session()->put('city', $request->input('city'));
        // $request->session()->put('postcode', $request->input('postcode'));
        // $request->session()->put('state', $request->input('state'));
        // $request->session()->put('country', $request->input('country'));
        // return view('customer.verify');
    }

    // Aadhar verification page view
    public function verification(Request $request)
    {
        // if (Session::has('name')) {
        //     return view('customer.verify');
        // }else{
        //     return view('customer.register');
        // }
        // return view('customer.register');
        // return view('customer.verify');
    }

    // Send mail for customer and Store data in database
    public function verify_adhar(Request $request)
    {
        $request->validate([
            'aadhar' => 'nullable | min:14',
        ]);

        $rand_id = rand(111111111, 999999999);

        $result['name'] = $request->input('name');
        $result['companyname'] = $request->input('companyname');
        $result['mobile'] = $request->input('mobile');
        $result['email'] = $request->input('email');
        $result['email_verified'] = "0";
        $result['rand_id'] = "$rand_id";
        $result['password'] = Hash::make($request->input('password'));
        $result['password_confirmation'] = $request->input('password_confirmation');
        $result['address'] = $request->input('address');
        $result['city'] = $request->input('city');
        $result['postcode'] = $request->input('postcode');
        $result['state'] = $request->input('state');
        $result['country'] = $request->input('country');
        $result['adhar'] = $request->aadhar;

        $data = Customer::create($result);
        dd(($data));
        $data = ['name' => $request->input('ADMIN_NAME'), 'rand_id' => $result['rand_id']];
        Mail::to($result['email'])->send(new EmailVerificationMail($data));

        $request->session()->forget('name', $request->input('name'));
        $request->session()->forget('companyname', $request->input('companyname'));
        $request->session()->forget('mobile', $request->input('mobile'));
        $request->session()->forget('email', $request->input('email'));
        $request->session()->forget('password', $request->input('password'));
        $request->session()->forget('password_confirmation', $request->input('password_confirmation'));
        $request->session()->forget('address', $request->input('address'));
        $request->session()->forget('city', $request->input('city'));
        $request->session()->forget('postcode', $request->input('postcode'));
        $request->session()->forget('state', $request->input('state'));
        $request->session()->forget('country', $request->input('country'));
        return response(['status' => true], 200);
    }

    // Email verification 
    public function email_varification(Request $request, $id)
    {
        $result = DB::table('customers')
            ->where(['rand_id' => $id])
            ->where(['email_verified' => 0])
            ->get();
        if (isset($result[0])) {
            DB::table('customers')
                ->where(['id' => $result[0]->id])
                ->update(['status' => 'Active', 'email_verified' => 1, 'rand_id' => '']);
            $request->session()->put('ADMIN_LOGIN', true);
            $request->session()->put('ADMIN_EMAIL', $result[0]->id);
            $request->session()->put('ADMIN_NAME', $result[0]->name);
            return view('emails.verification');
        } else {
            return redirect('customer/dashboard');
        }
    }

    // thank you page after registration
    public function thank_you()
    {
        return view('customer.register_thank_you');
    }

    // Show user dashboard
    public function user_dashboard(Request $request)
    {
        // $result = Document::where('customer_id',$request->session()->get('ADMIN_EMAIL'))->first();
        // if(isset($result)){
        //     if ($result['customer_id'] != '' && $result['adhar_card'] != '') {
        //         return view('customer.dashboard');
        //     }else{
        //         return view('customer.show_documents');
        //     }
        // }else{
        //     return view('customer.show_documents');
        // }

        return view('customer.dashboard', ['rental' => Rental::where('customer_id', $request->session()->get('ADMIN_EMAIL'))->get()]);
    }



    // Show user profile
    public function user_profile(Request $request, Customer $customer, $id)
    {
        $result['data'] = Customer::where('id', $id)->first();
        $result['getDataInvoices'] = Invoice::where(['customer_id' => $request->session()->get('ADMIN_EMAIL')])->get();
        return view('customer.profile', compact('result'));
    }

    // show reset password page
    public function reset_password(Request $request, Customer $customer, $id)
    {
        $result = Customer::where('id', $id)->first();
        return view('customer.reset_password', compact('result'));
    }

    // Reset user password
    public function reset_password_process(Request $request)
    {
        $request->validate([
            'password' => 'required| min:6|max:25 | confirmed ',
        ]);
        $result = Customer::where('id', $request->session()->get('ADMIN_EMAIL'))->first();
        $result->password = Hash::make($request->password);
        $result->update();
        $request->session()->flash('msg', 'Password has been changed');
        return redirect()->back();
    }

    // Show upload document page
    public function documents(Request $request)
    {
        if (Session::has('name')) {
            return view('customer.documents');
        } else {
            return view('customer.register');
        }
        return view('customer.register');
    }

    // upload documents
    public function upload_documents(Request $request)
    {
        $request->validate([
            'adhar_card' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'pan_card' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'electricity_bill' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'property_tax_bill' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'gst_certificate' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'corporate_pan_card' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'office_rental_agreement' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'incorporation_certificate' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
        ]);
        if ($request->hasfile('adhar_card')) {
            $adhar_card = $request->file('adhar_card');
            $ext = $adhar_card->extension();
            $adhar_card_name = time() . '1' . "." . $ext;
            $adhar_card->storeAs('/public/documents/', $adhar_card_name);
            $data['adhar_card'] = $adhar_card_name;
        }
        if ($request->hasfile('gst_certificate')) {
            $gst_certificate = $request->file('gst_certificate');
            $ext = $gst_certificate->extension();
            $gst_certificate_name = time() . '9' . "." . $ext;
            $gst_certificate->storeAs('/public/documents/', $gst_certificate_name);
            $data['gst_certificate'] = $gst_certificate_name;
        }
        $data['customer_id'] = $request->session()->get('ADMIN_EMAIL');
        Document::create($data);
        return redirect()->back();
    }

    // Show all documents
    public function show_documents(Request $request, $id)
    {
        $result = Document::where('customer_id', $id)->first();
        return view('customer.show_documents', compact('result'));
    }

    public function update_documents(Request $request)
    {
        $request->validate([
            'adhar_card' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'pan_card' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'electricity_bill' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'property_tax_bill' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'gst_certificate' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'corporate_pan_card' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'office_rental_agreement' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
            'incorporation_certificate' => 'nullable | mimes:pdf,doc,docx,jpg,jpeg | max:5120',
        ]);

        if ($request->hasfile('adhar_card')) {
            $adhar_card = $request->file('adhar_card');
            $ext = $adhar_card->extension();
            $adhar_card_name = time() . '1' . "." . $ext;
            $adhar_card->storeAs('/public/documents/', $adhar_card_name);
            $data['adhar_card'] = $adhar_card_name;
        }
        if ($request->hasfile('pan_card')) {
            $pan_card = $request->file('pan_card');
            $ext = $pan_card->extension();
            $pan_card_name = time() . '2' . "." . $ext;
            $pan_card->storeAs('/public/documents/', $pan_card_name);
            $data['pan_card'] = $pan_card_name;
        }
        if ($request->hasfile('electricity_bill')) {
            $electricity_bill = $request->file('electricity_bill');
            $ext = $electricity_bill->extension();
            $electricity_bill_name = time() . '3' . "." . $ext;
            $electricity_bill->storeAs('/public/documents/', $electricity_bill_name);
            $data['electricity_bill'] = $electricity_bill_name;
        }
        if ($request->hasfile('property_tax_bill')) {
            $property_tax_bill = $request->file('property_tax_bill');
            $ext = $property_tax_bill->extension();
            $property_tax_bill_name = time() . '4' . "." . $ext;
            $property_tax_bill->storeAs('/public/documents/', $property_tax_bill_name);
            $data['property_tax_bill'] = $property_tax_bill_name;
        }
        if ($request->hasfile('gst_certificate')) {
            $gst_certificate = $request->file('gst_certificate');
            $ext = $gst_certificate->extension();
            $gst_certificate_name = time() . '5' . "." . $ext;
            $gst_certificate->storeAs('/public/documents/', $gst_certificate_name);
            $data['gst_certificate'] = $gst_certificate_name;
        }
        if ($request->hasfile('corporate_pan_card')) {
            $corporate_pan_card = $request->file('corporate_pan_card');
            $ext = $corporate_pan_card->extension();
            $corporate_pan_card_name = time() . '6' . "." . $ext;
            $corporate_pan_card->storeAs('/public/documents/', $corporate_pan_card_name);
            $data['corporate_pan_card'] = $corporate_pan_card_name;
        }
        if ($request->hasfile('office_rental_agreement')) {
            $office_rental_agreement = $request->file('office_rental_agreement');
            $ext = $office_rental_agreement->extension();
            $office_rental_agreement_name = time() . '7' . "." . $ext;
            $office_rental_agreement->storeAs('/public/documents/', $office_rental_agreement_name);
            $data['office_rental_agreement'] = $office_rental_agreement_name;
        }
        if ($request->hasfile('incorporation_certificate')) {
            $incorporation_certificate = $request->file('incorporation_certificate');
            $ext = $incorporation_certificate->extension();
            $incorporation_certificate_name = time() . '8' . "." . $ext;
            $incorporation_certificate->storeAs('/public/documents/', $incorporation_certificate_name);
            $data['incorporation_certificate'] = $incorporation_certificate_name;
        }
        $data['customer_id'] = $request->session()->get('ADMIN_EMAIL');
        $checkData = Document::where('customer_id', $request->session()->get('ADMIN_EMAIL'))->first();
        if ($checkData != '') {
            Document::where('customer_id', $request->session()->get('ADMIN_EMAIL'))->update($data);
        } else {
            Document::create($data);
        }
        $request->session()->flash('msg', 'Document uploaded successfully.');
        return redirect()->back();
    }
}
