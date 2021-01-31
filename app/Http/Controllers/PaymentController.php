<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use App\Payment;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->get();
        return view('admin.subscription', compact('users'));
    }

    public function noPayment(){
        $payments = Payment::where('user_id',Auth::user()->id)
                            ->where('is_deleted', 0)
                            ->get();
        return view('no-payment', compact('payments'));
    }

    public function getPayments(){
        $payments = Payment::where('is_deleted', 0)->get();
        return view('admin.payment', compact('payments'));
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
        $validator = Validator::make( $request->all(), [
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'transaction_number' => 'required',
            'subscription_expire' => 'required|date|after:today',
            'comment' => 'required'
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => [
                    'success' => FALSE,
                    'errors' => $validator->errors(),
                    ]
            ]);
        }

        $data = Payment::create([
            'user_id' => $request->user_id,
            'created_by' => Auth::user()->id,
            'transaction_number' => $request->transaction_number,
            'amount' => $request->amount,
            'status' => "Paid",
            'admin_comment' => $request->comment
        ]);

        $data['subscription_expire'] = date('Y-m-d H:i', strtotime($request->subscription_expire));

        User::where('id', $request->user_id)->update([
            'subscription_expire' => $data['subscription_expire']
        ]);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => [
                'success' => TRUE,
                'data' => $data,
                'message' => "Successfully Saved the Transaction"
                ]
        ]);
        
    }

    public function saveRequestedTransaction(Request $request){

        $validator = Validator::make( $request->all(), [
            'amount' => 'required|numeric',
            'transaction_number' => 'required',
            'user_comment' => 'required'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        $data = Payment::create([
            'user_id' => Auth::user()->id,
            'created_by' => Auth::user()->id,
            'transaction_number' => $request->transaction_number,
            'amount' => $request->amount,
            'status' => "Pending",
            'user_comment' => $request->user_comment
        ]);

        return redirect()->back()->with('success', "Successfully Saved the Transaction, the admin will review your payment and update your activation period.");
    }

    public function saveRequestedPayment(Request $request){

        $validator = Validator::make( $request->all(), [
            'amount' => 'required|numeric',
            'transaction_number' => 'required',
            'user_comment' => 'required'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        $data = Payment::create([
            'user_id' => Auth::user()->id,
            'created_by' => Auth::user()->id,
            'transaction_number' => $request->transaction_number,
            'amount' => $request->amount,
            'status' => "Pending",
            'user_comment' => $request->user_comment
        ]);

        $type = Auth::user()->role_id == 2 ? 'employee' : 'customer';

        return redirect()->route($type.'-payments')->with('success', "Successfully Saved the Transaction, the admin will review your payment and update your activation period.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        return view('admin.view-payment', compact('payment'));
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
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        $validator = Validator::make( $request->all(), [
            'amount' => 'required|numeric',
            'transaction_number' => 'required',
            'admin_comment' => 'required',
            'status' => 'required|in:Pending,Paid'
        ]);

        if ( $validator->fails() ) {
            return redirect()->back()->withInput()->with('errors', $validator->errors());
        }

        if($request->has('subscription_expire')){
            $validator = Validator::make( $request->all(), [
                'subscription_expire' => 'required|date|after:today'
            ]);
            if ( $validator->fails() ) {
                return redirect()->back()->withInput()->with('errors', $validator->errors());
            }
        }

        $payment->update([
            'amount' => $request->amount,
            'transaction_number' => $request->transaction_number,
            'admin_comment' => $request->admin_comment,
            'status' => $request->status
        ]);

        if($request->has('subscription_expire')){
            User::where('id', $payment->user->id)->update([
                'subscription_expire' => date('Y-m-d H:i', strtotime($request->subscription_expire))
            ]);
        }

        return redirect()->route('get-payments')->with('success', "Successfully Updated the Payment");

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
