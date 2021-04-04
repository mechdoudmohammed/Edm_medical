<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable=['user_id','materiel_id','cart_id','price','amount','quantity'];

    public function materiel(){
        return $this->belongsTo(Materiel::class,'materiel_id');
    }
}
