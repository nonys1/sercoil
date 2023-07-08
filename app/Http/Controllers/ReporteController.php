<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Venta;
use App\User;
use App\VentaDetalle;
use App\VentaCotizacion;
use App\Cliente;
use App\Producto;
use App\Ubicacion;
use App\Ingreso;
use App\IngresoDetalle;
use Carbon\Carbon;
use Dompdf;

class ReporteController extends Controller
{
    public function index(){
    	$clientes=Cliente::get();
    	$productos=Producto::get();
    	return view('reporte.index')->with('clientes',$clientes)->with('productos',$productos);
    }

    public function reporte_fechas(Request $request){
        $ventas=Venta::whereBetween('FEC_VEN',[$request->inicio,$request->final])
        ->join('users','users.ID_USU','=','venta.ID_USU')
        ->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
        ->orderBy('ID_VEN','DESC')->get();
        $view=view('reporte.parcial.fechas',compact('ventas','request'))->render();
        echo $view;
    }
    public function fechas($inicio,$final){
    	$ventas=Venta::whereBetween('FEC_VEN',[$inicio,$final])
    	->join('users','users.ID_USU','=','venta.ID_USU')
    	->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
    	->orderBy('ID_VEN','DESC')->get();
    	$pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.reporte_fechas', compact('ventas','inicio','final'));
        return $pdf->stream('VENTAS-'.time().'.pdf');
    }


    public function reporte_clientes(Request $request){
        $cliente=Cliente::find($request->id_cli);
        $ventas=Venta::where('venta.ID_CLI',$request->id_cli)
        ->join('users','users.ID_USU','=','venta.ID_USU')
        ->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
        ->orderBy('ID_VEN','DESC')->get();
        $view=view('reporte.parcial.clientes',compact('ventas','cliente','request'))->render();
        echo $view;
    }
    public function clientes($id_cli){
    	$cliente=Cliente::find($id_cli);
    	$ventas=Venta::where('venta.ID_CLI',$id_cli)
    	->join('users','users.ID_USU','=','venta.ID_USU')
    	->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
    	->orderBy('ID_VEN','DESC')->get();
    	$pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.reporte_clientes', compact('ventas','cliente'));
        return $pdf->stream('CLIENTE-'.time().'.pdf');
    }

    public function reporte_productos(Request $request){
        $producto=Producto::find($request->id_pro);
        $ventas=VentaDetalle::where('venta_detalle.ID_PRO',$request->id_pro)
        ->join('producto','producto.ID_PRO','=','venta_detalle.ID_PRO')
        ->join('venta','venta.ID_VEN','=','venta_detalle.ID_VEN')
        ->orderBy('ID_VD','DESC')->get();
        $view=view('reporte.parcial.productos',compact('producto','ventas','request'))->render();
        echo $view;
    }
    public function productos($id_pro){
    	$producto=Producto::find($id_pro);
    	$ventas=VentaDetalle::where('venta_detalle.ID_PRO',$id_pro)
    	->join('producto','producto.ID_PRO','=','venta_detalle.ID_PRO')
    	->join('venta','venta.ID_VEN','=','venta_detalle.ID_VEN')
    	->orderBy('ID_VD','DESC')->get();
    	$pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.reporte_productos', compact('ventas','producto'));
        return $pdf->stream('PRODUCTO-'.time().'.pdf');
    }
    public function ingresos($inicio,$final){
    	$ingresos=Ingreso::whereBetween('FEC_ING',[$inicio,$final])
    	->join('users','users.ID_USU','=','ingreso.ID_USU')
    	->join('proveedor','proveedor.ID_PROV','=','ingreso.ID_PROV')
    	->orderBy('ID_ING','DESC')->get();
    	$pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.reporte_ingresos', compact('ingresos','inicio','final'));
        return $pdf->stream('INGRESOS-'.time().'.pdf');
    }
}
