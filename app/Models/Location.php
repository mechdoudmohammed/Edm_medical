<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $fillable=['user_id','order_number','sub_total','quantity',/*'delivery_charge',*/'status','total_amount','first_name','last_name','country','post_code','address1','address2','phone','email','payment_method','payment_status','livraison_id','coupon','duree','date_debut','date_fin'];


}
