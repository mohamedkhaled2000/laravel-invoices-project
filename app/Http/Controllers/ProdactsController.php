<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdactRequest;
use App\prodacts;
use App\sections;
use Illuminate\Http\Request;

class ProdactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = sections::all();
        $prodacts = prodacts::all();
        return view('prodacts.prodacts',compact('sections','prodacts'));
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
    public function store(ProdactRequest $request)
    {
            prodacts::create([
                'prodact_name' => $request -> prodact_name,
                'description' => $request -> description,
                'section_id' => $request -> section_id
            ]);

            session()->flash('Add' , 'تم اضافة المنتج بنجاح');
            return redirect('/prodacts');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\prodacts  $prodacts
     * @return \Illuminate\Http\Response
     */
    public function show(prodacts $prodacts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\prodacts  $prodacts
     * @return \Illuminate\Http\Response
     */
    public function edit(prodacts $prodacts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\prodacts  $prodacts
     * @return \Illuminate\Http\Response
     */
    public function update(ProdactRequest $request)
    {
        $id = $request -> id;

        $this->validate($request,[
            'prodact_name' => 'required|max:100|unique:prodacts,prodact_name,'.$id,
        ]);

        $prodacts = prodacts::find($id);
        $prodacts->update([
            'prodact_name' => $request -> prodact_name,
            'description' => $request -> description,
            'section_id' => $request -> section_id
        ]);

        session()->flash('Edite' , 'تم تعديل المنتج بنجاح');
        return redirect('/prodacts');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\prodacts  $prodacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request -> id;
        prodacts::find($id) -> delete();
        session()->flash('Delete' , 'تم حذف المنتج بنجاح');
        return redirect('/prodacts');
    }
}
