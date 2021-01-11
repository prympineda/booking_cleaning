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

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'Employee']], function () { 

   Route::get('/', 'AdminController@index')->name('admin_dashboard');

});


Route::group(['prefix' => 'employee', 'middleware' => ['auth', 'Employee']], function () { 

    Route::get('/', 'EmployeeController@index')->name('employee_dashboard');

    Route::get('profile', 'EmployeeController@show');

    Route::get('update-price', 'EmployeeController@updatePrice')->name('update-price');

    Route::post('save-price', 'EmployeeController@savePrice')->name('save-price');
    
});


Route::group(['prefix' => 'customer', 'middleware' => ['auth', 'Customer']], function () { 

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
    
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');