<?php

namespace App\Http\Controllers;

use App\invoices;
use App\sections;
use Illuminate\Http\Request;

class ClientReportController extends Controller
{
    public function client_report(){
        $sections = sections::all();
        return view('reports.client_report',compact('sections'));
    }

    public function client_search(Request $request){

            if ($request->Section && $request->product && $request->start_at =='' && $request->end_at =='') {

                $invoices = invoices::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
                $sections = sections::all();
                return view('reports.client_report',compact('sections'))->withDetails($invoices);
            }else{
                $start_at = date($request->start_at);
                $end_at = date($request->end_at);

                $invoices = invoices::whereBetween('invoice_data',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
                $sections = sections::all();
                return view('reports.invoices_report',compact('sections'))->withDetails($invoices);
            }
    }

}
