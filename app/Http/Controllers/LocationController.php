<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CartController;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Livraison;
use App\Models\Location;
use App\User;
use DateTime;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
class LocationController extends Controller
{
    /*
    public function index()
    {

        return view('frontend.pages.location');
    }*/
    public function index()
    {
        $locations=location::orderBy('id','DESC')->paginate(10);
        return view('backend.location.index')->with('locations',$locations);
    }

    public function locationShow($id)

    {

        $order=Location::find($id);

        //die(var_dump($order));
        //return $order;
        return view('user.location.show')->with('order',$order);
    }

    public function locationDelete($id)
    {
        $order=Location::find($id);
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
                return redirect()->route('user.location.index');
           }
        }
        else{
            request()->session()->flash('erreur','Commande introuvable');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    
    {

        

        $this->validate($request,[
            'first_name'=>'string|required',
            'last_name'=>'string|required',
            'address1'=>'string|required',
            'address2'=>'string|nullable',
            'coupon'=>'nullable|numeric',
            'phone'=>'numeric|required',
            'post_code'=>'string|nullable',
            'email'=>'string|required',
            'date_debut'=>'date|required',
            'date_fin'=>'date|required'
        ]);
       
       
            
        $order=new Location();
       
            $dateD = $request->date_debut;
            $dateF = $request->date_fin;
        
            $datetime1 = new DateTime($dateF);
            $datetime2 = new DateTime($dateD);
            $interval = $datetime1->diff($datetime2);
            $days = $interval->format('%a');

        $order->quantite= $request->quantite;  
        $order->date_debut= $request->date_debut;
        $order->date_fin=  $request->date_fin;
        $order->duree= $days;
        
        $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['user_id']=$request->user()->id;
        $order_data['livraison_id']=$request->livraison;
        $livraison=Livraison::where('id',$order_data['livraison_id'])->pluck('price');
        
         $order_data['total_amount']= $request->prix * $days *  $request->quantite;

        // return session('coupon')['value'];
        
        
        // return $order_data['total_amount'];
        $order_data['status']="new";
        if(request('payment_method')=='paypal'){
            $order_data['payment_method']='paypal';
            $order_data['payment_status']='paid';
        }
        else{
            $order_data['payment_method']='cod';
            $order_data['payment_status']='Unpaid';
        }
        $order->fill($order_data);
        $status=$order->save();
        if($order)
        // dd($order->id);
        $users=User::where('role','admin')->first();
        $details=[
            'title'=>'Nouvelle commande crée',
            'actionURL'=>route('order.show',$order->id),
            'fas'=>'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
        
        if(request('payment_method')=='paypal'){
            return redirect()->route('payment')->with(['id'=>$order->id]);
        }
        else{
            session()->forget('cart');
            session()->forget('coupon');
        }
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        // dd($users);
        request()->session()->flash('Succès','Materiel ajouté au panier');
        return redirect()->route('home');
    }

    public function show($id)
    {
        //die(var_dump($id));

        $order=Location::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Location::find($id);
        return view('backend.location.edit')->with('order',$order);
    }

    public function update(Request $request, $id)
    {
        $order=Location::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        $data=$request->all();
        // return $request->status;
       
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('Succès','Commande modifié avec succès');
        }
        else{
            request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
        }
        return redirect()->route('location.index');
    }


    public function destroy($id)
    {
        $order=Location::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('Succès','Commande supprimé avec succès');
            }
            else{
                request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
            }
            return redirect()->route('location.index');
        }
        else{
            request()->session()->flash('erreur','Commande introuvable');
            return redirect()->back();
        }
    }


    public function materielTrackOrder(Request $request){
        // return $request->all();
        $order=Location::where('user_id',auth()->user()->id)->where('order_number',$request->order_number)->first();
        if($order){
            if($order->status=="new"){
            request()->session()->flash('Succès','veuillez patienter');
            return redirect()->route('home');

            }
            elseif($order->status=="process"){
                request()->session()->flash('Succès','Votre commande est en cours de traitement, veuillez patienter.');
                return redirect()->route('home');

            }
            elseif($order->status=="delivered"){
                request()->session()->flash('Succès','Votre commande est livrée avec succès.');
                return redirect()->route('home');

            }
            else{
                request()->session()->flash('erreur','Erreur, veuillez réessayer ultérieurement');
                return redirect()->route('home');

            }
        }
        else{
            request()->session()->flash('erreur','Numero de commande invalide');
            return back();
        }
    }



    public function pdf(Request $request){
        return $request;
        $location=Location::getAllOrder($request->id);
return $location;
        // return $order;
        $file_name=$location->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('backend.location.pdf',compact('location'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
    public function location_form($id,Request $request){

        $id_materiel=$id;
        $quantite=$request->quant[1];
        return view('frontend.pages.location')->with( ['id_materiel' => $id_materiel , 'quantite' => $quantite] ) ;
        

    }

    
}
