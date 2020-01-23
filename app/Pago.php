<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = ['id','local_id','rubro','fecha','monto_soles','monto_dolares'];
}
