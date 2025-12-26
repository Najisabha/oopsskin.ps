<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index');
    }
    
    public function show($id)
    {
        $invoiceId = $id;
        return view('invoices.show', compact('invoiceId'));
    }
    
    public function download($id)
    {
        $invoiceId = $id;
        
        // To enable PDF generation, install: composer require barryvdh/laravel-dompdf
        // Then uncomment the following lines:
        // use Barryvdh\DomPDF\Facade\Pdf;
        // $pdf = Pdf::loadView('invoices.pdf', compact('invoiceId'));
        // return $pdf->download('invoice-' . $id . '.pdf');
        
        // For now, return the PDF view directly
        return view('invoices.pdf', compact('invoiceId'));
    }
}

