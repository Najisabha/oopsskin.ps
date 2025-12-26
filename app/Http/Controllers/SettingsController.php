<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }
    
    public function update(Request $request)
    {
        // Logic to update settings
        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}

