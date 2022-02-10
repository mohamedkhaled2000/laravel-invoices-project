<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\invoices;
use App\invoices_attachment;
use App\invoices_details;
use App\Notifications\AddInvoice;
use App\Notifications\create_invoices;
use App\prodacts;
use App\sections;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = sections::all();
        return view('invoices.invoices_create',compact('sections'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_data' => $request->invoice_Date,
            'due_data' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_Collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoices::latest()->first()->id;

        invoices_details::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section' => $request->Section,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name)
        ]);

        if($request->hasFile('pic')){

            $id_invoice = invoices::latest()->first()->id;

            $file_name = $request -> file('pic')->getClientOriginalName();
            $attachment = new invoices_attachment();
            $attachment->file_name = $file_name;
            $attachment->invoice_number = $request->invoice_number;
            $attachment->created_by = Auth::user()->name;
            $attachment->id_invoice = $id_invoice;
            $attachment->save();

            $imgName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachment/'.$request->invoice_number),$imgName);
        }


        //send email
        $user = User::first();
        Notification::send($user , new AddInvoice($invoice_id) );

        // send notificatio
        $userNotif = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user , new create_invoices($invoices) );


        session()->flash('Add','تم اضافة الفاتورة بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id',$id)->first();
        return view('invoices.status_update',compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id',$id)->first();
        $sections = sections::all();
        return view('invoices.invoices_edit',compact('invoices','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    $invoices = invoices::findOrFail($request->invoice_id);
    $invoices->update([
        'invoice_number' => $request->invoice_number,
        'invoice_data' => $request->invoice_Date,
        'due_data' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->Section,
        'Amount_Collection' => $request->Amount_collection,
        'Amount_Commission' => $request->Amount_Commission,
        'Discount' => $request->Discount,
        'Value_VAT' => $request->Value_VAT,
        'Rate_VAT' => $request->Rate_VAT,
        'Total' => $request->Total,
        'note' => $request->note,
    ]);

    session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
    return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = invoices::where('id',$request->invoice_id)->first();
        $details = invoices_attachment::where('id_invoice',$request->invoice_id)->first();

        $page_id = $request->page_id;

        if(!$page_id == 2){

            if(!empty($details->invoice_number)){
                Storage::disk('show')->deleteDirectory($details->invoice_number);
            }

            $invoices->forceDelete();
            session()->flash('deleted');
            return redirect('/invoices');
        }else{
            $invoices->delete();
            session()->flash('archive');
            return redirect('/invoices');
        }
    }

    public function getProdacts($id){
        $prodacts = DB::table('prodacts')->where('section_id',$id)->pluck('prodact_name','id');
        return json_encode($prodacts);
    }


    public function status_update($id,Request $request){

        $invoices = invoices::findOrFail($id);


        if($request->status === 'مدفوعة'){
            $invoices->update([
                'value_status' => 1,
                'status' => $request->status,
            ]);

            invoices_details::create([
                'invoice_id' => $request -> invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->status,
                'value_status' => 1,
                'Payment_date' => $request->Payment_date,
                'note' => $request->note,
                'user' => (Auth::user()->name)
            ]);
        }else{
            $invoices->update([
                'value_status' => 3,
                'status' => $request->status,
                'Payment_date' => $request->Payment_date
            ]);

            invoices_details::create([
                'invoice_id' => $request -> invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section' => $request->Section,
                'status' => $request->status,
                'value_status' => 3,
                'Payment_date' => $request->Payment_date,
                'note' => $request->note,
                'user' => (Auth::user()->name)
            ]);
        }
        return redirect('/invoices');
    }

    public function invoice_paid(){
        $invoices = invoices::where('value_status',1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }
    public function invoice_unPaid(){
        $invoices = invoices::where('value_status',2)->get();
        return view('invoices.invoices_unPaid',compact('invoices'));
    }
    public function invoice_parital(){
        $invoices = invoices::where('value_status',3)->get();
        return view('invoices.invoices_parital',compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'الفواتير.xlsx');
    }

    public function MarkAsRead_all(Request $request){
        $unreadNotifications = auth()->user()->unreadNotifications;
        if ($unreadNotifications){
            $unreadNotifications->MarkAsRead();
            return back();
        }
    }
}
