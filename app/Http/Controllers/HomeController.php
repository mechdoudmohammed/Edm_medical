<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Order;
use App\Models\Location;
use App\Models\MaterielReview;
use App\Models\PostComment;
use App\Rules\MatchOldPassword;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index(){
        return view('user.index');
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('user.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request,$id){
        
        // return $request->all();
        $user=User::findOrFail($id);
         //enregister la photo
         $file_extension=$request -> photo -> getClientOriginalExtension();
         $file_name = time().".".$file_extension;
         $path='backend/img/utilisateurs';
         $request->photo -> move($path,$file_name);
         
        
        if ($request->photo == null){
            $request['photo'] = $user->photo;
        }
   
        $data=$request->all();
        $data['photo']=$file_name;
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Profile modifié avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->back();
    }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    }

    
    public function locationIndex(){
        $orders=Location::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.location.index')->with('orders',$orders);
    }

    public function userOrderDelete($id)
    {
        $order=Order::find($id);
        if($order){
           if($order->status=="process" || $order->status=='delivered' || $order->status=='cancel'){
                return redirect()->back()->with('erreur','Erreur, veuillez réessayer ultérieurement');
           }
           else{
                $status=$order->delete();
                if($status){
                    request()->session()->flash('Succès','Commande supprimé avec succès');
                }
                else{
                    request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
                }
                return redirect()->route('user.order.index');
           }
        }
        else{
            request()->session()->flash('erreur','Commande introuvable');
            return redirect()->back();
        }
    }

    public function orderShow($id)

    {

        $order=Order::find($id);

        //die(var_dump($order));
        //return $order;
        return view('user.order.show')->with('order',$order);
    }

    public function locationShow($id)

    {

        $order=Location::find($id);

        //die(var_dump($order));
        //return $order;
        return view('backend.location.show')->with('order',$order);
    }
    
    // Materiel Review
    public function materielReviewIndex(){
        $reviews=MaterielReview::getAllUserReview();
        return view('user.review.index')->with('reviews',$reviews);
    }

    public function materielReviewEdit($id)
    {
        $review=MaterielReview::find($id);
        // return $review;
        return view('user.review.edit')->with('review',$review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function materielReviewUpdate(Request $request, $id)
    {
        $review=MaterielReview::find($id);
        if($review){
            $data=$request->all();
            $status=$review->fill($data)->update();
            if($status){
                request()->session()->flash('Succès','Examination modifié avec succès');
            }
            else{
                request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
            }
        }
        else{
            request()->session()->flash('erreur','Examination introuvable!');
        }

        return redirect()->route('user.materielreview.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function materielReviewDelete($id)
    {
        $review=MaterielReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('Succès','examination supprimé avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('user.materielreview.index');
    }

    public function userComment()
    {
        $comments=PostComment::getAllUserComments();
        return view('user.comment.index')->with('comments',$comments);
    }
    public function userCommentDelete($id){
        $comment=PostComment::find($id);
        if($comment){
            $status=$comment->delete();
            if($status){
                request()->session()->flash('Succès','Poste Commantaire supprimé avec succès');
            }
            else{
                request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
            }
            return back();
        }
        else{
            request()->session()->flash('erreur','Poste Commentaire introuvable');
            return redirect()->back();
        }
    }
    public function userCommentEdit($id)
    {
        $comments=PostComment::find($id);
        if($comments){
            return view('user.comment.edit')->with('comment',$comments);
        }
        else{
            request()->session()->flash('erreur','Commentaire introuvable');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userCommentUpdate(Request $request, $id)
    {
        $comment=PostComment::find($id);
        if($comment){
            $data=$request->all();
            // return $data;
            $status=$comment->fill($data)->update();
            if($status){
                request()->session()->flash('Succès','Commentaire modifié avec succès');
            }
            else{
                request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
            }
            return redirect()->route('user.post-comment.index');
        }
        else{
            request()->session()->flash('erreur','Commentaire introuvable');
            return redirect()->back();
        }

    }

    public function changePassword(){
        return view('user.layouts.userPasswordChange');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->route('user')->with('Succès','mot de passe modifié avec succès');
    }


}
