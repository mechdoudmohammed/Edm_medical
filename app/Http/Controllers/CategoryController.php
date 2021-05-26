<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorie=Categorie::getAllCategory();
        // return $categorie;
        return view('backend.categorie.index')->with('categories',$categorie);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats=Categorie::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.categorie.create')->with('parent_cats',$parent_cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo'=>'nullable',
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
                $file_extension=$request -> photo -> getClientOriginalExtension();
                $file_name = time().".".$file_extension;
                $path='backend/img/categories';
                $request->photo -> move($path,$file_name);

        $data= $request->all();
        $slug=Str::slug($request->title);
        $count=Categorie::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_parent']=$request->input('is_parent',0);
        $data['photo']= $file_name;
        // return $data;


        $status=Categorie::create($data);
        if($status){
            request()->session()->flash('Succès','Categorie ajouté avec Succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('categorie.index');


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
        $parent_cats=Categorie::where('is_parent',1)->get();
        $categorie=Categorie::findOrFail($id);
        return view('backend.categorie.edit')->with('categorie',$categorie)->with('parent_cats',$parent_cats);
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
        $categorie=Categorie::findOrFail($id);

        if ($request->photo == null){
            $request['photo'] = $categorie->photo;
        }

        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            'photo'=>'string|nullable',
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $data= $request->all();
        $data['is_parent']=$request->input('is_parent',0);
        // return $data;
        $status=$categorie->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Categorie modifié avec Succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('categorie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorie=Categorie::findOrFail($id);
        $child_cat_id=Categorie::where('parent_id',$id)->pluck('id');
        // return $child_cat_id;
        $status=$categorie->delete();

        if($status){
            if(count($child_cat_id)>0){
                Categorie::shiftChild($child_cat_id);
            }
            request()->session()->flash('Succès','Categorie supprimé avec Succès');
        }
        else{
            request()->session()->flash('Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('categorie.index');
    }

    public function getChildByParent(Request $request){
        // return $request->all();
        $categorie=Categorie::findOrFail($request->id);
        $child_cat=Categorie::getChildByParentID($request->id);
        // return $child_cat;
        if(count($child_cat)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
        }
    }
}
