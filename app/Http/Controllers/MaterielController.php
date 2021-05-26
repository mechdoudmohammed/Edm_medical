<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materiel;
use App\Models\Categorie;
use App\Models\Fournisseur;

use Illuminate\Support\Str;

class MaterielController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materiels=Materiel::getAllMateriel();
        // return $materiels;
        return view('backend.materiel.index')->with('materiels',$materiels);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fournisseur=Fournisseur::get();
        $categorie=Categorie::where('is_parent',1)->get();
        // return $categorie;
        return view('backend.materiel.create')->with('categories',$categorie)->with('fournisseurs',$fournisseur);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request["location"]==false){
         $request["prix_location"]=null;
        }
        //return $request->all();
        $this->validate($request,[
            'nom'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'required',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'fournisseur_id'=>'nullable|exists:fournisseurs,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric',
            'location'=>'required'
        ]);
        //return $request;
        //enregister la photo
        $file_extension=$request -> photo -> getClientOriginalExtension();
        $file_name = time().".".$file_extension;
        $path='backend/img/materiels';
        $request->photo -> move($path,$file_name);
        //enregister le fichier fiches technique
        $file_extension=$request -> fiche_technique -> getClientOriginalExtension();
        $file_name_fiche_technique = time().".".$file_extension;
        $path2='backend/fiches_techniques';
        $request->fiche_technique -> move($path2,$file_name_fiche_technique);

        $data=$request->all();
        $slug=Str::slug($request->nom);
        $count=Materiel::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['photo']=$file_name;
        $data['fiche_technique']=$file_name_fiche_technique;

        $data['is_featured']=$request->input('is_featured',0);
        // return $data;
        $status=Materiel::create($data);
        if($status){
            request()->session()->flash('Succès','Materiel ajouté avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('materiel.index');

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
        $fournisseur=Fournisseur::get();
        $materiel=Materiel::findOrFail($id);
        $categorie=Categorie::where('is_parent',1)->get();
        $items=Materiel::where('id',$id)->get();
        // return $items;
        return view('backend.materiel.edit')->with('materiel',$materiel)
                    ->with('fournisseurs',$fournisseur)
                    ->with('categories',$categorie)->with('items',$items);
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
       
        $materiel=Materiel::findOrFail($id);
     
        if ($request->photo == null){
            $request['photo'] = $materiel->photo;
        }
   
        $this->validate($request,[
            'nom'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'string|required',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'is_featured'=>'sometimes|in:1',
            'fournisseur_id'=>'nullable|exists:fournisseurs,id',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,hot',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data=$request->all();
        $data['is_featured']=$request->input('is_featured',0);
         //return $data;
        $status=$materiel->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Materiel modifié avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('materiel.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $materiel=Materiel::findOrFail($id);
        $status=$materiel->delete();

        if($status){
            request()->session()->flash('Succès','Materiel supprimé avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('materiel.index');
    }
}
