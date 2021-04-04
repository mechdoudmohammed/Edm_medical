<?php

namespace App\Models;
use App\Models\Materiel;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable=['nom','telephone','email','adresse','description','status'];

    // public static function getMaterielByFournisseur($id){
    //     return Materiel::where('fournisseur_id',$id)->paginate(10);
    // }
    public function materiels(){
        return $this->hasMany('App\Models\Materiel','fournisseur_id','id')->where('status','active');
    }
    public static function getMaterielByFournisseur($slug){
        // dd($slug);
        return Fournisseur::with('materiels')->where('slug',$slug)->first();
        // return Materiel::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
}
