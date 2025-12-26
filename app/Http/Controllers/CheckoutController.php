<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }
    
    public function complete(Request $request)
    {
        // Logic to complete purchase
        return redirect()->route('invoices.index')->with('success', 'تم إتمام الطلب بنجاح');
    }
}

