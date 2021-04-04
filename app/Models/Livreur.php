<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Livreur extends Model
{
    protected $fillable=[ 'nom','prenom','cin','description','adresse','numero_permis','email', 'password','role','photo','status','provider','provider_id',];
}
