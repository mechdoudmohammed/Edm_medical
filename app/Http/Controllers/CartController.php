<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Materiel;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Helper;
class CartController extends Controller
{
    protected $materiel=null;
    public function __construct(Materiel $materiel){
        $this->materiel=$materiel;
    }

    public function addToCart(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('erreur','Materiel invalide');
            return back();
        }        
        $materiel = Materiel::where('slug', $request->slug)->first();
        // return $materiel;
        if (empty($materiel)) {
            request()->session()->flash('erreur','Materiel invalide');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('materiel_id', $materiel->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $materiel->price+ $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->materiel->stock < $already_cart->quantity || $already_cart->materiel->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->materiel_id = $materiel->id;
            $cart->price = ($materiel->price-($materiel->price*$materiel->discount)/100);
            $cart->quantity = 1;
            $cart->amount=$cart->price*$cart->quantity;
            if ($cart->materiel->stock < $cart->quantity || $cart->materiel->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $cart->save();
            $wishlist=Wishlist::where('user_id',auth()->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);
        }
        request()->session()->flash('Succ??s','Mat??riel ajout?? avec succ??s au panier');
        return back();       
    }  

    public function singleAddToCart(Request $request){
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);


        $materiel = Materiel::where('slug', $request->slug)->first();
        if($materiel->stock <$request->quant[1]){
            return back()->with('erreur','En rupture de stock, vous pouvez ajouter d autres mat??riaux.');
        }
        if ( ($request->quant[1] < 1) || empty($materiel) ) {
            request()->session()->flash('erreur','Materiel invalide');
            return back();
        }    

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('materiel_id', $materiel->id)->first();

        // return $already_cart;

        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($materiel->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($materiel->price * $request->quant[1])+ $already_cart->amount;

            if ($already_cart->materiel->stock < $already_cart->quantity || $already_cart->materiel->stock <= 0) return back()->with('error','Stock not sufficient!.');

            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->materiel_id = $materiel->id;
            $cart->price = ($materiel->price-($materiel->price*$materiel->discount)/100);
            $cart->quantity = $request->quant[1];
            $cart->amount=($materiel->price * $request->quant[1]);
            if ($cart->materiel->stock < $cart->quantity || $cart->materiel->stock <= 0) return back()->with('error','Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('Succ??s','Mat??riel ajout?? avec succ??s au panier');
        return back();       
    } 
    
    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('Succ??s','Panier vid?? avec succ??s ');
            return back();  
        }
        request()->session()->flash('erreur','Erreur, veuillez r??essayer ult??rieurement');
        return back();       
    }     

    public function cartUpdate(Request $request){
        // dd($request->all());
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {
                    // return $quant;

                    if($cart->materiel->stock < $quant){
                        request()->session()->flash('erreur','rupture stock ');
                        return back();
                    }
                    $cart->quantity = ($cart->materiel->stock > $quant) ? $quant  : $cart->materiel->stock;
                    // return $cart;
                    
                    if ($cart->materiel->stock <=0) continue;
                    $after_price=($cart->materiel->price-($cart->materiel->price*$cart->materiel->discount)/100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Panier modifi?? avec succ??s';
                }else{
                    $error[] = 'Panier invalide';
                }
            }
            return back()->with($error)->with('Succ??s', $success);
        }else{
            return back()->with('Panier invalide');
        }    
    }

    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->materiel=$this->materiel->find($request->pro_id);
    //         if($this->materiel->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->materiel){
    //             return response(['status'=>false,'msg'=>'Materiel not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->materiel->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->materiel->title,
    //             'summary'=>$this->materiel->summary,
    //             'link'=>route('materiel-detail',$this->materiel->slug),
    //             'price'=>$this->materiel->price,
    //             'photo'=>$this->materiel->photo,
    //         );
            
    //         $price=$this->materiel->price;
    //         if($this->materiel->discount){
    //             $price=($price-($price*$this->materiel->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order materiels
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->materiel->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'vous devez d'abord vous connecter','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }

    public function checkout(Request $request){
        // $cart=session('cart');
        // $cart_index=\Str::random(10);
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'materiel_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }
        return view('frontend.pages.checkout');
    }
}
