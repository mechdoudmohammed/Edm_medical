<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Reclamation;
class ReclamationController extends Controller
{
    public function create($id){
        $order=Order::find($id);
         return view('user.reclamation.create')->with('order',$order);
    }

    public function index(){
        
        return view('user.reclamation.index');
    }

    public function save(Request $req, $id ){

        $reclamation= new Reclamation;
        $reclamation->type_reclamation= $req->type_reclamation;
        $reclamation->msg_reclamation= $req->msg_reclamation;
        $reclamation->id_order=$id;
        $reclamation->id_user=$req->user_id;
        $reclamation->save() ;     
        return redirect()->route('user');

    }





}
