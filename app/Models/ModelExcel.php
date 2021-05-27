<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ModelExcel extends Model
{
    protected $table='model_excel';
    protected $fillable=['id','titre','fichier'];
}
