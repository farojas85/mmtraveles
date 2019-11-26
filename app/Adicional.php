<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $fillable = ['id','descripcion'];

    public function pasaje_adicionals()
    {
        return $this->hasMany(PasajeAdicional::class);
    }
}
