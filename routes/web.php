<?php

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



//Auth::routes();
Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/edit_profile', 'HomeController@edit_profile')->name('edit_profile');

Route::POST('/update_profile/{id}', 'HomeController@update_profile')->name('update_profile');
Route::get('/password_change/', 'HomeController@update_password')->name('update_password');

Route::resource('role', 'RoleController');
Route::resource('category', 'CategoryController');
Route::resource('tax', 'TaxController');
Route::resource('unit', 'UnitController');
Route::resource('supplier', 'SupplierController');
Route::resource('customer', 'CustomerController');
Route::resource('product', 'ProductController');
Route::resource('service', 'ServiceController');
Route::resource('invoice', 'InvoiceController');
Route::put('invoice/update/{id}', 'InvoiceController@approve')->name("approve");
Route::get('invoice/process/{id}', 'InvoiceController@process')->name("process");
Route::resource('receipt', 'ReceiptController');
Route::resource('purchase', 'PurchaseController');
Route::get('/findPrice', 'InvoiceController@findPrice')->name('findPrice');
Route::get('/findInvoice', 'ReceiptController@findInvoice')->name('findInvoice');
Route::get('/invoices', 'InvoiceController@invoices')->name('invoices');
Route::get('/paymentGraph', 'ReceiptController@paymentGraph')->name('payment');
Route::get('/paymentPie', 'ReceiptController@paymentPie')->name('payment');
Route::resource('user', 'UsersController');
Route::resource('transaction', 'TransactionController');

Route::get('/reports/daily-sales','ReportsController@daily_sales')->name('daily_sales');

Route::post('/reports/daily-sales/filter','ReportsController@filter_sales')->name('filter_sales');


Route::get('/reports/daily-commission','ReportsController@daily_commission')->name('daily_commission');

Route::post('/rveports/daily-commission/filter','ReportsController@filter_commission')->name('filter_commission');

Route::get('/payment-complete',function() {
	return view('invoice.processing_payment')->name('payment.complete');
});

Route::get('/invoice/edit/{id}','ReportsController@edit')->name('invoice.edit1');
Route::post('/invoice-sale/update/{id}','ReportsController@update')->name('sale.update');


Route::post('/sales/reports/{id}','ReportsController@destroy')->name('sale.destroy');
