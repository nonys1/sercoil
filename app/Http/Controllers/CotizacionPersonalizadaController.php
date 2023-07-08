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
use App\ObreroCosto;
use App\Ubicacion;
use App\User;
use Carbon\Carbon;
use Dompdf;

class CotizacionPersonalizadaController extends Controller
{
	public function index(){
		$ventas=Venta::where('ID_USU',Auth::user()->ID_USU)
		->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
		->orderBy('ID_VEN','DESC')
		->get();
		return view('cotizacion_personal.index')->with('ventas',$ventas);
	}
	public function calcula(Request $request){
		$mts2=$request->base*$request->altura;
		$header='<table class="table table-bordered table-striped animated fadeInRight"><tr class="danger"><th colspan="5" class="text-center">COTIZACION PERSONALIZADA</th></tr><tr class="danger"><th>MTS2</th><th>PRECIO UNIDAD</th><th>CANTIDAD</th><th>PRODUCTO</th><th>SUBTOTAL</th></tr>';
		$body='';
		$footer='</table>';
		// *******************  INICIO PARED DRYWALL ***************************
		$resultado_soleras=round(($request->base/2.40)*2,0);
		$query_solera=\App\Producto::where('ID_PRO',4)->where('EXT_PRO','>=',$resultado_soleras)->first();
		$body.='<tr class="success"><td>'.$mts2.' /mts2</td><td>'.$query_solera->PRE_PRO.' Bs.</td><td><b>'.$resultado_soleras.'</b> (Unidades)</td><td>PERFILES '.$query_solera->NOM_PRO.'</td><td>'.$resultado_soleras*$query_solera->PRE_PRO.' Bs.</td></tr>';

		$resultado_montantes=round((($request->base/0.60)+1)*(($request->altura/2.40)),0);
		$query_montante=\App\Producto::where('ID_PRO',3)->where('EXT_PRO','>=',$resultado_montantes)->first();
		$body.='<tr class="success"><td>'.$mts2.' /mts2</td><td>'.$query_montante->PRE_PRO.' Bs.</td><td><b>'.$resultado_montantes.'</b> (Unidades)</td><td>PERFILES '.$query_montante->NOM_PRO.'</td><td>'.$resultado_montantes*$query_montante->PRE_PRO.' Bs.</td></tr>';
		$resultado_placas=round(($request->base*$request->altura)/2.88,0);

		$placas=Producto::where('NOM_PRO','LIKE','%PLACA DE YESO%')->where('ID_CAT',4)->get();
		foreach ($placas as $placa) {
			$resultado_placas=round(($request->base*$request->altura)/2.88,0);
			$body.='<tr class="success"><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs</td><td><b>'.$resultado_placas.'</b> (Unidades)</td><td>'.$placa->NOM_PRO.'</td><td>'.$resultado_placas*$placa->PRE_PRO.' Bs.</td></tr>';
		}
		// *******************  FIN PARED DRYWALL ***************************
		// *******************  INICIO CIELO FALSO ***************************
		$resultado_perimetral_3mts=round((($request->altura/3)+($request->base/3))*2);
		$query_perimetral_3mts=\App\Producto::where('ID_PRO',23)->where('EXT_PRO','>=',$resultado_perimetral_3mts)->first();
		$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_perimetral_3mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_perimetral_3mts.'</b> (Unidades)</td><td>PERFILES '.$query_perimetral_3mts->NOM_PRO.'</td><td>'.$resultado_perimetral_3mts*$query_perimetral_3mts->PRE_PRO.' Bs.</td></tr>';

		$resultado_central_3_66mts=round((($request->base/1.22)-1)*($request->altura/3.66));
		$query_central_3_66mts=\App\Producto::where('ID_PRO',24)->where('EXT_PRO','>=',$resultado_central_3_66mts)->first();
		$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_central_3_66mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_central_3_66mts.'</b> (Unidades)</td><td>PERFILES '.$query_central_3_66mts->NOM_PRO.'</td><td>'.$resultado_central_3_66mts*$query_central_3_66mts->PRE_PRO.' Bs.</td></tr>';

		$resultado_transversal_1_22mts=round(($request->base/1.22)*(($request->altura/0.61)-1));
		$query_transversal_1_22mts=\App\Producto::where('ID_PRO',25)->where('EXT_PRO','>=',$resultado_transversal_1_22mts)->first();
		$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_transversal_1_22mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_1_22mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_1_22mts->NOM_PRO.'</td><td>'.$resultado_transversal_1_22mts*$query_transversal_1_22mts->PRE_PRO.' Bs.</td></tr>';

		$resultado_transversal_0_61mts=round(($request->base/1.22)*($request->altura/0.61));
		$query_transversal_0_61mts=\App\Producto::where('ID_PRO',26)->where('EXT_PRO','>=',$resultado_transversal_0_61mts)->first();
		$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_transversal_0_61mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_0_61mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_0_61mts->NOM_PRO.'</td><td>'.$resultado_transversal_0_61mts*$query_transversal_0_61mts->PRE_PRO.' Bs.</td></tr>';

		$paneles=\App\Producto::where('ID_TIP',2)->get();// CIELO ACUSTICO;
		foreach ($paneles as $panel) {
			$resultado_panel=round(($request->base*$request->altura)/0.3721);
			$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$panel->PRE_PRO.' Bs</td><td><b>'.$resultado_panel.'</b> (Unidades)</td><td>'.$panel->NOM_PRO.'</td><td>'.$resultado_panel*$panel->PRE_PRO.' Bs.</td></tr>';
		}
		// *******************  FIN CIELO FALSO ***************************
		// *******************  INICIO PISO FLOTANTE ***************************
		$resultado_membrana_telgopor=round(($request->altura*$request->base)/24);
		$query_membrana_telgopor=\App\Producto::where('ID_PRO',31)->where('EXT_PRO','>=',$resultado_membrana_telgopor)->first();
		$body.='<tr class="info"><td>'.$mts2.' /mts2</td><td>'.$query_membrana_telgopor->PRE_PRO.' Bs.</td><td><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td><td>PERFILES '.$query_membrana_telgopor->NOM_PRO.'</td><td>'.$resultado_membrana_telgopor*$query_membrana_telgopor->PRE_PRO.' Bs.</td></tr>';

		$pisos=Producto::where('ID_TIP',3)->get();// PISO FLOTANTE
		foreach ($pisos as $piso) {
			$resultado_piso=round(($request->altura*$request->base)/0.24);
			$body.='<tr class="info"><td>'.$mts2.' /mts2</td><td>'.$piso->PRE_PRO.' Bs</td><td><b>'.$resultado_piso.'</b> (Unidades)</td><td>'.$piso->NOM_PRO.'</td><td>'.$resultado_piso*$piso->PRE_PRO.' Bs.</td></tr>';
		}
		// *******************  FIN PISO FLOTANTE ***************************


		$cantidades=$header.$body.$footer.'<div id="div_botonera" class="text-center animated fadeInRight"><button type="button" data-toggle="modal" data-target="#modalGuarda" class="btn btn-success btn_guarda"><i class="fa fa-save"></i> GUARDAR PROFORMA</button></div>';

		echo $cantidades;
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
			$cotizacion->TIP_COT='PERSONAL';
			if($cotizacion->save()){
				return response()->json($cotizacion);
			}else{
				return response()->json('FALSE');
			}

		}
	}
	public function imprimir($id){
		$cotizacion=Cotizacion::join('cliente','cliente.ID_CLI','=','cotizacion.ID_CLI')->join('users','users.ID_USU','=','cotizacion.ID_USU')->where('ID_COT',$id)->first();
		$pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.cotizacion_personal', compact('cotizacion'));
		return $pdf->stream('COTIZACION-PERSONALIZADA '.time().'.pdf');
	}
	public function guardado(){

		$guardados=Cotizacion::join('cliente','cliente.ID_CLI','=','cotizacion.ID_CLI')->where('ID_USU',Auth::user()->ID_USU)->where('TIP_COT','PERSONAL')->orderBy('ID_COT','DESC')->get();
		$header='<table class="table table-bordered table-striped table-hover animated fadeInRight"><tr class="info"><th>#</th><th>CLIENTE</th><th>FECHA</th><th>HORA</th><td>ESTADO</th><th>IMPRIMIR</th></tr>';
		$body='';
		$footer='</table>';
		foreach ($guardados as $numero=>$guardado) {
			if ($guardado->EST_COT=='PENDIENTE') {
				$body.='<tr><td>'.($numero+1).'</td><td>'.$guardado->NOM_CLI.' '.$guardado->PAT_CLI.' '.$guardado->MAT_CLI.'</td><td>'.$guardado->FEC_COT.'</td><td>'.$guardado->HOR_COT.'</td><td><span class="label bg-yellow">PENDIENTE</span></td><td><a href="'.url('cotizacion_personal-pdf/'.$guardado->ID_COT).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a><a  href="cotizacion_personal/venta/'.$guardado->ID_COT.'" class="btn btn-danger" title="Registrar Venta"><i class="fa fa-edit"></i></a></td></tr>';
			}else{
				$body.='<tr><td>'.($numero+1).'</td><td>'.$guardado->NOM_CLI.' '.$guardado->PAT_CLI.' '.$guardado->MAT_CLI.'</td><td>'.$guardado->FEC_COT.'</td><td>'.$guardado->HOR_COT.'</td><td><span class="label bg-blue">ASIGNADO</span></td><td><a href="'.url('cotizacion_personal-pdf/'.$guardado->ID_COT).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a></td></tr>';
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
		return view('cotizacion_personal.venta_cotizacion')->with('venta',$venta)->with('productos',$productos)->with('detalles',$detalles)->with('ubicaciones',$ubicaciones)->with('cotizacion',$cotizacion)->with('obreros',$obreros);
	}

	public function confirma(Request $request){
		if (Cotizacion::where('ID_COT',$request->id_cot)->where('EST_COT','ASIGNADO')->exists()) {
			$error='La COTIZACION ya se encuentra asignada a esta venta';
			return redirect('/registro/venta/'.$request->id_ven)->with('error',$error);
		}
		$venta=Venta::find($request->id_ven);
		$venta->ID_USU_ENC=$request->id_obr;
		$venta->save();
    	//venta de todo lo seleccionado
		for ($i=0; $i < count($request->input('ch')); $i++) {
			if ($request->input('ch.'.$i)) {
				$vc=new VentaCotizacion;
				$vc->ID_VEN=$request->id_ven;
				$vc->MTS_VC=$request->mts2;
				$dato=explode('|', $request->input('ch.'.$i));
				$vc->ID_PRO=$dato[1];
				$vc->RES_VC=$dato[0];
				$vc->CANT_VC=$dato[2];
				$vc->save();

				$producto=Producto::find($dato[1]);
				$producto->EXT_PRO=$producto->EXT_PRO-$dato[2];
				$producto->save();
			}
		}

		if ($request->id_obr!=0) {
			$obrero=new ObreroCosto;
			$obrero->ID_VEN=$request->id_ven;;
			$obrero->MTS2_OC=$request->mts2;
			$obrero->TOT_OC=$request->mts2*45;
			$obrero->save();
		}


		$cotizacion=Cotizacion::find($request->id_cot);
		$cotizacion->EST_COT='ASIGNADO';
		$cotizacion->save();

		$exito='Los productos se AÑADIERON exitosamente!';
		return redirect('/registro/venta/'.$request->id_ven)->with('exito',$exito);
	}

}
