<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperacionTipo extends Model
{
    protected $table = "operation_type";

    public function extras()
    {
        return $this->hasMany(Extra::class);
    }
}
