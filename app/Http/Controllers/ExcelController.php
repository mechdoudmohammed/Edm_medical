<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelExcel;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ModelExcel=ModelExcel::orderBy('id','DESC')->paginate(10);
        return view('backend.excel.index')->with('ModelExcel',$ModelExcel);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.excel.create');
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
            'titre'=>'string|required',
            'fichier'=>'required'
        ]);

         //enregister fichier
         $file_extension=$request->fichier->getClientOriginalExtension();
         //return  gettype($file_extension) ;
                  
if($file_extension!="xlsx"){
    request()->session()->flash('erreur','Erreur, Extention doit etre xlsx');
    return redirect()->route('excel.create');
}



$file_name = $request->titre."_".time().".".$file_extension;
$path='backend/model_excel';
$request->fichier -> move($path,$file_name);
     $data=$request->all();
    $data['fichier']=$file_name;
      
      
         



        $status=ModelExcel::create($data);
        if($status){
            request()->session()->flash('Succès','Model excel est crée avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('excel.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
 
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ModelExcel=ModelExcel::find($id);
        if($ModelExcel){
            $status=$ModelExcel->delete();
            if($status){
                request()->session()->flash('Succès','ModelExcel supprimé avec succès');
            }
            else{
                request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
            }
            return redirect()->route('excel.index');
        }
        else{
            request()->session()->flash('erreur','ModelExcel introuvable');
            return redirect()->back();
        }
    }
}
