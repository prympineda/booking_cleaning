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

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('/', function () {
            if(Auth::user()->role_id == 1){
                return redirect()->route('admin_dashboard');
            } else if (Auth::user()->role_id == 2){
                return redirect()->route('employee_dashboard');
            } else if (Auth::user()->role_id == 3){
                return redirect()->route('customer_dashboard');
            }
    });

});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'Admin']], function () { 

   Route::get('/', 'AdminController@index')->name('admin_dashboard');

   Route::get('/subscription', 'PaymentController@index')->name('admin_subscriptions');

   Route::post('save-payment', 'PaymentController@store')->name('save-payment');

   Route::get('payments', 'PaymentController@getPayments')->name('get-payments');

   Route::get('view-payment/{id}', 'PaymentController@show')->name('view-payment');

   Route::post('update-payment/{id}', 'PaymentController@update')->name('update-payment');
   
   Route::get('list-employee', 'AdminController@getEmployees')->name('list-employee');

   Route::get('list-employee', 'AdminController@getEmployees')->name('list-employee');

   Route::get('list-customer', 'AdminController@getCustomers')->name('list-customer');

   Route::get('pending-cleaners', 'AdminController@getPendingCleaners')->name('pending-cleaners');

   Route::post('approve-cleaners', 'AdminController@approveCleaner')->name('approve-cleaners');

   Route::get('approve-cleaners', function (){
        abort(404);
   });

   Route::get('create-customer', function (){
       return view('admin.customer.create');
   })->name('create-customer');

   Route::get('create-employee', function (){
       return view('admin.employee.create');
   })->name('create-employee');

   Route::post('store-user', 'AdminController@storeUser')->name('store-user');

   Route::get('edit-user/{id}', 'AdminController@editUser')->name('edit-user');

   Route::post('update-user/{id}', 'AdminController@updateUser')->name('update-user');

   Route::get('create-admin', function (){
        return view('admin.create-admin');
    })->name('create-admin');

   Route::get('list-admin', 'AdminController@listAdmins')->name('list-admin');

   Route::get('show-admin/{id}', 'AdminController@showAdmin')->name('show-admin');

   Route::post('update-admin/{id}', 'AdminController@updateAdmin')->name('update-admin');

   Route::post('store-admin', 'AdminController@storeAdmin')->name('store-admin');

   Route::post('delete-user', 'AdminController@deleteUser')->name('delete-user');

});


Route::group(['prefix' => 'employee', 'middleware' => ['auth', 'Subsciption', 'Employee']], function () { 

    Route::get('/', 'EmployeeController@index')->name('employee_dashboard');

    Route::get('profile', 'EmployeeController@show')->name('employee-profile');

    Route::get('update-price', 'EmployeeController@updatePrice')->name('update-price');

    Route::post('save-price', 'EmployeeController@savePrice')->name('save-price');

    Route::get('payments', 'EmployeeController@getPayments')->name('employee-payments');

    Route::post('employee-update-profile/{id}', 'EmployeeController@updateProfile')->name('employee-update-profile');
    
});


Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'Subsciption', 'Customer']], function () { 

    Route::get('/', 'CustomerController@index')->name('customer_dashboard');

    Route::get('book-a-clean', 'CustomerController@bookClean')->name('book-a-clean');

    Route::post('get-resources', 'BookingController@getResources')->name('get_resources');

    Route::get('get-resources', function (){
        abort(404);
    });

    Route::post('save-booking', 'BookingController@saveBooking')->name('save-booking');

    Route::get('save-booking', function (){
        abort(404);
    });

    Route::get('profile', 'CustomerController@show')->name('customer-profile');

    // Route::get('payments', 'CustomerController@getPayments')->name('customer-payments');

    Route::post('customer-update-profile/{id}', 'CustomerController@updateProfile')->name('customer-update-profile');
    
});

Route::get('no-payment', 'PaymentController@noPayment')->name('no-payment')->middleware('auth', 'is_verified_payment');

Route::post('save-requested-transaction', 'PaymentController@saveRequestedTransaction')->name('save-requested-transaction')->middleware('auth', 'is_verified_payment');

Route::post('save-requested-payment', 'PaymentController@saveRequestedPayment')->name('save-requested-payment')->middleware('auth');

Route::get('save-requested-payment', function(){
    abort(404);
})->middleware('auth');

Route::get('add-payment', function(){
    return view('add-payment');
})->name('add-payment');

Auth::routes();