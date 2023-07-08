<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Categoria;
use App\Proveedor;
use App\Ingreso;
use App\IngresoDetalle;
use App\Producto;

class IngresoDetalleController extends Controller
{
    public function store(Request $request){
    	if (IngresoDetalle::where('ID_ING',$request->id_ing)->where('ID_PRO',$request->id_pro)->exists()) {
    		$error='Este producto ya se encuentra registrado en el actual REGISTRO';
    		return redirect('registro/ingreso/'.$request->id_ing)->with('error',$error);
    	}
    	$detalle=new IngresoDetalle;
    	$detalle->ID_ING=$request->id_ing;
    	$detalle->ID_PRO=$request->id_pro;
    	$detalle->CANT_ID=$request->cant_id;
    	$detalle->FEC_PROD=$request->fec_prod;
    	$detalle->FEC_VENC=$request->fec_venc;
    	$detalle->save();
    	
    	$producto=Producto::Find($request->id_pro);
        $producto->EXT_PRO=$producto->EXT_PRO+$request->cant_id;
    	//$producto->PRE_PRO=$request->pre_ven;
    	$producto->save();
    	$exito='El detalle se REGISTRO exitosamente!';
    	return redirect('registro/ingreso/'.$request->id_ing)->with('exito',$exito);
    }
    public function buscaProductos(Request $request){
        $productos=Producto::where('ID_CAT',$request->id_cat)->get();
        $option='<option>-ELIJA UN PRODUCTO-</option>';
        foreach ($productos as $producto) {
            $option.='<option value="'.$producto->ID_PRO.'">'.$producto->NOM_PRO.'</option>';
        }
        echo $option;
    }
}
