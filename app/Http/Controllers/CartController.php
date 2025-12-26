<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }
    
    public function add(Request $request)
    {
        // Logic to add product to cart
        return redirect()->back()->with('success', 'تم إضافة المنتج للسلة');
    }
    
    public function remove($id)
    {
        // Logic to remove product from cart
        return redirect()->back()->with('success', 'تم حذف المنتج من السلة');
    }
}

