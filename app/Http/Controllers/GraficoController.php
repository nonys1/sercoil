<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class GraficoController extends Controller
{
    public function index()
    {
        return view('grafico.index');
    }

    public function rangoFechas(Request $request)
    {
        if ($request->ajax()) {
            $response = [];
            $categories = [];
            $conteos = [];
            $primerRegistro = \App\Venta::orderBy('FEC_VEN')->first();
            // Obtener la fecha actual
            $fechaActual = Carbon::now();
            switch ($request->type_exp) {
                case 'months':
                    $categories = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Agos", "Sep", "Oct", "Nom", "Dic"];
                    foreach ($categories as $key => $mes) {
                        $conteos[] = \App\Venta::whereMonth('FEC_VEN', $key + 1)->whereYear('FEC_VEN', $request->year)->count();
                    }
                    break;
                case 'weeks':
                    // Obtener la fecha del primer día del año actual
                    $fechaInicioAnio = Carbon::parse('01-01-' . $request->year)->startOfWeek();
                    $fechaInicioAnio = Carbon::parse("$request->year-01-01")->startOfWeek();
                    $fechaUltimaSemana = Carbon::parse("$request->year-12-31")->endOfWeek();
                    // Obtener todas las semanas hasta la fecha actual
                    $fechasSemanales = [];
                    $fechaInicio = $fechaInicioAnio;
                    while ($fechaInicio <= $fechaUltimaSemana) {
                        $fechaFin = $fechaInicio->copy()->endOfWeek();
                        $fechasSemanales[] = [$fechaInicio, $fechaFin];
                        $fechaInicio = $fechaFin->copy()->addDay();
                    }

                    // Realizar las consultas a la base de datos para cada semana y obtener el conteo
                    $conteos = [];
                    $categories = [];
                    foreach ($fechasSemanales as $i => $fechas) {
                        $count = \App\Venta::whereBetween('FEC_VEN', $fechas)->count();
                        $conteos[] = $count;
                        $categories[] = "sem " . ($i + 1);
                    }

                    break;
                case 'days':
                    $fechaInicio = Carbon::create($request->year, 1, 1);
                    $fechaFin = Carbon::create($request->year, 12, 31);

                    $fechas = [];
                    while ($fechaInicio <= $fechaFin) {
                        $fechas[] = $fechaInicio->toDateString();
                        $fechaInicio->addDay();
                    }
                    foreach ($fechas as $fecha) {
                        $count = \App\Venta::whereDate('FEC_VEN', $fecha)->count();
                        $conteos[] = $count;
                        $categories[] = $fecha;
                    }

                    break;
                default:
                    break;
            }
            $response["categories"] = $categories;
            $response["conteos"] = $conteos;
            return response()->json($response);
        }
    }

    public function rangoGrafic2(Request $request)
    {
        $response = [];
        $categories = [];
        $conteos = [];
        $productos = [];
        if ($request->type_exp == "years" || $request->type_exp == "") {
            $productos = \App\Producto::orderBy('ID_PRO', 'ASC')->get();
            foreach ($productos as $producto) {
                $categories[] = $producto->NOM_PRO;
                if (\App\VentaCotizacion::where('ID_PRO', $producto->ID_PRO)->exists()) {
                    $n_ventas = 0;
                    $n_dato1 = \App\VentaCotizacion::where('ID_PRO', $producto->ID_PRO)->sum('CANT_VC');
                    $n_dato2 = \App\VentaDetalle::where('ID_PRO', $producto->ID_PRO)->sum('CANT_PRO');
                    $n_ventas = $n_dato1 + $n_dato2;
                    $conteos[] = $n_ventas;
                } else {
                    $n_ventas = \App\VentaDetalle::where('ID_PRO', $producto->ID_PRO)->sum('CANT_PRO');
                    $conteos[] = $n_ventas;
                }
            }
        } else {
            $productos = \App\Producto::orderBy('ID_PRO', 'ASC')->get();
            foreach ($productos as $producto) {
                $categories[] = $producto->NOM_PRO;
                if (\App\VentaCotizacion::where('ID_PRO', $producto->ID_PRO)->whereYear('created_at', $request->year)->exists()) {
                    $n_ventas = 0;
                    $n_dato1 = \App\VentaCotizacion::where('ID_PRO', $producto->ID_PRO)->whereYear('created_at', $request->year)->sum('CANT_VC');
                    $n_dato2 = \App\VentaDetalle::where('ID_PRO', $producto->ID_PRO)->whereYear('created_at', $request->year)->sum('CANT_PRO');
                    $n_ventas = intval($n_dato1) + intval($n_dato2);
                    $conteos[] = intval($n_ventas);
                } else {
                    $n_ventas = \App\VentaDetalle::where('ID_PRO', $producto->ID_PRO)->whereYear('created_at', $request->year)->sum('CANT_PRO');
                    $conteos[] = intval($n_ventas);
                }
            }
        }
        $response["categories"] = $categories;
        $response["conteos"] = $conteos;
        return response()->json($response);
    }

    public function rangoGrafic3(Request $request)
    {
        $response = [];
        $conteo = [];
        $cotizaciones = [];
        if ($request->type_exp == "years" || $request->type_exp == "") {
            $cotizaciones=\App\Cotizacion::groupBy('TIP_COT')->get();
            foreach($cotizaciones as $cot) {
                $numero=\App\Cotizacion::where('TIP_COT',$cot->TIP_COT)->count();
                switch ($cot->TIP_COT) {
                    case 'PARED':
                      $nombre='PARED DRYWALL';
                      break;
                    case 'CIELO':
                      $nombre='CIELO ACUSTICO';
                      break;
                    case 'PISO':
                      $nombre='PISO FLOTANTE';
                      break;
                     case 'PERSONAL':
                      $nombre='PERSONALIZADA';
                      break;
                }
                $conteo[] = ["name"=>$nombre,
                             "y"=>$numero];

            }
        } else {
            $cotizaciones=\App\Cotizacion::whereYear('created_at', $request->year)->groupBy('TIP_COT')->get();
            foreach($cotizaciones as $cot) {
                $numero=\App\Cotizacion::where('TIP_COT',$cot->TIP_COT)->count();
                switch ($cot->TIP_COT) {
                    case 'PARED':
                      $nombre='PARED DRYWALL';
                      break;
                    case 'CIELO':
                      $nombre='CIELO ACUSTICO';
                      break;
                    case 'PISO':
                      $nombre='PISO FLOTANTE';
                      break;
                     case 'PERSONAL':
                      $nombre='PERSONALIZADA';
                      break;
                }
                $conteo[] = ["name"=>$nombre,
                             "y"=>$numero];
            }
        }
        $response = $conteo;
        return response()->json($response);
    }

}
