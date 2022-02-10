<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




Route::resource('invoices','InvoicesController');
Route::resource('sections', 'SectionsController');
Route::resource('prodacts', 'ProdactsController');
Route::resource('invoiceAttachment', 'InvoicesAttachmentController');



Route::get('/section/{id}' , 'InvoicesController@getProdacts');
Route::get('invoicesDetails/{id}' , 'InvoicesDetailsController@edit')->name('invoicesDetails');
Route::get('view_file/{invoice_number}/{file_name}' , 'InvoicesDetailsController@open_file');
Route::get('download/{invoice_number}/{file_name}' , 'InvoicesDetailsController@download');
Route::post('delete' , 'InvoicesDetailsController@destroy')->name('delete_file');
Route::get('invoice_edit/{id}' , 'InvoicesController@edit')->name('invoice_edit');

Route::get('status_show/{id}' , 'InvoicesController@show')->name('status_show');
Route::post('status_update/{id}' , 'InvoicesController@status_update')->name('status_update');

Route::get('paid' , 'InvoicesController@invoice_paid');
Route::get('Unpaid' , 'InvoicesController@invoice_unPaid');
Route::get('parital' , 'InvoicesController@invoice_parital');

Route::get('Archives' , 'InvoicesArchiveController@invoice_archive');
Route::post('updateArchive' , 'InvoicesArchiveController@updateArchive')->name('updateArchive');
Route::post('deleteArchive' , 'InvoicesArchiveController@deleteArchive')->name('deleteArchive');

Route::get('printInvoice/{id}' , 'PrintInvoicesController@index')->name('printInvoice');

Route::get('export_invoice', 'InvoicesController@export')->name('export_invoice');

Route::get('invoces_report', 'Invoices_ReportController@index')->name('invoces_report');
Route::post('invoices_search', 'Invoices_ReportController@invoices_search')->name('invoices_search');

Route::get('client_report', 'ClientReportController@client_report')->name('client_report');
Route::post('client_search', 'ClientReportController@client_search')->name('client_search');


Route::get('MarkAsRead_all', 'InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    });




Route::get('/{page}', 'AdminController@index');
