<!DOCTYPE html>
<html>
<head>
	<title>PDF - PERSONALIZADA</title>
	<style type="text/css">
		@page{
			margin: 0cm;
			margin-top: 0cm;
			margin-bottom: 1cm;
			margin-left: 1cm;
			margin-right: 1cm;
		}
		body {
			font-family: "Courier";
			font-size: 13px;
			/*color: #676a6c;*/
			color:black;
		}
		.format{
			position: absolute; 
			z-index: 1;
		}
	</style>
</head>
<body>
	
	<div class="format" style="margin-top: 1cm;">
		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%; text-align: center;">
			<tr style="background-color: #DDDDDD;">
				<td><h2>PROFORMA DE COTIZACIÓN</h2></td>
			</tr>
			<tr style="background-color: #DDDDDD;">
				<td><h2>COTIZACIÓN PERSONALIZADA</h2></td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%; text-align: center;">
			<tr>
				<td><h2>BASE: {{$request->base}}</h2></td>
				<td><h2>ALTURA: {{$request->altura}}</h2></td>
				<td><h2>MTS2: {{$request->base*$request->altura}}</h2></td>
			</tr>
		</table>

		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; text-align: center;">
			<tr style="background-color: #DDDDDD;">
				<th colspan="5" >COTIZACION PERSONALIZADA</th>
			</tr>
			<tr style="background-color: #DDDDDD;">
				<th>MTS2</th><th>PRECIO UNIDAD</th><th>CANTIDAD</th><th>PRODUCTO</th><th>SUBTOTAL</th>
			</tr>
			<?php 
			$mts2=$request->base*$request->altura;
			$body='';
		// *******************  INICIO PARED DRYWALL ***************************
			$resultado_soleras=round(($request->base/2.40)*2,0);
			$query_solera=\App\Producto::where('ID_PRO',4)->where('EXT_PRO','>=',$resultado_soleras)->first();
			$body.='<tr class="danger"><td>'.$mts2.' /mts2</td><td>'.$query_solera->PRE_PRO.' Bs.</td><td><b>'.$resultado_soleras.'</b> (Unidades)</td><td>PERFILES '.$query_solera->NOM_PRO.'</td><td>'.$resultado_soleras*$query_solera->PRE_PRO.' Bs.</td></tr>';

			$resultado_montantes=round((($request->base/0.60)+1)*(($request->altura/2.40)),0);
			$query_montante=\App\Producto::where('ID_PRO',3)->where('EXT_PRO','>=',$resultado_montantes)->first();
			$body.='<tr class="danger"><td>'.$mts2.' /mts2</td><td>'.$query_montante->PRE_PRO.' Bs.</td><td><b>'.$resultado_montantes.'</b> (Unidades)</td><td>PERFILES '.$query_montante->NOM_PRO.'</td><td>'.$resultado_montantes*$query_montante->PRE_PRO.' Bs.</td></tr>';
			$resultado_placas=round(($request->base*$request->altura)/2.88,0);

			$placas=\App\Producto::where('NOM_PRO','LIKE','%PLACA DE YESO%')->where('ID_CAT',4)->get();
			foreach ($placas as $placa) {
				$resultado_placas=round(($request->base*$request->altura)/2.88,0);
				$body.='<tr class="danger"><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs</td><td><b>'.$resultado_placas.'</b> (Unidades)</td><td>'.$placa->NOM_PRO.'</td><td>'.$resultado_placas*$placa->PRE_PRO.' Bs.</td></tr>';
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
		$body.='<tr class="info"><td>'.$mts2.'</td><td>'.$query_membrana_telgopor->PRE_PRO.' Bs.</td><td><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td><td>PERFILES '.$query_membrana_telgopor->NOM_PRO.'</td><td>'.$resultado_membrana_telgopor*$query_membrana_telgopor->PRE_PRO.' Bs.</td></tr>';

		$pisos=\App\Producto::where('ID_TIP',3)->get();// PISO FLOTANTE
		foreach ($pisos as $piso) {
			$resultado_piso=round(($request->altura*$request->base)/0.24);
			$body.='<tr class="info"><td>'.$mts2.' /mts2</td><td>'.$piso->PRE_PRO.' Bs</td><td><b>'.$resultado_piso.'</b> (Unidades)</td><td>'.$piso->NOM_PRO.'</td><td>'.$resultado_piso*$piso->PRE_PRO.' Bs.</td></tr>';
		}
		// *******************  FIN PISO FLOTANTE ***************************
		echo $body;
		?>
	</table>
</div>
</body>
</html>