<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Materiel;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    protected $materiel=null;
    public function __construct(Materiel $materiel){
        $this->materiel=$materiel;
    }

    public function wishlist(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Materiels');
            return back();
        }        
        $materiel = Materiel::where('slug', $request->slug)->first();
        // return $materiel;
        if (empty($materiel)) {
            request()->session()->flash('error','Invalid Materiels');
            return back();
        }

        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('materiel_id', $materiel->id)->first();
        // return $already_wishlist;
        if($already_wishlist) {
            request()->session()->flash('error','You already placed in wishlist');
            return back();
        }else{
            
            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->materiel_id = $materiel->id;
            $wishlist->price = ($materiel->price-($materiel->price*$materiel->discount)/100);
            $wishlist->quantity = 1;
            $wishlist->amount=$wishlist->price*$wishlist->quantity;
            if ($wishlist->materiel->stock < $wishlist->quantity || $wishlist->materiel->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $wishlist->save();
        }
        request()->session()->flash('success','Materiel successfully added to wishlist');
        return back();       
    }  
    
    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            request()->session()->flash('success','Wishlist successfully removed');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     
}
