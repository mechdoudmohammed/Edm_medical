<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Materiel;
use App\Models\Category;
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
        $category=Category::where('is_parent',1)->get();
        // return $category;
        return view('backend.materiel.create')->with('categories',$category)->with('fournisseurs',$fournisseur);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'required',
            'size'=>'nullable',
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

        $file_extension=$request -> photo -> getClientOriginalExtension();
        $file_name = time().".".$file_extension;
        $path='backend/img/materiels';
        $request->photo -> move($path,$file_name);

        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Materiel::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['photo']=$file_name;

        $data['is_featured']=$request->input('is_featured',0);
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }
        // return $size;
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
        $category=Category::where('is_parent',1)->get();
        $items=Materiel::where('id',$id)->get();
        // return $items;
        return view('backend.materiel.edit')->with('materiel',$materiel)
                    ->with('fournisseurs',$fournisseur)
                    ->with('categories',$category)->with('items',$items);
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
            'size'=>'nullable',
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
        $size=$request->input('size');
        if($size){
            $data['size']=implode(',',$size);
        }
        else{
            $data['size']='';
        }
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
