<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Categoria;
use App\Proveedor;
use App\Ingreso;
use App\IngresoDetalle;
use App\Producto;

class IngresoController extends Controller
{
    public function index(){
    	$ingresos=Ingreso::orderBy('ID_ING','DESC')->join('users','users.ID_USU','=','ingreso.ID_USU')->join('proveedor','proveedor.ID_PROV','=','ingreso.ID_PROV')->get();
    	$proveedores=Proveedor::orderBy('ID_PROV','DESC')->get();
    	return view('ingreso.index')->with('ingresos',$ingresos)->with('proveedores',$proveedores);
    }
    public function store(Request $request){
    	$ingreso=new Ingreso;
    	$ingreso->ID_USU=Auth::user()->ID_USU;
    	$ingreso->FEC_ING=$request->fec_ing;
    	$ingreso->ID_PROV=$request->id_prov;
    	$ingreso->TIP_COM=$request->tip_com;
    	$ingreso->save();
    	$exito='El nuevo INGRESO se registro exitosamente!';
    	return redirect('/registro/ingreso/'.$ingreso->ID_ING)->with('exito',$exito);
    }
    public function ingreso($id){
    	$categorias=Categoria::get();
    	$ingreso=Ingreso::where('ID_ING',$id)->join('users','users.ID_USU','=','ingreso.ID_USU')->join('proveedor','proveedor.ID_PROV','=','ingreso.ID_PROV')->first();
    	$detalles=IngresoDetalle::where('ID_ING',$id)->join('producto','producto.ID_PRO','=','ingreso_detalle.ID_PRO')->get();
    	return view('ingreso.ingreso')->with('ingreso',$ingreso)->with('categorias',$categorias)->with('detalles',$detalles);
    }
}
