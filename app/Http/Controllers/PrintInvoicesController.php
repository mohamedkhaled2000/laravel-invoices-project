<?php

namespace App\Http\Controllers;

use App\invoices;
use Illuminate\Http\Request;

class PrintInvoicesController extends Controller
{
    public function index($id){

        $invoices = invoices::where('id',$id)->first();
        return view('invoices.print_invoice',compact('invoices'));
    }
}
