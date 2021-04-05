<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Livreur extends Model
{
    protected $fillable=[ 'nom','prenom','telephone','email','password','description','adresse', 'cin','numero_permis','photo','status','provider','provider_id',];
}
