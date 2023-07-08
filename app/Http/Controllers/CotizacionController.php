<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Producto;
use App\Cotizacion;
use App\Cliente;
use App\Venta;
use App\VentaDetalle;
use App\VentaCotizacion;
use App\Ubicacion;
use App\User;
use Carbon\Carbon;
use Dompdf;

class CotizacionController extends Controller
{
    public function index(){
        $ventas=Venta::where('venta.ID_USU',Auth::user()->ID_USU)
        ->join('venta_cotizacion','venta_cotizacion.ID_VEN','=','venta.ID_VEN')
        ->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
        ->orderBy('venta.ID_VEN','DESC')
        ->get();
    	return view('cotizacion.index')->with('ventas',$ventas);
    }
    public function calcula(Request $request){
    	$header='<table class="table table-bordered table-striped animated fadeInRight"><tr class="success"><th colspan="4" class="text-center">PLACAS DE UNA SOLA CARA</th></tr><tr class="success"><th>MTS2</th><th>PRECIOS</th><th>RESULTADO</th><th>PLACAS</th></tr>';
    	$body='';
    	$footer='</table>';
    	$placas=Producto::where('NOM_PRO','LIKE','%PLACA DE YESO%')->where('ID_CAT',4)->get();
    	$resultado=0;
        $mts2=$request->base*$request->altura;
        foreach ($placas as $placa) {
          $resultado=$placa->PRE_PRO*$mts2;
          $body.='<tr><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs/u</td><td><b>'.$resultado.' Bs.</b></td><td>'.$placa->NOM_PRO.'</td></tr>';
      }
      $placa_una_cara=$header.$body.$footer;


      $header='<table class="table table-bordered table-striped animated fadeInRight">';
      $body='';
      $footer='</table>';
      $resultado_soleras=round(($request->base/2.40)*2,0);
      $body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILES SOLERAS</td><td width="50%"><b>'.$resultado_soleras.'</b> (Unidades)</td></tr>';
      $resultado_montantes=round((($request->base/0.60)+1)*(($request->altura/2.40)),0);
      $body.='<tr class="danger"><td>CANTIDAD DE PERFILES MONTANTES</td><td><b>'.$resultado_montantes.'</b> (Unidades)</td></tr>';
      $resultado_placas=round(($request->base*$request->altura)/2.88,0);
      $body.='<tr class="danger"><td>CANTIDAD DE PLACAS DE YESO</td><td><b>'.$resultado_placas.'</b> (Unidades)</td></tr>';

      $cantidades=$header.$body.$footer.'<div id="div_botonera" class="text-center animated fadeInRight"><button type="button" data-toggle="modal" data-target="#modalGuarda" class="btn btn-success btn_guarda"><i class="fa fa-save"></i> GUARDAR PROFORMA</button></div>';

      echo $placa_una_cara.$cantidades;
  }
  public function guarda(Request $request){
    if ($request->ajax()) {
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
        $cotizacion=new Cotizacion;
        $cotizacion->ID_USU=Auth::user()->ID_USU;
        $cotizacion->ID_CLI=$cliente->ID_CLI;
        $cotizacion->BASE=$request->base;
        $cotizacion->ALTURA=$request->altura;
        $cotizacion->FEC_COT=Carbon::now()->format('Y-m-d');
        $cotizacion->HOR_COT=Carbon::now()->format('H:i:s');
        $cotizacion->TIP_COT='PARED';
        if($cotizacion->save()){
            return response()->json($cotizacion);
        }else{
            return response()->json('FALSE');
        }

    }
}
public function imprimir($id){
    $cotizacion=Cotizacion::join('cliente','cliente.ID_CLI','=','cotizacion.ID_CLI')->join('users','users.ID_USU','=','cotizacion.ID_USU')->where('ID_COT',$id)->first();
    $pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.cotizacion', compact('cotizacion'));
    return $pdf->stream('COTIZACION-'.time().'.pdf');
}
public function guardado(){

    $guardados=Cotizacion::join('cliente','cliente.ID_CLI','=','cotizacion.ID_CLI')->where('ID_USU',Auth::user()->ID_USU)->where('TIP_COT','PARED')->orderBy('ID_COT','DESC')->get();
    $header='<table class="table table-bordered table-striped table-hover animated fadeInRight"><tr class="info"><th>#</th><th>CLIENTE</th><th>FECHA</th><th>HORA</th><td>ESTADO</th><th>IMPRIMIR</th></tr>';
    $body='';
    $footer='</table>';
    foreach ($guardados as $numero=>$guardado) {
        if ($guardado->EST_COT=='PENDIENTE') {
            $body.='<tr><td>'.($numero+1).'</td><td>'.$guardado->NOM_CLI.' '.$guardado->PAT_CLI.' '.$guardado->MAT_CLI.'</td><td>'.$guardado->FEC_COT.'</td><td>'.$guardado->HOR_COT.'</td><td><span class="label bg-yellow">PENDIENTE</span></td><td><a href="'.url('cotizacion-pdf/'.$guardado->ID_COT).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a><a  href="cotizacion/venta/'.$guardado->ID_COT.'" class="btn btn-danger" title="Registrar Venta"><i class="fa fa-edit"></i></a></td></tr>';
        }else{
            $body.='<tr><td>'.($numero+1).'</td><td>'.$guardado->NOM_CLI.' '.$guardado->PAT_CLI.' '.$guardado->MAT_CLI.'</td><td>'.$guardado->FEC_COT.'</td><td>'.$guardado->HOR_COT.'</td><td><span class="label bg-blue">ASIGNADO</span></td><td><a href="'.url('cotizacion-pdf/'.$guardado->ID_COT).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a></td></tr>';
        }
    }
    echo $header.$body.$footer;

}

function venta($id){
    $cotizacion=Cotizacion::join('cliente','cliente.ID_CLI','=','cotizacion.ID_CLI')->join('users','users.ID_USU','=','cotizacion.ID_USU')->where('ID_COT',$id)->first();
    $venta=Venta::where('ID_COT',$id)->first();
    if (!$venta) {
            //registramos la venta
        $venta=new Venta;
        $venta->COD_VEN=strtoupper(uniqid());
        $venta->ID_USU=Auth::user()->ID_USU;
        $venta->ID_COT=$id;
        $venta->FEC_VEN=Carbon::now()->format('Y-m-d');
        $venta->ID_CLI=$cotizacion->ID_CLI;
        $venta->HOR_VEN=Carbon::now()->format('H:i:s');
        $venta->save();
    }

    $venta=Venta::where('ID_VEN',$venta->ID_VEN)->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')->first();
    $productos=Producto::get();
    $detalles=VentaDetalle::where('ID_VEN',$venta->ID_VEN)->join('producto','producto.ID_PRO','=','venta_detalle.ID_PRO')->orderBy('ID_VD','desc')->get();
    $ubicaciones=Ubicacion::where('ID_VEN',$venta->ID_VEN)->get();
    $rolName='obrero';
    $obreros=User::whereHas('roles', function($q) use($rolName){
        $q->where('name',$rolName);
    })->get();
    return view('cotizacion.venta_cotizacion')->with('venta',$venta)->with('productos',$productos)->with('detalles',$detalles)->with('ubicaciones',$ubicaciones)->with('cotizacion',$cotizacion)->with('obreros',$obreros);
}
public function precio(Request $request){
    if ($request->ajax()) {
        $producto=Producto::find($request->id_pro);
        if ($producto->EXT_PRO<$request->cantidad) {
            return response()->json('INSUFICIENTE');
        }else{
            return response()->json($producto);
        }
    }
}

public function confirma(Request $request){
    if (!$request->id_obr) {
        $error='Debe asignar a un obrero';
        return redirect('cotizacion/venta/'.$request->id_cot)->with('error',$error);
    }
    if (Cotizacion::where('ID_COT',$request->id_cot)->where('EST_COT','ASIGNADO')->exists()) {
        $error='La COTIZACION ya se encuentra asignada a esta venta';
        return redirect('/registro/venta/'.$request->id_ven)->with('error',$error);
    }
    $venta=Venta::find($request->id_ven);
    $venta->ID_USU_ENC=$request->id_obr;
    $venta->save();
    //venta de placas de yeso
    for ($i=0; $i <3 ; $i++) {
        if ($request->input('ch_'.$i)) {
            $vc=new VentaCotizacion;
            $vc->ID_VEN=$request->id_ven;
            $vc->MTS_VC=$request->mts2;
            $dato=explode('|', $request->input('ch_'.$i));
            $vc->ID_PRO=$dato[1];
            $vc->RES_VC=$dato[0];
            $vc->CANT_VC=$request->cant_placa;
            $vc->save();

            $producto=Producto::find($dato[1]);
            $producto->EXT_PRO=$producto->EXT_PRO-$request->cant_placa;
            $producto->save();
        }
    }
    //venta de soleras
    $vc=new VentaCotizacion;
    $vc->ID_VEN=$request->id_ven;
    $vc->MTS_VC=$request->mts2;
    $vc->ID_PRO=4;
    $vc->RES_VC=0;
    $vc->CANT_VC=$request->cantidad_solera * $request->cantidad_seleccionada;
    $vc->save();

    $producto=Producto::find(4);
    $producto->EXT_PRO=$producto->EXT_PRO-$request->cantidad_solera;
    $producto->save();

    //venta de montantes
    $vc=new VentaCotizacion;
    $vc->ID_VEN=$request->id_ven;
    $vc->MTS_VC=$request->mts2;
    $vc->ID_PRO=3;
    $vc->RES_VC=0;
    $vc->CANT_VC=$request->cantidad_montante * $request->cantidad_seleccionada;
    $vc->save();

    $producto=Producto::find(3);
    $producto->EXT_PRO=$producto->EXT_PRO-$request->cantidad_solera;
    $producto->save();

    $cotizacion=Cotizacion::find($request->id_cot);
    $cotizacion->EST_COT='ASIGNADO';
    $cotizacion->save();

    $exito='Los productos se AÑADIERON exitosamente!';
    return redirect('/registro/venta/'.$request->id_ven)->with('exito',$exito);
}


public function seguimiento($id){
    $venta=Venta::where('venta.ID_VEN',$id)
    ->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
    ->join('users','users.ID_USU','=','venta.ID_USU')
    ->join('venta_cotizacion','venta_cotizacion.ID_VEN','=','venta.ID_VEN')
    ->join('producto','producto.ID_PRO','=','venta_cotizacion.ID_PRO')
    ->first();
    $cotizaciones=VentaCotizacion::where('ID_VEN',$id)
    ->join('producto','producto.ID_PRO','=','venta_cotizacion.ID_PRO')
    ->get();
    return view('cotizacion.seguimiento')->with('venta',$venta)->with('cotizaciones',$cotizaciones);
}


public function cotizacion_finaliza(Request $request){
    $venta=Venta::find($request->id_ven);
    $venta->EST_VEN=3;
    $venta->save();
    $exito='El trabajo FINALIZÓ exitosamente!';
    return redirect('cotizacion/seguimiento/'.$request->id_ven)->with('exito',$exito);
}


}
