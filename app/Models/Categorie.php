<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable=['title','slug','summary','photo','status','is_parent','parent_id','added_by'];

    public function parent_info(){
        return $this->hasOne('App\Models\Categorie','id','parent_id');
    }
    public static function getAllCategory(){
        return  Categorie::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id){
        return Categorie::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Categorie::where('parent_id',$id)->orderBy('id','ASC')->pluck('title','id');
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Categorie','parent_id','id')->where('status','active');
    }
    public static function getAllParentWithChild(){
        return Categorie::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    public function materiels(){
        return $this->hasMany('App\Models\Materiel','cat_id','id')->where('status','active');
    }
    public function sub_materiels(){
        return $this->hasMany('App\Models\Materiel','child_cat_id','id')->where('status','active');
    }
    public static function getMaterielByCat($slug){
        // dd($slug);
        return Categorie::with('materiels')->where('slug',$slug)->first();
        // return Materiel::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getMaterielBySubCat($slug){
        // return $slug;
        return Categorie::with('sub_materiels')->where('slug',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=Categorie::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
