<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Order;
use App\User;
use Illuminate\Support\Str;
use Notification;
use DB;
use App\Models\Reclamation;
use App\Notifications\StatusNotification;
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
        $this->validate($req,[
            'type_reclamation'=>'required',
            'msg_reclamation'=>'required',
            'user_id'=>'required',
        ]);

        $reclamation= new Reclamation;
        $reclamation->type_reclamation= $req->type_reclamation;
        $reclamation->msg_reclamation= $req->msg_reclamation;
        $reclamation->id_order=$id;
        $reclamation->id_user=$req->user_id;


        $status = DB::table('reclamations')->where('id_order', '=', $id)->get(); 
        // test 3la wach id_order deja kayn f la base de donnee
     foreach($status as $v){
        if($v->id_order==$id) {
            request()->session()->flash('error','Erreur, cet reclamation est deja fait');
            return redirect()->route('user');
        }
     }
     $reclamation->save() ; 

 
        
        if($reclamation)
        $users=User::where('role','admin')->first();
        $details=[
            'title'=>'Nouvelle reclamation par user N:'.$reclamation->id_user,
            'actionURL'=>route('backend.reclamtion.index'),
            'fas'=>'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
        return redirect()->route('user');

    }





}
