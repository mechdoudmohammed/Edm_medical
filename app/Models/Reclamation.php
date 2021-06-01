<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    protected $fillable=['id','type_reclamation','msg_reclamation','id_order','id_user','statut','location'];
}
