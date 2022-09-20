<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Carte extends Model
{
    protected $table = 'carte';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['id', 'nom', 'description', 'image', 'prix', 'type', 'id_categorie'];
}