<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Booking;
use App\User;
use App\Payment;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $bookings = Booking::all();
       return view('admin.index', compact('bookings'));
    }

    public function getEmployees(){
        $employees = User::where('role_id', 2)->get();
       return view('admin.employee.index', compact('employees'));
    }

    public function getCustomers(){
        $customers = User::where('role_id', 3)->get();
       return view('admin.customer.index', compact('customers'));
    }

    public function storeUser(Request $request){

        $validator = Validator::make( $request->all(), [
            'user_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'user_mobile_number' => 'required|numeric',
            'user_address' => 'required',
            'user_address_landmark' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        if($request->has('add_subscription')){
            $validator = Validator::make( $request->all(), [
                'amount' => 'required|numeric',
                'transaction_number' => 'required',
                'subscription_expire' => 'required|date|after:today',
                'admin_comment' => 'required'
            ]);

            if ( $validator->fails() ) {
                return redirect()->back()->withInput()->with('errors', $validator->errors());
            }
        }

        $user = User::create([
            'name' => $request->user_name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'mobile_number' => $request->user_mobile_number,
            'address' => $request->user_address,
            'address_landmark' => $request->user_address_landmark,
            'password' => Hash::make($request->password)
        ]);

        if($request->has('add_subscription')){ 
            $user->update([
                'subscription_expire' =>  date('Y-m-d H:i', strtotime($request->subscription_expire))
            ]);

            Payment::create([
                'user_id' => $user->id,
                'created_by' => Auth::user()->id,
                'transaction_number' => $request->transaction_number,
                'amount' => $request->amount,
                'status' => "Paid",
                'admin_comment' => $request->comment
            ]);
        }

        $user_type = "customer";
        if($request->role_id == 2){
            $user_type = "employee";
        }

        return redirect()->route('list-'.$user_type)->with('success', "Successfully Created " . ucfirst($user_type));

    }

    public function editUser($id){
        $user = User::find($id);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id){

        $user = User::find($id);

        $validator = Validator::make( $request->all(), [
            'user_name' => 'required|string',
            'email' => 'required|email',
            'user_mobile_number' => 'required|numeric',
            'user_address' => 'required',
            'user_address_landmark' => 'required'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        if ($user->email != $request->email){
            $validator = Validator::make( $request->all(), [
                'email' => 'unique:users'
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

        $user_type = "customer";
        if($user->role_id == 2){
            $user_type = "employee";
        }

        return redirect()->route('list-'.$user_type)->with('success', "Successfully Update " . ucfirst($user_type . " Details"));

    }

}

  
