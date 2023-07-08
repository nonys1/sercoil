<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;

use App\Mail\TestEmail;
use Mail;

class WebController extends Controller
{
	public function index(){
		return view('web.index');
	}

	public function mostrarproducto(){
        $producto=Producto::get();
		$body='';

		foreach ($producto as $po) {
			$body.='<div class="col-12 col-md-4 mb-4">
				<div style="padding: 20px; margin: 0px auto;text-align: center;display: flex;align-items: center;align-content: flex-start;" class="card h-100">
					<a href="shop-single.html">
						<img style="width: 200px;" src='.$po->IMG_PRO.' class="card-img-top" alt="...">
					</a>
					<div class="card-body">
						<ul class="list-unstyled d-flex justify-content-between">
							<li>
								<i class="text-warning fa fa-star"></i>
								<i class="text-warning fa fa-star"></i>
								<i class="text-warning fa fa-star"></i>
								<i class="text-warning fa fa-star"></i>
								<i class="text-muted fa fa-star"></i>
							</li>
							<li class="text-muted text-right">'.$po->PRE_PRO.'</li>
						</ul>
						<a href="shop-single.html" class="h2 text-decoration-none text-dark">'.$po->NOM_PRO.'</a>
						<p class="card-text">
						'.$po->DES_PRO.'
						</p>
						<p class="text-muted"># ('.$po->COD_PRO.')</p>
					</div>
				</div>
			</div>';
		}
		echo $body;
	}

	public function calcula(Request $request){
		switch ($request->tipo) {
			case 'PARED':

			$header='<table class="table table-bordered table-striped animated flipInX"><tr class="bg-primary text-white"><th colspan="4" class="text-center">PLACAS DE UNA SOLA CARA</th></tr><tr class="success"><th>MTS2</th><th>PRECIOS</th><th>RESULTADO</th><th>PLACAS</th></tr>';
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
			$cantidades=$header.$body.$footer.'<div id="div_botonera" class="text-center animated fadeInRight row"><input type="hidden" name="base" value="'.$request->base.'"><input type="hidden" name="altura" value="'.$request->altura.'"><input type="hidden" name="tipo" value="PARED"><div class="col-md-6"><input type="text" class="form-control" name="email" placeholder="Ingrese su correo electronico" value="" required></div><div class="col-md-6"><button type="submit" id="btn_send" class="btn btn-success btn-block">ENVIAR A MI CORREO</button></div></div>';
			echo $placa_una_cara.$cantidades;

			break;

			case 'CIELO':
			$header='<table class="table table-bordered table-striped animated flipInX"><tr class="bg-primary text-white"><th colspan="4" class="text-center">PERFILERIA ACUSTICA</th></tr><tr class="success"><th>MTS2</th><th>PRECIO TOTAL</th><th>RESULTADO</th><th>PERFILES</th></tr>';
			$body='';
			$footer='</table>';
			$placas=Producto::where('ID_TIP',2)->get();
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
			$cantidades=$header.$body.$footer.'<div id="div_botonera" class="text-center animated fadeInRight row"><input type="hidden" name="base" value="'.$request->base.'"><input type="hidden" name="altura" value="'.$request->altura.'"><input type="hidden" name="tipo" value="CIELO"><div class="col-md-6"><input type="text" class="form-control" name="email" placeholder="Ingrese su correo electronico" value="" required></div><div class="col-md-6"><button type="submit" id="btn_send" class="btn btn-success btn-block">ENVIAR A MI CORREO</button></div></div>';
			echo $placa_una_cara.$cantidades;
			break;

			case 'PISO':
			$header='<table class="table table-bordered table-striped animated flipInX"><tr class="bg-primary text-white"><th colspan="4" class="text-center">PISO FLOTANTE</th></tr><tr class="success"><th>MTS2</th><th>PRECIO TOTAL</th><th>RESULTADO</th><th>PERFILES</th></tr>';
			$footer='</table>';
			$body='';
			$placas=Producto::where('ID_TIP',3)->get();
			$resultado=0;
			$mts2=$request->base*$request->altura;
			foreach ($placas as $placa) {
				$resultado=$placa->PRE_TOT*$mts2;
				$body.='<tr><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_TOT.' Bs</td><td><b>'.$resultado.' Bs.</b></td><td>'.$placa->NOM_PRO.'</td></tr>';
			}
			$placa_una_cara=$header.$body.$footer;
			$header='<table class="table table-bordered table-striped animated fadeInRight">';
			$footer='</table>';
			$body='';
			$resultado_membrana_telgopor=round(($request->altura*$request->base)/24);
			$body.='<tr class="danger"><td width="50%">CANTIDAD DE MEMBRANA DE TELGOPOR DE 1.20 X 20 MTS</td><td width="50%"><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td></tr>';
			$resultado_piso_flotante=round(($request->altura*$request->base)/0.24);
			$body.='<tr class="danger"><td width="50%">CANTIDAD DE LAMINAS DE PISO FLOTANTE</td><td width="50%"><b>'.$resultado_piso_flotante.'</b> (Unidades)</td></tr>';
			$cantidades=$header.$body.$footer.'<div id="div_botonera" class="text-center animated fadeInRight row"><input type="hidden" name="base" value="'.$request->base.'"><input type="hidden" name="altura" value="'.$request->altura.'"><input type="hidden" name="tipo" value="PISO"><div class="col-md-6"><input type="text" class="form-control" name="email" placeholder="Ingrese su correo electronico" value="" required></div><div class="col-md-6"><button type="submit" id="btn_send" class="btn btn-success btn-block">ENVIAR A MI CORREO</button></div></div>';
			echo $placa_una_cara.$cantidades;
			break;

			case 'PERSONALIZADA':
			$mts2=$request->base*$request->altura;
			$header='<table class="table table-bordered table-striped animated flipInY"><tr class="bg-primary text-white"><th colspan="5" class="text-center">COTIZACION PERSONALIZADA</th></tr><tr class="danger"><th>MTS2</th><th>PRECIO UNIDAD</th><th>CANTIDAD</th><th>PRODUCTO</th><th>SUBTOTAL</th></tr>';
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

			$paneles=\App\Producto::where('ID_TIP',2)->get();
			foreach ($paneles as $panel) {
				$resultado_panel=round(($request->base*$request->altura)/0.3721);
				$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$panel->PRE_PRO.' Bs</td><td><b>'.$resultado_panel.'</b> (Unidades)</td><td>'.$panel->NOM_PRO.'</td><td>'.$resultado_panel*$panel->PRE_PRO.' Bs.</td></tr>';
			}
			// *******************  FIN CIELO FALSO ***************************
			// *******************  INICIO PISO FLOTANTE ***************************
			$resultado_membrana_telgopor=round(($request->altura*$request->base)/24);
			$query_membrana_telgopor=\App\Producto::where('ID_PRO',31)->where('EXT_PRO','>=',$resultado_membrana_telgopor)->first();
			$body.='<tr class="info"><td>'.$mts2.' /mts2</td><td>'.$query_membrana_telgopor->PRE_PRO.' Bs.</td><td><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td><td>PERFILES '.$query_membrana_telgopor->NOM_PRO.'</td><td>'.$resultado_membrana_telgopor*$query_membrana_telgopor->PRE_PRO.' Bs.</td></tr>';

			$pisos=Producto::where('ID_TIP',3)->get();
			foreach ($pisos as $piso) {
				$resultado_piso=round(($request->altura*$request->base)/0.24);
				$body.='<tr class="info"><td>'.$mts2.' /mts2</td><td>'.$piso->PRE_PRO.' Bs</td><td><b>'.$resultado_piso.'</b> (Unidades)</td><td>'.$piso->NOM_PRO.'</td><td>'.$resultado_piso*$piso->PRE_PRO.' Bs.</td></tr>';
			}
			// *******************  FIN PISO FLOTANTE ***************************
			$cantidades=$header.$body.$footer.'<div id="div_botonera" class="text-center animated fadeInRight row"><input type="hidden" name="base" value="'.$request->base.'"><input type="hidden" name="altura" value="'.$request->altura.'"><input type="hidden" name="tipo" value="PERSONAL"><div class="col-md-6"><input type="text" class="form-control" name="email" placeholder="Ingrese su correo electronico" value="" required></div><div class="col-md-6"><button type="submit" id="btn_send" class="btn btn-success btn-block">ENVIAR A MI CORREO</button></div></div>';
			echo $cantidades;
			break;
		}
	}

	public function envia(Request $request){
		switch ($request->tipo) {
			case 'PARED':
			try {
				$view=view('web.parcial.pared',compact('request'))->render();
				$subject = ['subject' => 'SERCOIL: COTIZACIÓN PARED DRYWALL'];
		        $data = ['content' => $view];
		        Mail::to($request->email)->send(new TestEmail($data,$subject));
		        return response()->json('TRUE');
			} catch (Exception $e) {
		        return response()->json('FALSE');
			}
				break;
			

			case 'CIELO':
			try {
				$view=view('web.parcial.cielo',compact('request'))->render();
				$subject = ['subject' => 'SERCOIL: COTIZACIÓN CIELO ACUSTICO'];
		        $data = ['content' => $view];
		        Mail::to($request->email)->send(new TestEmail($data,$subject));
		        return response()->json('TRUE');
			} catch (Exception $e) {
		        return response()->json('FALSE');
			}
				break;

			
			case 'PISO':
			try {
				$view=view('web.parcial.piso',compact('request'))->render();
				$subject = ['subject' => 'SERCOIL: COTIZACIÓN PISO FLOTANTE'];
		        $data = ['content' => $view];
		        Mail::to($request->email)->send(new TestEmail($data,$subject));
		        return response()->json('TRUE');
			} catch (Exception $e) {
		        return response()->json('FALSE');
			}
				break;

			
			case 'PERSONAL':
			try {
				$view=view('web.parcial.personal',compact('request'))->render();
				$subject = ['subject' => 'SERCOIL: COTIZACIÓN PERSONALIZADA'];
		        $data = ['content' => $view];
		        Mail::to($request->email)->send(new TestEmail($data,$subject));
		        return response()->json('TRUE');
			} catch (Exception $e) {
		        return response()->json('FALSE');
			}
				break;		
		
		}
	}
}
