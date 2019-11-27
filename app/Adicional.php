<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $fillable = ['id','descripcion'];

    public function OpcionalDetalles()
    {
        return $this->hasMany(OpcionalDetalle::class);
    }
}
