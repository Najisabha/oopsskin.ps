<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        return view('addresses.index');
    }
    
    public function store(Request $request)
    {
        // Logic to store address
        return redirect()->back()->with('success', 'تم إضافة العنوان بنجاح');
    }
    
    public function update(Request $request, $id)
    {
        // Logic to update address
        return redirect()->back()->with('success', 'تم تحديث العنوان بنجاح');
    }
    
    public function destroy($id)
    {
        // Logic to delete address
        return redirect()->back()->with('success', 'تم حذف العنوان بنجاح');
    }
}

