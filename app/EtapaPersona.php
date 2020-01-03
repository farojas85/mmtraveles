<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EtapaPersona extends Model
{
    protected $table = "etapa_persona";

    protected $fillable = ['id','abreviatura','nombre'];

    public function pasaje()
    {
        return $this->hasMany(Pasaje::class);
    }


}
