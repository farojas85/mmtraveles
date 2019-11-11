<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = "category";

    protected $fillable = ['id','name','description'];

    public function locals()
    {
        return $this->hasMany(Local::class);
    }
}
