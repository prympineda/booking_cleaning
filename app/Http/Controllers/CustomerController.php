<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Booking;
use App\Rate;
use App\Payment;
use App\User;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::where('customer_id', Auth::user()->id)->get();
        return view('customer.index', compact('bookings'));
    }

    public function bookClean(){
        return view('customer.book');
    }

    public function getPayments(){
        $payments = Payment::where('user_id',Auth::user()->id)
                            ->where('is_deleted', 0)
                            ->get();
        return view('employee.payments', compact('payments'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $employee = Auth::user();
        return view('customer.profile', compact('employee'));
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
    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);

        $validator = Validator::make( $request->all(), [
            'user_name' => 'required|string',
            'email' => 'required|email',
            'user_mobile_number' => 'required|numeric|digits:10|starts_with:9',
            'user_address' => 'required',
            'user_address_landmark' => 'required'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        if ($user->email != $request->email){
            $validator = Validator::make( $request->all(), [
                'email' => 'unique:users|email:rfc,dns'
            ]);

            if ( $validator->fails() ) {
                return redirect()->back()->withInput()->with('errors', $validator->errors());
            }
        }

        if ($request->password != ""){

            $validator = Validator::make( $request->all(), [
                'password' => 'required|min:8|confirmed'
            ]);
    
            if ( $validator->fails() ) {
                return redirect()->back()->withInput()->with('errors', $validator->errors());
            }

        }

        $user->update([
            'name' => $request->user_name,
            'email' => $request->email,
            'mobile_number' => $request->user_mobile_number,
            'address' => $request->user_address,
            'address_landmark' => $request->user_address_landmark
        ]);

        if ($request->has('password')){ 
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->back()->with('success', "Successfully Update Profile");
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
