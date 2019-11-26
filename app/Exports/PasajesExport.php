<?php

namespace App\Exports;

use App\Pasaje;
use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Session;

class PasajesExport implements FromArray, WithHeadings,WithColumnFormatting
{
    protected $datos;
    
    public function __construct(array $datos)
    {
        $this->datos = $datos;
        Session::forget('pasajes');
    }

    public function array(): array
    {
        return $this->datos;
    }

    public function headings() : array
    {
        return [
            'ID',
            'COUNTER',
            'TICKET',
            'CODIGO',
            'AEROLINEA',
            'PASAJERO',
            'RUTA',
            'TARIFA',
            'TAX/TUAA',
            'SERVICE_FEE',
            'TOTAL',
            'PAGO_SOLES',
            'PAGO_DOLARES',
            'PAGO_VISA',
            'DEPOSITO_SOLES',
            'DEPOSITO_DOLARES',
            'FECHA'

        ];
    }
    
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
    /*public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(
                    array(
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' =>Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                                ]
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                        'font' => array(
                            'name' => 'Calibri',
                            'size' => 12,
                            'color' => array('rgb' => 'FFFFFF')
                        ),
                    )
                );
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()
                                        ->setFillType(Fill::FILL_SOLID)
                                        ->getStartColor()->setRGB('0489B1');
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
            },
        ];
    }*/
    // public function collection()
    // {
    //     $user = User::with('roles')->where('id',Auth::user()->id)->first();
    //     $role_name ='';
    //     foreach($user->roles as $role)
    //     {
    //         $role_name = $role->name;
    //     }
    //      $condicion ='';
    //     if($role_name == 'Responsable' || $role_name == 'Gerente' || $role_name == 'Administrador'){
    //         $condicion = '%';
    //     }
    //     else {
    //         $lugar = Lugar::join('user_category as uc','category.id','=','uc.category_id')
    //                         ->where('user_id',Auth::user()->id)
    //                         ->select('category.id','category.description')
    //                         ->get();

    //         foreach($lugar as $lu){
    //             $condicion = '%'.$lu->description.'%';
    //         }
    //     }

    //     // return Pasaje::join('user as u','pasaje.counter_id','=','u.id')
    //     //             ->join('aerolinea as ae','pasaje.aerolinea_id','=','ae.id')
    //     //             ->where('ruta','LIKE',$condicion)
    //     //             ->select('pasaje.id','u.name','viajecode','ae.name',
    //     //                         'ruta','pasaje.pasaje_total','pago_soles','pago_dolares',
    //     //                         'pago_visa','deposito_soles','deposito_dolares','pasaje.created_at')
    //     //             ->orderBy('pasaje.created_at','DESC')
    //     //             ->get();
    //     return Pasaje::all();
    // }
}
