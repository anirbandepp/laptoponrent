<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CustomerController::class, 'login'])->name('customer.login');
Route::post('/user_login', [CustomerController::class, 'user_login'])->name('customer.user_login');
Route::get('/forget_password_page', [CustomerController::class, 'forget_password_page'])->name('customer.forget_password_page');
Route::post('/sendforgetpasswordmail', [CustomerController::class, 'sendforgetpasswordmail'])->name('customer.sendforgetpasswordmail');
Route::get('/sendforgetpasswordmail', [CustomerController::class, 'sendforgetpasswordmails']);

Route::get('/registration', [CustomerController::class, 'registration'])->name('customer.registration');
Route::post('/registration', [CustomerController::class, 'store_data'])->name('customer.registration');
Route::get('/verify', [CustomerController::class, 'verification'])->name('customer.verification');
Route::post('/verify', [CustomerController::class, 'verify_adhar'])->name('customer.verification');
Route::get('/verification/{id}', [CustomerController::class, 'email_varification']);
Route::get('/register_thank_you', [CustomerController::class, 'thank_you']);


Route::group(['middleware' => 'customer_auth'], function () {
    Route::get('/customer/documents', [CustomerController::class, 'documents'])->name('customer.documents');
    Route::post('/customer/upload_documents', [CustomerController::class, 'upload_documents'])
        ->name('customer.upload_documents');
    Route::get('/customer/show_documents/{id}', [CustomerController::class, 'show_documents'])->name('customer.show_documents');
    Route::get('/customer/update_documents/{id}', [CustomerController::class, 'update_documents'])->name('customer.update_documents');

    Route::post('/customer/upload_documents/{id}', [CustomerController::class, 'update_documents']);

    Route::post('/customer/update_documents', [CustomerController::class, 'update_documents'])
        ->name('customer.update_documents');

    Route::get('/customer/dashboard', [CustomerController::class, 'user_dashboard'])->name('customer.dashboard');
    Route::get('/customer/profile/{id}', [CustomerController::class, 'user_profile'])->name('customer.profile');
    Route::get('/customer/reset_password/{id}', [CustomerController::class, 'reset_password'])->name('customer.reset_password');
    Route::post('/customer/reset_password_process', [CustomerController::class, 'reset_password_process'])
        ->name('customer.reset_password_process');

    Route::get('/customer/rental/{id}', [FrontendController::class, 'show'])->name('customer.rental.show');
    Route::post('/customer/signature/{rental}', [FrontendController::class, 'storeSign'])->name('customer.sign');

    Route::get('/customer/logout', function () {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_EMAIL');
        session()->forget('ADMIN_NAME');
        session()->flash('error', 'You are logged Out');
        return redirect('/');
    });
});
// Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Auth::routes();
    // Auth::routes(['register'=>true]);
    Route::get('users', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('users', [App\Http\Controllers\HomeController::class, 'getUserList'])->name('user.list');
    Route::get('customer/status/{status}/{id}', [App\Http\Controllers\HomeController::class, 'updateStatus']);
    Route::get('password/edit', [App\Http\Controllers\HomeController::class, 'passwordReset'])->name('password.edit');
    Route::post('password/udpate', [App\Http\Controllers\HomeController::class, 'passwordChagnes'])->name('password.changes');
    Route::resource('rental', App\Http\Controllers\RentalItemController::class);

    Route::get('get/{filename}', [App\Http\Controllers\HomeController::class, 'getFile'])->name('getfile');

    Route::get('customer/verify', [App\Http\Controllers\HomeController::class, 'verifyDocument'])->name('document.verify');
    Route::get('customer/unverify', [App\Http\Controllers\HomeController::class, 'unverifyDocument'])->name('document.unverify');
    Route::get('customer/{customer}', [App\Http\Controllers\HomeController::class, 'customerShow'])->name('customer.show');
    Route::resource('agreement', App\Http\Controllers\AgreementController::class);

    Route::post('invoice/create', [InvoiceController::class, 'createInvoice'])->name('invoice.create');

    Route::get('client-invoice', [InvoiceController::class, 'getInvoice'])->name('invoices');
    Route::post('client-invoice', [InvoiceController::class, 'getInvoice'])->name('invoices.nameFilter');
    Route::get('invoice/filter', [InvoiceController::class, 'getFilterData'])->name('invoice.filter');
    Route::post('invoice/filter', [InvoiceController::class, 'getFilterData'])->name('invoice.filter');
    Route::post('payment/pay', [InvoiceController::class, 'submitPayment'])->name('payment.pay');
    Route::post('payment/void', [InvoiceController::class, 'voidPayment'])->name('payment.void');
    Route::post('payment/emailLink', [InvoiceController::class, 'emailPaymentLink'])->name('payment.emailLink');
    Route::post('invoice/pay', [InvoiceController::class, 'invoicePayment'])->name('invoice.pay');
    Route::post('invoice/void', [InvoiceController::class, 'voidInvoicePayment'])->name('invoice.void');
    Route::post('invoice/emailLink', [InvoiceController::class, 'emailInvoicePaymentLink'])->name('invoice.emailLink');

    Route::get('invoice_generate_pdf/{invoiceID}', [InvoiceController::class, 'generatePDF'])->name('invoice.generatePDF');
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/payment-status', [InvoiceController::class, 'paymentStatus']);
// Route::get('/checkSchedulers', [InvoiceController::class, 'checkScheduler']);
