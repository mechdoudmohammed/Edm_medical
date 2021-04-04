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
        return view('backend.livreur.index')->with('Livreurs',$livreur);
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
          //  'type'=>'string|required',
           // 'price'=>'nullable|numeric',
           // 'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        // return $data;
        $status=Livraison::create($data);
        if($status){
            request()->session()->flash('success','Livraison successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('livraison.index');
    }
}
