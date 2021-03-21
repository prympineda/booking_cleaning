<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Booking;
use App\User;
use App\Payment;
use App\Notifications\ApproveCleanerNotification;

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

    public function getPendingCleaners(){
        $employees = User::where('status', 0)->where('role_id', 2)->get();
        return view('admin.employee.pendings', compact('employees'));
    }

    public function approveCleaner(Request $request){

        $user = User::find($request->uid);

        $user->update([
            'status' => 1
        ]);

        $user->notify( new ApproveCleanerNotification( $user ) );

        return redirect()->back()->with('success', "Successfully Approve Cleaner");
    }

    public function storeUser(Request $request){

        $validator = Validator::make( $request->all(), [
            'user_name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users',
            'user_mobile_number' => 'required|numeric|digits:10|starts_with:9',
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
            $today = date('Y-m-d H:i');
            $user->update([
                'subscription_expire' =>  date('Y-m-d H:i', strtotime($today. ' + 1 month'))
            ]);

            Payment::create([
                'user_id' => $user->id,
                'created_by' => Auth::user()->id,
                'transaction_number' => $request->transaction_number,
                'amount' => $request->amount,
                'status' => "Paid",
                'admin_comment' => $request->admin_comment
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

        $user_type = "customer";
        if($user->role_id == 2){
            $user_type = "employee";
        }

        return redirect()->route('list-'.$user_type)->with('success', "Successfully Update " . ucfirst($user_type . " Details"));

    }

    public function listAdmins(){
        $admins = User::where('role_id', 1)->get();
        return view('admin.admins', compact('admins'));
    }

    public function showAdmin($id){
        $admin = User::find($id);
        return view('admin.edit-admin', compact('admin'));
    }

    public function updateAdmin(Request $request, $id){

        $user = User::find($id);

        $validator = Validator::make( $request->all(), [
            'user_name' => 'required|string',
            'email' => 'required|email'
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
            'email' => $request->email
        ]);

        if ($request->has('password')){ 
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('list-admin')->with('success', "Successfully Update Admin Details");
    }

    public function storeAdmin(Request $request){
        
        $validator = Validator::make( $request->all(), [
            'user_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        $user = User::create([
            'name' => $request->user_name,
            'role_id' => 1,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('list-admin')->with('success', "Successfully Created Admin");
    }

    public function deleteUser(Request $request){

        $user = User::find($request->uid);

        $user->delete();

        $type = $user->role_id == 1 ? 'admin' : ($user->role_id == 2 ? 'employee' : 'customer' );

        return redirect()->route('list-'.$type)->with('success', "Successfully Deleted ". ucfirst($type));
    }

}

  
