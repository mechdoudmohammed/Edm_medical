<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::getAllPost();
        // return $posts;
        return view('backend.post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=PostCategory::get();
        $tags=PostTag::get();
        $users=User::get();
        return view('backend.post.create')->with('users',$users)->with('categories',$categories)->with('tags',$tags);
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
            'quote'=>'string|nullable',
            'summary'=>'string|required',
            'description'=>'string|nullable',
  
            'tags'=>'nullable',
            'added_by'=>'nullable',
            'post_cat_id'=>'required',
            'status'=>'required|in:active,inactive'
        ]);
        //enregister la photo
        $file_extension_img=$request -> photo -> getClientOriginalExtension();
        $file_name = time().".".$file_extension_img;
        $path='backend/img/poste';
        $request->photo -> move($path,$file_name);
        if($file_extension_img!="png" && $file_extension_img!="jpg" && $file_extension_img!="jpeg" ){
            request()->session()->flash('erreur','Erreur, le fichier doit etre une image');
            return redirect()->route('post.create');
        }


        $data=$request->all();

        $slug=Str::slug($request->title);
        $count=Post::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['photo']=$file_name;
        $tags=$request->input('tags');
        if($tags){
            $data['tags']=implode(',',$tags);
        }
        else{
            $data['tags']='';
        }
        // return $data;

        $status=Post::create($data);
        if($status){
            request()->session()->flash('Succès','Poste ajouté avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('post.index');
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
        $post=Post::findOrFail($id);
        $categories=PostCategory::get();
        $tags=PostTag::get();
        $users=User::get();
        return view('backend.post.edit')->with('categories',$categories)->with('users',$users)->with('tags',$tags)->with('post',$post);
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
        $post=Post::findOrFail($id);
         // return $request->all();
         $this->validate($request,[
            'title'=>'string|required',
            'quote'=>'string|nullable',
            'summary'=>'string|required',
            'description'=>'string|nullable',
          
            'tags'=>'nullable',
            'added_by'=>'nullable',
            'post_cat_id'=>'required',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        if ($request->photo == null){
            
            $request['photo'] = $post->photo;
         
        }
        elseif($request->photo != null){
            //enregister la photo
            $data=$request->all();

            $file_extension_img=$request->photo->getClientOriginalExtension();
            if($file_extension_img!="png" && $file_extension_img!="jpg" && $file_extension_img!="jpeg" ){
              request()->session()->flash('erreur','Erreur, le fichier doit etre une image');
              return redirect()->route('post.edit',$id);
                 }
                 $file_name = time().".".$file_extension_img;
                 $path='backend/img/poste';
                 $request->photo -> move($path,$file_name);
                 $data['photo']=$file_name;
        }

        $tags=$request->input('tags');
        // return $tags;
        if($tags){
            $data['tags']=implode(',',$tags);
        }
        else{
            $data['tags']='';
        }
        // return $data;

        $status=$post->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Poste modifié avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
       
        $status=$post->delete();
        
        if($status){
            request()->session()->flash('Succès','Poste supprimé avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('post.index');
    }
}
