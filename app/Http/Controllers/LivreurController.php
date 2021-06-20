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
            'photo'=>'required',
            'telephone'=>'string|required',
            'email'=>'string|required',
            'password'=>'string|required',
            'adresse'=>'string|required',
            'cin'=>'string|required',
            'numero_permis'=>'string|required',
            'status'=>'required|in:active,inactive'
        ]);

         //enregister la photo
         $file_extension=$request -> photo -> getClientOriginalExtension();

         $file_name = time().".".$file_extension;
         $path='backend/img/livreur';
         $request->photo -> move($path,$file_name);
         $data=$request->all();
        
         $data['photo']=$file_name;
      
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
                      'adresse'=>'string|required',
            'cin'=>'string|required',
            'numero_permis'=>'string|required',
            'adresse'=>'string|required',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        if ($request->photo == null){
            $request['photo'] = $livreur->photo;
        }
        elseif($request->photo != null){
            //enregister la photo
            $data=$request->all();

            $file_extension_img=$request->photo->getClientOriginalExtension();
            if($file_extension_img!="png" && $file_extension_img!="jpg" && $file_extension_img!="jpeg" ){
              request()->session()->flash('erreur','Erreur, le fichier doit etre une image');
              return redirect()->route('livreur.edit',$id);
                 }
                 $file_name = time().".".$file_extension_img;
                 $path='backend/img/livreur';
                 $request->photo -> move($path,$file_name);
                 $data['photo']=$file_name;
        }

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

