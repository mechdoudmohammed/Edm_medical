<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livraison;
use App\Models\Coupon;

class LivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livraison=Livraison::orderBy('id','DESC')->paginate(10);
        return view('backend.livraison.index')->with('livraisons',$livraison);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.livraison.create');
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
            'type'=>'string|required',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        // return $data;
        $status=Livraison::create($data);
        if($status){
            request()->session()->flash('Succès','Livraison crée avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('livraison.index');
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
        $livraison=Livraison::find($id);
        if(!$livraison){
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return view('backend.livraison.edit')->with('livraison',$livraison);
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
        $livraison=Livraison::find($id);
        $this->validate($request,[
            'type'=>'string|required',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        // return $data;
        $status=$livraison->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Livraison modifié avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('livraison.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $livraison=Livraison::find($id);
        if($livraison){
            $status=$livraison->delete();
            if($status){
                request()->session()->flash('Succès','Livraison supprimé avec succès');
            }
            else{
                request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
            }
            return redirect()->route('livraison.index');
        }
        else{
            request()->session()->flash('erreur','Livraison introuvable');
            return redirect()->back();
        }
    }
}
