<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Local extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','nombre','descripcion','empresa_id','lugar_id','estado'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function lugar()
    {
        return $this->belongsTo(Lugar::class);
    }

    public function pasaje()
    {
        return $this->hasMany(Pasaje::class);
    }
}
