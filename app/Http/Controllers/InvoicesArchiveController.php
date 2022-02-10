<?php

namespace App\Http\Controllers;

use App\invoices;
use Illuminate\Http\Request;

class InvoicesArchiveController extends Controller
{
    public function invoice_archive(){
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.invoices_archives',compact('invoices'));
    }

    public function updateArchive(Request $request){

        $invoice_id = $request->invoice_id;
        invoices::withTrashed()->where('id',$invoice_id)->restore();
        session()->flash('restore_archive');
        return redirect('/invoices');
    }

    public function deleteArchive(Request $request){
        $invoices = invoices::withTrashed()->where('id',$request->invoice_id)->first();
        $invoices->forceDelete();
        session()->flash('deleted');
        return redirect('/Archives');
    }


}
