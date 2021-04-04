<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fournisseur;
use Illuminate\Support\Str;
class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseur=Fournisseur::orderBy('id','DESC')->paginate();
        return view('backend.fournisseur.index')->with('fournisseurs',$fournisseur);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.fournisseur.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nom'=>'string|required',
            'adresse'=>'string|required',
            'telephone'=>'string|required',
            'email'=>'string|required',
        ]);
        $data=$request->all();
        // return $data;
        $status=Fournisseur::create($data);

        if($status){
            request()->session()->flash('success','Fournisseur successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('fournisseur.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fournisseur=Fournisseur::find($id);
        if(!$fournisseur){
            request()->session()->flash('error','Fournisseur not found');
        }
        return view('backend.fournisseur.edit')->with('fournisseur',$fournisseur);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fournisseur=Fournisseur::find($id);
        $this->validate($request,[
            'nom'=>'string|required',
            'adresse'=>'string|required',
            'telephone'=>'string|required',
            'email'=>'string|required',
        ]);
        $data=$request->all();
     //  return $data;
        $status=$fournisseur->fill($data)->save();
        if($status){
            request()->session()->flash('success','Fournisseur successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('fournisseur.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fournisseur=Fournisseur::find($id);
        if($fournisseur){
            $status=$fournisseur->delete();
            if($status){
                request()->session()->flash('success','Fournisseur successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('fournisseur.index');
        }
        else{
            request()->session()->flash('error','Fournisseur not found');
            return redirect()->back();
        }
    }
}
