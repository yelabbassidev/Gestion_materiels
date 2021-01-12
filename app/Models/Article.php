<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;
    ///protected $fillable = ['designation','code_stihl','materiel_adequat','category','quantite_stock'];

    public function gestion_entrees(){
        return $this->hasMany(Gestion_entrees::class);
    }

    public function gestion_sorties(){
        return $this->hasMany(Gestion_sorties::class);
    }
}
