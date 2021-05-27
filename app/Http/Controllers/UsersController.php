<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderBy('id','ASC')->paginate(10);
        return view('backend.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required|unique:users',
            'password'=>'string|required',
            'role'=>'required|in:admin,user,livreur',
            'status'=>'required|in:active,inactive',
            'photo'=>'required'
         
        ]);
       //return $request;
         //enregister la photo
         $file_extension=$request -> photo -> getClientOriginalExtension();
         if($file_extension!="png" && $file_extension!="jpg" && $file_extension!="jpeg" ){
            request()->session()->flash('erreur','Erreur, le fichier doit etre une image');
            return redirect()->route('users.create');
               }
         $file_name = time().".".$file_extension;
         $path='backend/img/utilisateurs';
         $request->photo -> move($path,$file_name);
        // dd($request->all());
        $data=$request->all();
        $data['photo']=$file_name;
        $data['password']=Hash::make($request->password);
        // dd($data);
        $status=User::create($data);
        // dd($status);
        if($status){
            request()->session()->flash('Succès','utilisateur ajouté avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('users.index');

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
        $user=User::findOrFail($id);
        return view('backend.users.edit')->with('user',$user);
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
        $user=User::findOrFail($id);
        if ($request->photo == null){
            $request['photo'] = $user->photo;
        }
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required',
            'role'=>'required|in:admin,user',
            'status'=>'required|in:active,inactive',
            'photo'=>'required'
        ]);
          //enregister la photo
          $file_extension=$request -> photo -> getClientOriginalExtension();
          $file_name = time().".".$file_extension;
          $path='backend/img/utilisateurs';
          $request->photo -> move($path,$file_name);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        $data['photo']=$file_name;
        //return $data;
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Modification avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('Succès','utilisateur supprimé avec succès');
        }
        else{
            request()->session()->flash('erreur', 'Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('users.index');
    }
}
