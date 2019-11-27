<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aerolinea extends Model
{
    protected $table = "product";

    protected $fillable = ['id','name','description','costamar','kiu','sabre'];

    public function pasajes()
    {
        return $this->hasMany('App\Pasaje', 'aerolinea_id', 'id');
    }
}
