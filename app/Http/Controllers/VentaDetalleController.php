<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Venta;
use App\VentaDetalle;
use App\Cliente;
use App\Producto;
use Carbon\Carbon;

class VentaDetalleController extends Controller
{
    public function store(Request $request){
    	$detalle=new VentaDetalle;
    	$detalle->ID_VEN=$request->id_ven;
    	$detalle->ID_PRO=$request->id_pro;
    	$detalle->PRE_UNI=$request->pre_uni;
    	$detalle->CANT_PRO=$request->cant_pro;
    	$detalle->TOT_VEN=$request->cant_pro*$request->pre_uni;
    	$detalle->save();

    	$producto=Producto::Find($request->id_pro);
    	$producto->EXT_PRO=$producto->EXT_PRO-$request->cant_pro;
    	$producto->save();
    	$exito='Se añadio el producto exitosamente';

    	return redirect('/registro/venta/'.$request->id_ven)->with('exito',$exito);
    }

}
