<?php

namespace App\Exports;

use App\Pasaje;
use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

class PasajesExport implements  FromView, WithEvents, ShouldAutoSize
{
    private $lugar;
    private $local;
    private $counter;
    private $aerolinea;
    private $fecha_ini;
    private $fecha_fin;
    private $filas;

    public function __construct($request)
    {
        $this->lugar = $request->lugar;
        $this->local = $request->local;
        $this->counter = $request->counter;
        $this->aerolinea = $request->aerolinea;
        $this->fecha_ini = $request->fecha_ini;
        $this->fecha_fin = $request->fecha_fin;
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            AfterSheet::class => [self::class, 'afterSheet']
        ];
    }

    public static function afterSheet(AfterSheet $event){
        //Single Column
        $event->sheet->styleCells(
            'A1:Q1',
            [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '0066FF']
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => 'ffffff'],
                    ],

                ],
                'font' => [
                    'name'      =>  'Cambria',
                    'size'      =>  11,
                    'bold'      =>  true,
                    'color' => ['argb' => 'ffffff'],
                ],
            ]
        );
    }

    public function view(): View
    {
        $pasajes = Pasaje::join('user as u','pasaje.counter_id','=','u.id')
                            ->join('locals as l','u.local_id','=','l.id')
                            ->join('product as ae','pasaje.aerolinea_id','=','ae.id')
                            ->leftJoin('etapa_persona as ep','pasaje.etapa_persona_id','=','ep.id')
                            ->where('l.lugar_id','LIKE',$this->lugar)
                            ->where('l.id','LIKE',$this->local)
                            ->where('u.id','LIKE',$this->counter)
                            ->where('pasaje.aerolinea_id','LIKE',$this->aerolinea)
                            ->whereNull('pasaje.deuda_detalle')
                            ->where('pasaje.created_at_venta','>=',$this->fecha_ini)
                            ->where('pasaje.created_at_venta','<=',$this->fecha_fin)
                            ->select('pasaje.id','u.name as counter','viajecode','ae.name as aero',
                                        'pasaje.ruta',
                                        'pasaje.pasajero','pasaje.tax','pasaje.service_fee','pasaje.ticket_number',
                                        'pasaje.total','pasaje.deposito_soles','pasaje.deposito_dolares',
                                        'ruta','pasaje.tarifa','pago_soles','pago_dolares',
                                        'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at_venta',
                                        'pasaje.deleted_at','ep.nombre as etapa_persona','ep.abreviatura as etapa_mini')
                            ->orderBy('pasaje.created_at','DESC')
                            ->get();
        $asuma = 0;
        $sumatuaa=0;
        $s2= 0;
        $s3=0;
        $s4=0;
        $s5=0;
        $s6=0;
        $s7=0;
        $s8=0;
        $pasa = array();
        $i=1;
        foreach($pasajes as $pa)
        {
            $tempo = array(
                'id' => $i,
                'created_at_venta' => $pa->created_at_venta,
                'counter' => $pa->counter,
                'ticket' => $pa->ticket_number,
                'viajecode' => $pa->viajecode,
                'aero' => $pa->aero,
                'pasajero' => $pa->pasajero,
                'ruta' => $pa->ruta,
                'tarifa' => $pa->tarifa,
                'tax' => $pa->tax,
                'service_fee' => $pa->service_fee,
                'total' => $pa->total,
                'pago_soles' => $pa->pago_soles,
                'pago_dolares' => $pa->pago_dolares,
                'pago_visa' => $pa->visa,
                'deposito_soles' => $pa->deposito_soles,
                'deposito_dolares' => $pa->deposito_dolares
            );
            $asuma = $asuma + $pa->tarifa;
            $sumatuaa  = $sumatuaa +  $pa->tax;
            $s2 +=  $pa->service_fee;
            $s3 +=  $pa->pago_soles;
            $s4 +=  $pa->pago_dolares;
            $s5 +=  $pa->visa;
            $s6 +=  $pa->deposito_soles;
            $s7 +=  $pa->deposito_dolares;
            $s8 += $pa->total;
            array_push($pasa,$tempo);
            $i +=1;
        }

        $tempo = array(
                'id' => $i+1,
                'created_at_venta' => '',
                'counter' => '',
                'ticket' =>'',
                'viajecode' =>'',
                'aero' => '',
                'pasajero' => '',
                'ruta' => 'TOTAL',
                'tarifa' => $asuma,
                'tax' => $sumatuaa,
                'service_fee' => $s2,
                'total' => $s8,
                'pago_soles' => $s3,
                'pago_dolares' => $s4,
                'pago_visa' => $s5,
                'deposito_soles' => $s6,
                'deposito_dolares' => $s7
            );

        array_push($pasa,$tempo);

        $this->filas = count($pasajes) +1;

        return view('Reportes.excel-cajageneral', [
            'pasajes' => $pasa,'pasaje_count' => $this->filas
        ]);
    }
}
