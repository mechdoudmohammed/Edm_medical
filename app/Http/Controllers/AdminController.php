<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Reclamation;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
class AdminController extends Controller
{
    
    public function index(){
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
    $profile=Auth()->user();
     return view('backend.index')->with('users',json_encode($array))
                                 ->with('profile',$profile);
    
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile',$profile);
    }
        //afficher la liste des reclamations pour l'admin
    public function showreclamation(){
    
        return view('backend.reclamation.index');
    }
        //modifier l'etat d'un reclamation pour un client
    public function editereclamation (Request $req,$id){

        $reclamation=Reclamation::findOrFail($id);
        $statut=$req->all();
        $reclamation->fill($statut)->save();
        return redirect()->back();
    } 

    public function profileUpdate(Request $request,$id){


         
        $user=User::findOrFail($id);
        if ($request->photo == null){
            $request['photo'] = $user->photo;
            $data=$request->all();
            $status=$user->fill($data)->save();
            return redirect()->back();
            
        }
       // return $request->all();
        $file_extension=$request -> photo -> getClientOriginalExtension();
        $file_name = time().".".$file_extension;
        $path='backend/img/utilisateurs';
        $request->photo -> move($path,$file_name);

        $data=$request->all();
        $data['photo']= $file_name;
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Profile modifié avec Succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->back();
    }


    public function changePassword(){
        $profile=Auth()->user();
        return view('backend.layouts.changePassword')->with('profile',$profile);
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('admin')->with('Succès','Changement de mot de passe avec succès');
    }

    // Pie chart
    public function userPieChart(Request $request){
        // dd($request->all());
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
     return view('backend.index')->with('course', json_encode($array));
    }

    // public function activity(){
    //     return Activity::all();
    //     $activity= Activity::all();
    //     return view('backend.layouts.activity')->with('activities',$activity);
    // }
}
