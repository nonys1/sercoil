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

class CotizacionCieloController extends Controller
{
	public function index(){
		$ventas=Venta::where('ID_USU',Auth::user()->ID_USU)
		->join('cliente','cliente.ID_CLI','=','venta.ID_CLI')
		->orderBy('ID_VEN','DESC')
		->get();
		return view('cotizacion_cielo.index')->with('ventas',$ventas);
	}
	public function calcula(Request $request){
		$header='<table class="table table-bordered table-striped animated fadeInRight"><tr class="success"><th colspan="4" class="text-center">PERFILERIA ACUSTICA</th></tr><tr class="success"><th>MTS2</th><th>PRECIO TOTAL</th><th>RESULTADO</th><th>PERFILES</th></tr>';
		$body='';
		$footer='</table>';
		$placas=Producto::where('ID_TIP',2)->get();// CIELO ACUSTICO;
		$resultado=0;
		$mts2=$request->base*$request->altura;
		foreach ($placas as $placa) {
			$resultado=$placa->PRE_TOT*$mts2;
			$body.='<tr><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_TOT.' Bs</td><td><b>'.$resultado.' Bs.</b></td><td>'.$placa->NOM_PRO.'</td></tr>';
		}
		$placa_una_cara=$header.$body.$footer;

		$header='<table class="table table-bordered table-striped animated fadeInRight">';
		$body='';
		$footer='</table>';
		$resultado_perimetral_3mts=round((($request->altura/3)+($request->base/3))*2);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA ACÚSTICA MEILUDA PERIMETRAL 2.00 MTS</td><td width="50%"><b>'.$resultado_perimetral_3mts.'</b> (Unidades)</td></tr>';
		$resultado_central_3_66mts=round((($request->base/1.22)-1)*($request->altura/3.66));
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA ACÚSTICA MEILUDA CENTRAL 3.66 MTS</td><td width="50%"><b>'.$resultado_central_3_66mts.'</b> (Unidades)</td></tr>';
		$resultado_transversal_1_22mts=round(($request->base/1.22)*(($request->altura/0.61)-1));
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA MEILUDA TRANSVERSAL DE 1.22 MTS</td><td width="50%"><b>'.$resultado_transversal_1_22mts.'</b> (Unidades)</td></tr>';
		$resultado_transversal_0_61mts=round(($request->base/1.22)*($request->altura/0.61));
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA MEILUDA TRANSVERSAL DE 0.61 CM</td><td width="50%"><b>'.$resultado_transversal_0_61mts.'</b> (Unidades)</td></tr>';
		$resultado_paneles_0_60mts=round(($request->base*$request->altura)/0.3721);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PANELES DE 0.60</td><td width="50%"><b>'.$resultado_paneles_0_60mts.'</b> (Unidades)</td></tr>';


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
			$cotizacion->TIP_COT='CIELO';
			if($cotizacion->save()){
				return response()->json($cotizacion);
			}else{
				return response()->json('FALSE');
			}

		}
	}

	public function imprimir($id){
		$cotizacion=Cotizacion::join('cliente','cliente.ID_CLI','=','cotizacion.ID_CLI')->join('users','users.ID_USU','=','cotizacion.ID_USU')->where('ID_COT',$id)->first();
		$pdf = Dompdf::setPaper('LETTER', 'portrait')->loadView('pdf.cotizacion_cielo', compact('cotizacion'));
		return $pdf->stream('COTIZACION CIELO ACUSTICO-'.time().'.pdf');
	}

	public function guardado(){
		$guardados=Cotizacion::join('cliente','cliente.ID_CLI','=','cotizacion.ID_CLI')->where('ID_USU',Auth::user()->ID_USU)->where('TIP_COT','CIELO')->orderBy('ID_COT','DESC')->get();
		$header='<table class="table table-bordered table-striped table-hover animated fadeInRight"><tr class="info"><th>#</th><th>CLIENTE</th><th>FECHA</th><th>HORA</th><td>ESTADO</th><th>IMPRIMIR</th></tr>';
		$body='';
		$footer='</table>';
		foreach ($guardados as $numero=>$guardado) {
			if ($guardado->EST_COT=='PENDIENTE') {
				$body.='<tr><td>'.($numero+1).'</td><td>'.$guardado->NOM_CLI.' '.$guardado->PAT_CLI.' '.$guardado->MAT_CLI.'</td><td>'.$guardado->FEC_COT.'</td><td>'.$guardado->HOR_COT.'</td><td><span class="label bg-yellow">PENDIENTE</span></td><td><a href="'.url('cotizacion_cielo-pdf/'.$guardado->ID_COT).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a><a  href="cotizacion_cielo/venta/'.$guardado->ID_COT.'" class="btn btn-danger" title="Registrar Venta"><i class="fa fa-edit"></i></a></td></tr>';
			}else{
				$body.='<tr><td>'.($numero+1).'</td><td>'.$guardado->NOM_CLI.' '.$guardado->PAT_CLI.' '.$guardado->MAT_CLI.'</td><td>'.$guardado->FEC_COT.'</td><td>'.$guardado->HOR_COT.'</td><td><span class="label bg-blue">ASIGNADO</span></td><td><a href="'.url('cotizacion_cielo-pdf/'.$guardado->ID_COT).'" target="_blank" class="btn btn-info"><i class="fa fa-print"></i></a></td></tr>';
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
		return view('cotizacion_cielo.venta_cotizacion')->with('venta',$venta)->with('productos',$productos)->with('detalles',$detalles)->with('ubicaciones',$ubicaciones)->with('cotizacion',$cotizacion)->with('obreros',$obreros);
	}

	public function confirma(Request $request){
		if (!$request->id_obr) {
			$error='Debe asignar a un obrero';
			return redirect('cotizacion_cielo/venta/'.$request->id_cot)->with('error',$error);
		}
		if (Cotizacion::where('ID_COT',$request->id_cot)->where('EST_COT','ASIGNADO')->exists()) {
			$error='La COTIZACION ya se encuentra asignada a esta venta';
			return redirect('/registro/venta/'.$request->id_ven)->with('error',$error);
		}
		$venta=Venta::find($request->id_ven);
		$venta->ID_USU_ENC=$request->id_obr;
		$venta->save();
    	//venta de paneles
		for ($i=0; $i <4 ; $i++) {
			if ($request->input('ch_'.$i)) {
				$vc=new VentaCotizacion;
				$vc->ID_VEN=$request->id_ven;
				$vc->MTS_VC=$request->mts2;
				$dato=explode('|', $request->input('ch_'.$i));
				$vc->ID_PRO=$dato[1];
				$vc->RES_VC=$dato[0];
				$vc->CANT_VC=$request->cant_panel;
				$vc->save();

				$producto=Producto::find($dato[1]);
				$producto->EXT_PRO=$producto->EXT_PRO-$request->cant_panel;
				$producto->save();
			}
		}
    	//venta de perfil meiluda perimetral 300 mts
		$vc=new VentaCotizacion;
		$vc->ID_VEN=$request->id_ven;
		$vc->MTS_VC=$request->mts2;
		$vc->ID_PRO=23;
		$vc->RES_VC=0;
		$vc->CANT_VC=$request->cantidad_perimetral_3mts * $request->cantidad_seleccionada;
		$vc->save();

		$producto=Producto::find(23);
		$producto->EXT_PRO=$producto->EXT_PRO-$request->cantidad_perimetral_3mts;
		$producto->save();

		//venta de perfil meiluda central 3.66 mts
		$vc=new VentaCotizacion;
		$vc->ID_VEN=$request->id_ven;
		$vc->MTS_VC=$request->mts2;
		$vc->ID_PRO=24;
		$vc->RES_VC=0;
		$vc->CANT_VC=$request->cantidad_central_3_66mts * $request->cantidad_seleccionada;
		$vc->save();

		$producto=Producto::find(24);
		$producto->EXT_PRO=$producto->EXT_PRO-$request->cantidad_central_3_66mts;
		$producto->save();

		//venta de perfil meiluda transversal 1.22 mts
		$vc=new VentaCotizacion;
		$vc->ID_VEN=$request->id_ven;
		$vc->MTS_VC=$request->mts2;
		$vc->ID_PRO=25;
		$vc->RES_VC=0;
		$vc->CANT_VC=$request->cantidad_transversal_1_22mts * $request->cantidad_seleccionada;
		$vc->save();

		$producto=Producto::find(25);
		$producto->EXT_PRO=$producto->EXT_PRO-$request->cantidad_transversal_1_22mts;
		$producto->save();

		//venta de perfil meiluda transversal 0.61 cm
		$vc=new VentaCotizacion;
		$vc->ID_VEN=$request->id_ven;
		$vc->MTS_VC=$request->mts2;
		$vc->ID_PRO=26;
		$vc->RES_VC=0;
		$vc->CANT_VC=$request->cantidad_transversal_0_61mts * $request->cantidad_seleccionada;
		$vc->save();

		$producto=Producto::find(26);
		$producto->EXT_PRO=$producto->EXT_PRO-$request->cantidad_transversal_0_61mts;
		$producto->save();




		$cotizacion=Cotizacion::find($request->id_cot);
		$cotizacion->EST_COT='ASIGNADO';
		$cotizacion->save();

		$exito='Los productos se AÑADIERON exitosamente!';
		return redirect('/registro/venta/'.$request->id_ven)->with('exito',$exito);
	}

}
