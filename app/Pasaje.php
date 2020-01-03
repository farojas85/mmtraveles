<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pasaje extends Model
{
    use SoftDeletes;
    protected $table ='pasaje';

    protected $fillable = ['id','aerolinea_id','counter_id','pasajero','viajecode',
                            'ruta','tipo_viaje','pasaje_total','fare','igv',
                            'monto_neto','tuaa','comision','comision_costamar',
                            'comision_kiu','comision_sabre','pago_soles','pago_dolares',
                            'pago_visa','deposito_soles','deposito_dolares','telefono',
                            'observaciones','not_igv','created_at_venta','created_at'
                            ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'counter_id');
    }

    public function aerolinea()
    {
        return $this->belongsTo(Aerolinea::class, 'aerolinea_id');
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }

    public function etapa_persona()
    {
        return $this->belongsTo(EtapaPersona::class);
    }
}
