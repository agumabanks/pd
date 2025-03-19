<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class VerificationController extends Controller
{
    //
    // public function verify(Request $request)
    // {
    //     // Validate the request
    //     $request->validate( ){
    //         }

            public function verify($id)
            {
                $order = Order::findOrFail($id);
                return view('orders.show', compact('order'));
            }
        
}
