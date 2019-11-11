<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $fillable=['id','razon_social','nombre_comercial','ruc','direccion','estado'];

    public function locals()
    {
        return $this->hasMany(Local::class);
    }
}
