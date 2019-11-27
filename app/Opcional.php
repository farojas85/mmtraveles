<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Opcional extends Model
{
    use SoftDeletes;

    public function OpcionalDetalles()
    {
        return $this->hasMany(OpcionalDetalle::class);
    }
}
