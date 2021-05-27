<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Materiel;
use App\Models\Categorie;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Cart;
use App\Models\Fournisseur;
use App\User;
use Auth;
use Session;
use Newsletter;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class FrontendController extends Controller
{
   
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }

    public function home(){
        $featured=Materiel::where('status','active')->where('is_featured',1)->orderBy('price','DESC')->limit(2)->get();
        $posts=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $banners=Banner::where('status','active')->limit(3)->orderBy('id','DESC')->get();
        // return $banner;
        $materiels=Materiel::where('status','active')->orderBy('id','DESC')->limit(8)->get();
        $categorie=Categorie::where('status','active')->where('is_parent',1)->orderBy('title','ASC')->get();
        // return $categorie;
        return view('frontend.index')
                ->with('featured',$featured)
                ->with('posts',$posts)
                ->with('banners',$banners)
                ->with('materiel_lists',$materiels)
                ->with('category_lists',$categorie);
    }   

    public function aboutUs(){
        return view('frontend.pages.about-us');
    }

    public function contact(){
        return view('frontend.pages.contact');
    }

    public function materielDetail($slug){
        $materiel_detail= Materiel::getMaterielBySlug($slug);
        // dd($materiel_detail);
        return view('frontend.pages.materiel_detail')->with('materiel_detail',$materiel_detail);
    }

    public function materielGrids(){
        $materiels=Materiel::query();
        
        if(!empty($_GET['categorie'])){
            $slug=explode(',',$_GET['categorie']);
            // dd($slug);
            $cat_ids=Categorie::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $materiels->whereIn('cat_id',$cat_ids);
            // return $materiels;
        }
        if(!empty($_GET['fournisseur'])){
            $slugs=explode(',',$_GET['fournisseur']);
            $fournisseur_ids=Fournisseur::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            return $fournisseur_ids;
            $materiels->whereIn('fournisseur_id',$fournisseur_ids);
        }
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $materiels=$materiels->where('status','active')->orderBy('title','ASC');
            }
            if($_GET['sortBy']=='price'){
                $materiels=$materiels->orderBy('price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
            
            $materiels->whereBetween('price',$price);
        }

        $recent_materiels=Materiel::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // Sort by number
        if(!empty($_GET['show'])){
            $materiels=$materiels->where('status','active')->paginate($_GET['show']);
        }
        else{
            $materiels=$materiels->where('status','active')->paginate(9);
        }
        // Sort by name , price, categorie

      
        return view('frontend.pages.materiel-grids')->with('materiels',$materiels)->with('recent_materiels',$recent_materiels);
    }
    public function materielLists(){
        $materiels=Materiel::query();
        
        if(!empty($_GET['categorie'])){
            $slug=explode(',',$_GET['categorie']);
            // dd($slug);
            $cat_ids=Categorie::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $materiels->whereIn('cat_id',$cat_ids)->paginate;
            // return $materiels;
        }
        if(!empty($_GET['fournisseur'])){
            $slugs=explode(',',$_GET['fournisseur']);
            $fournisseur_ids=Fournisseur::select('id')->whereIn('slug',$slugs)->pluck('id')->toArray();
            return $fournisseur_ids;
            $materiels->whereIn('fournisseur_id',$fournisseur_ids);
        }
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $materiels=$materiels->where('status','active')->orderBy('title','ASC');
            }
            if($_GET['sortBy']=='price'){
                $materiels=$materiels->orderBy('price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));
            
            $materiels->whereBetween('price',$price);
        }

        $recent_materiels=Materiel::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // Sort by number
        if(!empty($_GET['show'])){
            $materiels=$materiels->where('status','active')->paginate($_GET['show']);
        }
        else{
            $materiels=$materiels->where('status','active')->paginate(6);
        }
        // Sort by name , price, categorie

      
        return view('frontend.pages.materiel-lists')->with('materiels',$materiels)->with('recent_materiels',$recent_materiels);
    }
    public function materielFilter(Request $request){
            $data= $request->all();
            // return $data;
            $showURL="";
            if(!empty($data['show'])){
                $showURL .='&show='.$data['show'];
            }

            $sortByURL='';
            if(!empty($data['sortBy'])){
                $sortByURL .='&sortBy='.$data['sortBy'];
            }

            $catURL="";
            if(!empty($data['categorie'])){
                foreach($data['categorie'] as $categorie){
                    if(empty($catURL)){
                        $catURL .='&categorie='.$categorie;
                    }
                    else{
                        $catURL .=','.$categorie;
                    }
                }
            }

            $fournisseurURL="";
            if(!empty($data['fournisseur'])){
                foreach($data['fournisseur'] as $fournisseur){
                    if(empty($fournisseurURL)){
                        $fournisseurURL .='&fournisseur='.$fournisseur;
                    }
                    else{
                        $fournisseurURL .=','.$fournisseur;
                    }
                }
            }
            // return $fournisseurURL;

            $priceRangeURL="";
            if(!empty($data['price_range'])){
                $priceRangeURL .='&price='.$data['price_range'];
            }
            if(request()->is('e-shop.loc/materiel-grids')){
                return redirect()->route('materiel-grids',$catURL.$fournisseurURL.$priceRangeURL.$showURL.$sortByURL);
            }
            else{
                return redirect()->route('materiel-lists',$catURL.$fournisseurURL.$priceRangeURL.$showURL.$sortByURL);
            }
    }
    public function materielSearch(Request $request){
        $recent_materiels=Materiel::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $materiels=Materiel::orwhere('nom','like','%'.$request->search.'%')
                    ->orwhere('slug','like','%'.$request->search.'%')
                    ->orwhere('description','like','%'.$request->search.'%')
                    ->orwhere('summary','like','%'.$request->search.'%')
                    ->orwhere('price','like','%'.$request->search.'%')
                    ->orderBy('id','DESC')
                    ->paginate('9');
        return view('frontend.pages.materiel-grids')->with('materiels',$materiels)->with('recent_materiels',$recent_materiels);
    }

    public function materielFournisseur(Request $request){
        $materiels=Fournisseur::getMaterielByFournisseur($request->slug);
        $recent_materiels=Materiel::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        if(request()->is('e-shop.loc/materiel-grids')){
            return view('frontend.pages.materiel-grids')->with('materiels',$materiels->materiels)->with('recent_materiels',$recent_materiels);
        }
        else{
            return view('frontend.pages.materiel-lists')->with('materiels',$materiels->materiels)->with('recent_materiels',$recent_materiels);
        }

    }
    public function materielCat(Request $request){
        $materiels=Categorie::getMaterielByCat($request->slug);
        // return $request->slug;
        $recent_materiels=Materiel::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        if(request()->is('e-shop.loc/materiel-grids')){
            return view('frontend.pages.materiel-grids')->with('materiels',$materiels->materiels)->with('recent_materiels',$recent_materiels);
        }
        else{
            return view('frontend.pages.materiel-lists')->with('materiels',$materiels->materiels)->with('recent_materiels',$recent_materiels);
        }

    }
    public function materielSubCat(Request $request){
        $materiels=Categorie::getMaterielBySubCat($request->sub_slug);
        // return $materiels;
        $recent_materiels=Materiel::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        if(request()->is('e-shop.loc/materiel-grids')){
            return view('frontend.pages.materiel-grids')->with('materiels',$materiels->sub_materiels)->with('recent_materiels',$recent_materiels);
        }
        else{
            return view('frontend.pages.materiel-lists')->with('materiels',$materiels->sub_materiels)->with('recent_materiels',$recent_materiels);
        }

    }

    public function blog(){
        $post=Post::query();
        
        if(!empty($_GET['categorie'])){
            $slug=explode(',',$_GET['categorie']);
            // dd($slug);
            $cat_ids=PostCategory::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id',$cat_ids);
            // return $post;
        }
        if(!empty($_GET['tag'])){
            $slug=explode(',',$_GET['tag']);
            // dd($slug);
            $tag_ids=PostTag::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id',$tag_ids);
            // return $post;
        }

        if(!empty($_GET['show'])){
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate($_GET['show']);
        }
        else{
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogDetail($slug){
        $post=Post::getPostBySlug($slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogSearch(Request $request){
        // return $request->all();
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $posts=Post::orwhere('title','like','%'.$request->search.'%')
            ->orwhere('quote','like','%'.$request->search.'%')
            ->orwhere('summary','like','%'.$request->search.'%')
            ->orwhere('description','like','%'.$request->search.'%')
            ->orwhere('slug','like','%'.$request->search.'%')
            ->orderBy('id','DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts',$posts)->with('recent_posts',$rcnt_post);
    }

    public function blogFilter(Request $request){
        $data=$request->all();
        // return $data;
        $catURL="";
        if(!empty($data['categorie'])){
            foreach($data['categorie'] as $categorie){
                if(empty($catURL)){
                    $catURL .='&categorie='.$categorie;
                }
                else{
                    $catURL .=','.$categorie;
                }
            }
        }

        $tagURL="";
        if(!empty($data['tag'])){
            foreach($data['tag'] as $tag){
                if(empty($tagURL)){
                    $tagURL .='&tag='.$tag;
                }
                else{
                    $tagURL .=','.$tag;
                }
            }
        }
        // return $tagURL;
            // return $catURL;
        return redirect()->route('blog',$catURL.$tagURL);
    }

    public function blogByCategory(Request $request){
        $post=PostCategory::getBlogByCategory($request->slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post->post)->with('recent_posts',$rcnt_post);
    }

    public function blogByTag(Request $request){
        // dd($request->slug);
        $post=Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data= $request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>'active'])){
            Session::put('user',$data['email']);
            request()->session()->flash('Succès','Successfully login');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('erreur','Email ou mot de passe invalide ,veuillez réessayer ultérieurement');
            return redirect()->back();
        }
    }

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('Succès','Déconnecté');
        return back();
    }

    public function register(){
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request){
        // return $request->all();
        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email'=>'string|required|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);
        $data=$request->all();
        // dd($data);
        $check=$this->create($data);
        Session::put('user',$data['email']);
        if($check){
            request()->session()->flash('Succès','Inscription avec succès,Veuillez-vous se connecter');
            return redirect()->route('register.form');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
            return back();
        }
    }
    public function create(array $data){
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
            'status'=>'active'
            ]);
    }
    // Reset password
    public function showResetForm(){
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request){
        if(! Newsletter::isSubscribed($request->email)){
                Newsletter::subscribePending($request->email);
                if(Newsletter::lastActionSucceeded()){
                    request()->session()->flash('Succès','inscrit , Verifiez votre email !');
                    return redirect()->route('home');
                }
                else{
                    Newsletter::getLastError();
                    return back()->with('erreur','Erreur, veuillez réessayer ultérieurement');
                }
            }
            else{
                request()->session()->flash('erreur','deja inscrit');
                return back();
            }
    }
    
}
