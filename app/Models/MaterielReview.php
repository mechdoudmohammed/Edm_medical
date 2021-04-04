<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterielReview extends Model
{
    protected $fillable=['user_id','materiel_id','rate','review','status'];

    public function user_info(){
        return $this->hasOne('App\User','id','user_id');
    }

    public static function getAllReview(){
        return MaterielReview::with('user_info')->paginate(10);
    }
    public static function getAllUserReview(){
        return MaterielReview::where('user_id',auth()->user()->id)->with('user_info')->paginate(10);
    }
    
}
