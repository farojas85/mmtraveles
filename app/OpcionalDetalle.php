<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpcionalDetalle extends Model
{
    public function Opcional()
    {
        return $this->belongsTo(Opcional::class);
    }

    public function Adicional()
    {
        return $this->belongsTo(Adicional::class);
    }
}
