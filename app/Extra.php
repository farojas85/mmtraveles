<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{

    public function OperacionTipo()
    {
        return $this->belongsTo(OperacionTipo::class);
    }
}
