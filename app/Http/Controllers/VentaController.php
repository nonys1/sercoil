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
use App\ObreroCosto;
use Carbon\Carbon;
use Dompdf;

class VentaController extends Controller
{
    public function index(){
    	$ventas=Venta::orderBy('ID_VEN','desc')->join('users','users.ID_USU','=','venta.ID_USU')->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')->get();
    	return view('venta.index')->with('ventas',$ventas);
    }
    public function store(Request $request){
    	if (Cliente::where('CI_CLI',$request->ci_cli)->exists()) {
    		$cliente=Cliente::where('CI_CLI',$request->ci_cli)->first();
    	}else{
    		$cliente=new Cliente;
    		$cliente->CI_CLI=$request->ci_cli;
    		$cliente->EXP_CLI=$request->exp_cli;
    		$cliente->NOM_CLI=$request->nom_cli;
    		$cliente->PAT_CLI=$request->pat_cli;
    		$cliente->MAT_CLI=$request->mat_cli;
    		$cliente->FEC_NAC=$request->fec_nac;
    		$cliente->DIR_CLI=$request->dir_cli;
    		$cliente->TEL_CLI=$request->tel_cli;
    		$cliente->EMAIL_CLI=$request->email_cli;
    		$cliente->save();
    	}
    	$venta=new Venta;
        $venta->COD_VEN=strtoupper(uniqid());
    	$venta->ID_USU=Auth::user()->ID_USU;
    	$venta->FEC_VEN=Carbon::now()->format('Y-m-d');
    	$venta->ID_CLI=$cliente->ID_CLI;
    	$venta->HOR_VEN=Carbon::now()->format('H:i:s');
    	$venta->save();
    	$exito='Los datos para la VENTA se registraron exitosamente';
    	return redirect('/registro/venta/'.$venta->ID_VEN)->with('exito',$exito);
    }
    public function venta($id){
    	$venta=Venta::where('ID_VEN',$id)->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')->first();
    	$productos=Producto::get();
        $detalles=VentaDetalle::where('ID_VEN',$id)->join('producto','producto.ID_PRO','=','venta_detalle.ID_PRO')->orderBy('ID_VD','desc')->get();
    	$cotizaciones=VentaCotizacion::where('ID_VEN',$id)->join('producto','producto.ID_PRO','=','venta_cotizacion.ID_PRO')->get();
        $ubicaciones=Ubicacion::where('ID_VEN',$id)->get();
        $obrero_costos=ObreroCosto::where('ID_VEN',$id)->first();
        $rolName='obrero';
        $obreros=User::whereHas('roles', function($q) use($rolName){
            $q->where('name',$rolName);
        })->get();
        $rolName='chofer';
        $choferes=User::whereHas('roles', function($q) use($rolName){
            $q->where('name',$rolName);
        })->get();
        $rolName='empleado';
        $empleados=User::whereHas('roles', function($q) use($rolName){
            $q->where('name',$rolName);
        })->get();
    	return view('venta.venta')->with('venta',$venta)->with('productos',$productos)->with('detalles',$detalles)->with('cotizaciones',$cotizaciones)->with('ubicaciones',$ubicaciones)->with('obreros',$obreros)->with('empleados',$empleados)->with('choferes',$choferes)->with('obrero_costos',$obrero_costos);
    }

    public function udateVenta(Request $request){
        $venta=VentaDetalle::find($request->id_vd_edit);
        $producto=Producto::find($venta["ID_PRO"]);
        $producto->EXT_PRO=$producto["EXT_PRO"] + $venta["CANT_PRO"] - $request->cant_pro_edit;
        $venta->CANT_PRO=$request->cant_pro_edit;
        $producto->save();
        $venta->save();
        $exito='El producto fue actualizado exitosamente!';
    	return redirect('/registro/venta/'.$venta->ID_VEN)->with('exito',$exito);
    }

    public function eliminarproducto(Request $request){
        $venta=VentaDetalle::find($request->id_vd);
        $producto=Producto::find($venta["ID_PRO"]);
        $producto->EXT_PRO=$producto["EXT_PRO"] + $venta["CANT_PRO"];
        $producto->save();
        $venta->destroy($request->id_vd);
        $exito='El producto fue eliminado exitosamente!';
    	return redirect('/registro/venta/'.$venta->ID_VEN)->with('exito',$exito);
    }

    public function finaliza(Request $request){
        $venta=Venta::find($request->id_ven);
        if (VentaCotizacion::where('ID_VEN',$request->id_ven)->exists()) {
            $venta->EST_VEN=1;
        }else{
            $venta->EST_VEN=3;
        }
        $venta->save();
        $exito='La VENTA se FINALIZO exitosamente!';
        return redirect('registro/venta/'.$request->id_ven)->with('exito',$exito);
    }
    public function recibo($id){
        $venta=Venta::join('users','users.ID_USU','=','venta.ID_USU')->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')->where('ID_VEN',$id)->first();
        $detalles=VentaDetalle::join('producto','producto.ID_PRO','=','venta_detalle.ID_PRO')->where('ID_VEN',$id)->get();
        $cotizaciones=VentaCotizacion::where('ID_VEN',$id)->join('producto','producto.ID_PRO','=','venta_cotizacion.ID_PRO')->get();
        $ubicaciones=Ubicacion::where('ID_VEN',$id)->get();
        $obrero_costos=ObreroCosto::where('ID_VEN',$id)->first();
        $pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.recibo_venta', compact('venta','detalles','ubicaciones','cotizaciones','obrero_costos'));
        return $pdf->stream('Venta-'.time().'.pdf');

    }
    public function chofer(Request $request){
        $chofer=User::find($request->id_usu_ch);
        $hor_ini=$request->hor_ini;
        $hor_fin=$request->hor_fin;
        $fec_env=$request->fec_env;
        $view=view('venta.parcial.horarios_chofer',compact('chofer','hor_ini','hor_fin','fec_env'))->render();
        echo $view;
    }
    public function ubicacion(Request $request){
        $ubicacion=new Ubicacion;
        $ubicacion->ID_VEN=$request->id_ven;
        $ubicacion->LAT_UBI=$request->latitud_new;
        $ubicacion->LON_UBI=$request->longitud_new;
        $ubicacion->UBI_UBI=$request->ubi_ubi;
        $ubicacion->PRE_UBI=$request->pre_ubi;
        $ubicacion->save();

        $venta=Venta::find($request->id_ven);
        $venta->ID_USU_CH=$request->id_usu_ch;
        $venta->HOR_INI=$request->hor_ini;
        $venta->HOR_FIN=$request->hor_fin;
        $venta->save();


        $exito='Se registro la DIRECCION exitosamente!';
        return redirect('registro/venta/'.$request->id_ven)->with('exito',$exito);
    }

    public function empleado(Request $request){
        $venta=Venta::find($request->id_ven);
        $venta->ID_USU_ENC=$request->id_empl;
        $venta->save();
        $exito='Se asigno la venta al EMPLEADO exitosamente!';
        return redirect('registro/venta/'.$request->id_ven)->with('exito',$exito);
    }

}
