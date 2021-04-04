<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=['user_id','materiel_id','order_id','quantity','amount','price','status'];
    
    // public function materiel(){
    //     return $this->hasOne('App\Models\Materiel','id','materiel_id');
    // }
    // public static function getAllMaterielFromCart(){
    //     return Cart::with('materiel')->where('user_id',auth()->user()->id)->get();
    // }
    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
