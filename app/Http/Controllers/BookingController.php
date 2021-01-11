<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking;
use App\User;
use App\Rate;

use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function getResources(Request $request){

        $start_date = date('Y-m-d H:m:s', strtotime($request->start_date));
        $end_date = date('Y-m-d H:m:s', strtotime($request->end_date));

        $booking = Booking::where('start_date', '<=', $end_date)
                          ->where('end_date', '>=', $start_date)
                          ->get();

        $resources = User::whereNotIn('id', $booking->pluck('employee_id'))
                         ->where('role_id', 2)
                         ->get();

        foreach($resources as $key => $r){
            $resources[$key]['rate'] = Rate::select('price')->where('employee_id', $r->id)->get();
        }
        
        $books = Booking::all();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => [
                'success' => TRUE,
                'message' => "Test",
                'data' => $resources,
                'books' => $books
                ]
        ]);
    }

    public function saveBooking(Request $request){
        $start_date = date('Y-m-d H:m:s', strtotime($request->start_date));
        $end_date = date('Y-m-d H:m:s', strtotime($request->end_date));

        $book = new Booking;
        $book->employee_id = $request->employee_id;
        $book->customer_id = Auth::user()->id;
        $book->price = $request->total_price;
        $book->start_date = $start_date;
        $book->end_date = $end_date;
        $book->save();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'data' => [
                'success' => TRUE,
                'message' => "Successfully Saved your Booking",
                ]
          ]);

    }
}
