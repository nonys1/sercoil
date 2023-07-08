<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Venta;
use App\VentaDetalle;
use App\Cliente;
use App\Producto;
use Carbon\Carbon;

class VentaEliminaController extends Controller
{
    public function destroy(Request $request){
		$venta=VentaDetalle::find($request->id_vendet);
		$venta->destroy($request->id_vendet);
		$exito='El producto fue eliminado exitosamente!';
		return redirect('/registro/venta/'.$request->id_ven)->with('exito',$exito);
    }

}
