<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rental;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Document;
use App\Models\RentalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.customer.index', ['customer' => Customer::orderBy('created_at', 'desc')->paginate(50)]);
    }

    public function getUserList(Request $request)
    {
        $request->validate([
            'search' => 'required | min:2',
        ]);

        $data = $request->input('search');
        $data = DB::table('customers')
            ->where('customers.name', 'LIKE', '%' . $data . '%')
            ->orWhere('customers.companyname', 'LIKE', '%' . $data . '%')
            ->orWhere('customers.email', 'LIKE', '%' . $data . '%')
            ->orWhere('customers.mobile', 'LIKE', '%' . $data . '%')
            ->paginate(100);
        return view('admin.customer.index', ['customer' => $data]);
    }

    public function updateStatus(Request $request, $status, $id)
    {
        $data = DB::table('customers')
            ->where(['id' => $id])
            ->update(['status' => 'Active', 'email_verified' => 1, 'rand_id' => '']);
        return redirect()->back();
    }

    public function passwordReset()
    {
        return view('auth.passwords.edit');
    }
    public function passwordChagnes(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', "Password chagned!");
    }

    public function customerShow(Customer $customer)
    {
        $pending = Invoice::where(['customer_id' => $customer->id, 'payment_status' => 'Pending'])->sum('payment');
        $paid = Invoice::where(['customer_id' => $customer->id, 'payment_status' => 'Paid'])->sum('payment');
        return view('admin.customer.show', ['customer' => $customer, 'rentals' => Rental::where('customer_id', $customer->id)->get(), 'invoices' => Invoice::where('customer_id', $customer->id)->get(), 'pending' => $pending, 'paid' => $paid]);
    }

    public function verifyDocument(Request $request)
    {
        $document = Document::whereCustomerId($request->customer)->first();
        if ($request->document_name . '_flag' == 'adhar_card_flag') {
            $document->adhar_card_flag = '1';
        }
        if ($request->document_name . '_flag' == 'pan_card_flag') {
            $document->pan_card_flag = '1';
        }
        if ($request->document_name . '_flag' == 'electricity_bill_flag') {
            $document->electricity_bill_flag = '1';
        }
        if ($request->document_name . '_flag' == 'property_tax_bill_flag') {
            $document->property_tax_bill_flag = '1';
        }
        $document->update();
        return redirect()->back();
    }

    public function unverifyDocument(Request $request)
    {
        $document = Document::whereCustomerId($request->customer)->first();
        if ($request->document_name . '_flag' == 'adhar_card_flag') {
            $document->adhar_card_flag = '0';
        }
        if ($request->document_name . '_flag' == 'pan_card_flag') {
            $document->pan_card_flag = '0';
        }
        if ($request->document_name . '_flag' == 'electricity_bill_flag') {
            $document->electricity_bill_flag = '0';
        }
        if ($request->document_name . '_flag' == 'property_tax_bill_flag') {
            $document->property_tax_bill_flag = '0';
        }
        $document->update();
        return redirect()->back();
    }

    // getFile
    public function getFile($filename)
    {
        $path = url('storage/documents/' . $filename);
        dd($path);
        // $path = storage_path($filename);
        return response()->download($path);
    }
}
