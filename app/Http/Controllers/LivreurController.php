<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livreur;
use Illuminate\Support\Str;

class LivreurController extends Controller
{
    public function index()
    {
        $livreur=Livreur::orderBy('id','DESC')->paginate(10);
        return view('backend.livreur.index')->with('livreurs',$livreur);
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $livreur=Livreur::get();
        // return $livreur;
        return view('backend.livreur.create')->with('livreurs',$livreur);
    }


    public function store(Request $request)
    { 
        $this->validate($request,[
            'nom'=>'string|required',
            'prenom'=>'string|required',
            'telephone'=>'string|required',
            'email'=>'string|required',
            'password'=>'string|required',
            'description'=>'string|required',
            'adresse'=>'string|required',
            'cin'=>'string|required',
            'numero_permis'=>'string|required',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
    //   return $data;
        
        $status=Livreur::create($data);
        if($status){
            request()->session()->flash('succés','Livreur crée avec succés ');
        }
        else{
            request()->session()->flash('erreur','erreur réessayer ultérierement');
        }
        return redirect()->route('livreur.index');
    }

    public function update(Request $request, $id)
    {
        $livreur=Livreur::find($id);
        $this->validate($request,[
            'nom'=>'string|required',
            'prenom'=>'string|required',
            'telephone'=>'string|required',
            'email'=>'string|required',
            'password'=>'string|required',
            'description'=>'string|required',
            'adresse'=>'string|required',
            'cin'=>'string|required',
            'numero_permis'=>'string|required',
            'adresse'=>'string|required',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        // return $data;
        $status=$livreur->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Livreur modifié avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('livreur.index');
       
        
    }
    public function edit($id)
    {
        $livreur=Livreur::find($id);
        if(!$livreur){
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return view('backend.livreur.edit')->with('livreur',$livreur);
    }


    public function destroy($id)
    {
        $livreur=Livreur::find($id);
        if($livreur){
            $status=$livreur->delete();
            if($status){
                request()->session()->flash('succés','Livreur supprimer avec succés');
            }
            else{
                request()->session()->flash('erreur','erreur réessayer ultérierement');
            }
            return redirect()->route('livreur.index');
        }
        else{
            request()->session()->flash('erreur','Livreur introuvable');
            return redirect()->back();
        }
    }
}

