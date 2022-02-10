<?php

namespace App\Http\Controllers;

use App\Http\Requests\attachmentRequest;
use App\invoices_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(attachmentRequest $request)
    {
        $file_name = $request->file('pic')->getClientOriginalName();
        $attachment = new invoices_attachment();

        $attachment->file_name = $file_name;
        $attachment->invoice_number = $request->invoice_number;
        $attachment->created_by = Auth::user()->name;
        $attachment->id_invoice = $request->invoice_id;
        $attachment->save();


        $imgName = $request->pic->getClientOriginalName();
        $request->pic->move(public_path('Attachment/'.$request->invoice_number),$imgName);

        session()->flash('Add','تم اضافة المرفق بنجاح');
        return redirect()->back();
        // return $request;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_attachment $invoices_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices_attachment  $invoices_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_attachment $invoices_attachment)
    {
        //
    }
}
