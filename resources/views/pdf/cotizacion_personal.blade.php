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
		#watermark{
			position: fixed;
			top: 70px;
			bottom: 0px;
			right: 500px;
			width: 200px;
			height: 200px;
			opacity: 0.1;
		}
	</style>
</head>
<body>
	<h1 class="format" style="margin-left: 5.5cm;">PROFORMA DE COTIZACIÓN</h1>
	<img width="10%" src="{{url('img/logo.jpg')}}" style="margin-top: -0.3cm; margin-left: 18cm;" class="format">
	<div id="watermark"><img width="700" src="{{url('img/logo.jpg')}}"></div>
	<br>
	<h1 class="format" style="margin-left: 5cm;">COTIZACIÓN PERSONALIZADA</h1>
	<br>
	<div class="format" style="margin-top: 1cm;">

		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%">
			<tr>
				<td width="50%"><b>FECHA:</b> {{$cotizacion->FEC_COT}}</td>
				<td width="50%"><b>HORA:</b> {{$cotizacion->HOR_COT}}</td>
			</tr>
			<tr>
				<td><b>CLIENTE:</b> {{$cotizacion->NOM_CLI.' '.$cotizacion->PAT_CLI.' '.$cotizacion->MAT_CLI}}</td>
				<td><b>USUARIO:</b> {{$cotizacion->NOM_USU.' '.$cotizacion->PAT_USU.' '.$cotizacion->MAT_USU}}</td>

			</tr>
		</table>
		<hr width="18cm" style="margin-top: 0.1cm">
		<h3 style="margin-left: 7cm;">DETALLES DE LA COTIZACIÓN</h3>
		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%; text-align: center;">
			<tr>
				<td><h2>BASE: {{$cotizacion->BASE}}</h2></td>
				<td><h2>ALTURA: {{$cotizacion->ALTURA}}</h2></td>
				<td><h2>MTS2: {{$cotizacion->BASE*$cotizacion->ALTURA}}</h2></td>
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
			$mts2=$cotizacion->BASE*$cotizacion->ALTURA;
			$body='';
		// *******************  INICIO PARED DRYWALL ***************************
			$resultado_soleras=round(($cotizacion->BASE/2.40)*2,0);
			$query_solera=\App\Producto::where('ID_PRO',4)->where('EXT_PRO','>=',$resultado_soleras)->first();
			$body.='<tr class="danger"><td>'.$mts2.' /mts2</td><td>'.$query_solera->PRE_PRO.' Bs.</td><td><b>'.$resultado_soleras.'</b> (Unidades)</td><td>PERFILES '.$query_solera->NOM_PRO.'</td><td>'.$resultado_soleras*$query_solera->PRE_PRO.' Bs.</td></tr>';

			$resultado_montantes=round((($cotizacion->BASE/0.60)+1)*(($cotizacion->ALTURA/2.40)),0);
			$query_montante=\App\Producto::where('ID_PRO',3)->where('EXT_PRO','>=',$resultado_montantes)->first();
			$body.='<tr class="danger"><td>'.$mts2.' /mts2</td><td>'.$query_montante->PRE_PRO.' Bs.</td><td><b>'.$resultado_montantes.'</b> (Unidades)</td><td>PERFILES '.$query_montante->NOM_PRO.'</td><td>'.$resultado_montantes*$query_montante->PRE_PRO.' Bs.</td></tr>';
			$resultado_placas=round(($cotizacion->BASE*$cotizacion->ALTURA)/2.88,0);

			$placas=\App\Producto::where('NOM_PRO','LIKE','%PLACA DE YESO%')->where('ID_CAT',4)->get();
			foreach ($placas as $placa) {
				$resultado_placas=round(($cotizacion->BASE*$cotizacion->ALTURA)/2.88,0);
				$body.='<tr class="danger"><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs</td><td><b>'.$resultado_placas.'</b> (Unidades)</td><td>'.$placa->NOM_PRO.'</td><td>'.$resultado_placas*$placa->PRE_PRO.' Bs.</td></tr>';
			}
		// *******************  FIN PARED DRYWALL ***************************
		// *******************  INICIO CIELO FALSO ***************************
			$resultado_perimetral_3mts=round((($cotizacion->ALTURA/3)+($cotizacion->BASE/3))*2);
			$query_perimetral_3mts=\App\Producto::where('ID_PRO',23)->where('EXT_PRO','>=',$resultado_perimetral_3mts)->first();
			$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_perimetral_3mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_perimetral_3mts.'</b> (Unidades)</td><td>PERFILES '.$query_perimetral_3mts->NOM_PRO.'</td><td>'.$resultado_perimetral_3mts*$query_perimetral_3mts->PRE_PRO.' Bs.</td></tr>';

			$resultado_central_3_66mts=round((($cotizacion->BASE/1.22)-1)*($cotizacion->ALTURA/3.66));
			$query_central_3_66mts=\App\Producto::where('ID_PRO',24)->where('EXT_PRO','>=',$resultado_central_3_66mts)->first();
			$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_central_3_66mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_central_3_66mts.'</b> (Unidades)</td><td>PERFILES '.$query_central_3_66mts->NOM_PRO.'</td><td>'.$resultado_central_3_66mts*$query_central_3_66mts->PRE_PRO.' Bs.</td></tr>';

			$resultado_transversal_1_22mts=round(($cotizacion->BASE/1.22)*(($cotizacion->ALTURA/0.61)-1));
			$query_transversal_1_22mts=\App\Producto::where('ID_PRO',25)->where('EXT_PRO','>=',$resultado_transversal_1_22mts)->first();
			$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_transversal_1_22mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_1_22mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_1_22mts->NOM_PRO.'</td><td>'.$resultado_transversal_1_22mts*$query_transversal_1_22mts->PRE_PRO.' Bs.</td></tr>';

			$resultado_transversal_0_61mts=round(($cotizacion->BASE/1.22)*($cotizacion->ALTURA/0.61));
			$query_transversal_0_61mts=\App\Producto::where('ID_PRO',26)->where('EXT_PRO','>=',$resultado_transversal_0_61mts)->first();
			$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$query_transversal_0_61mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_0_61mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_0_61mts->NOM_PRO.'</td><td>'.$resultado_transversal_0_61mts*$query_transversal_0_61mts->PRE_PRO.' Bs.</td></tr>';

		$paneles=\App\Producto::where('ID_TIP',2)->get();// CIELO ACUSTICO;
		foreach ($paneles as $panel) {
			$resultado_panel=round(($cotizacion->BASE*$cotizacion->ALTURA)/0.3721);
			$body.='<tr class="warning"><td>'.$mts2.' /mts2</td><td>'.$panel->PRE_PRO.' Bs</td><td><b>'.$resultado_panel.'</b> (Unidades)</td><td>'.$panel->NOM_PRO.'</td><td>'.$resultado_panel*$panel->PRE_PRO.' Bs.</td></tr>';
		}
		// *******************  FIN CIELO FALSO ***************************
		// *******************  INICIO PISO FLOTANTE ***************************
		$resultado_membrana_telgopor=round(($cotizacion->ALTURA*$cotizacion->BASE)/24);
		$query_membrana_telgopor=\App\Producto::where('ID_PRO',31)->where('EXT_PRO','>=',$resultado_membrana_telgopor)->first();
		$body.='<tr class="info"><td>'.$mts2.'</td><td>'.$query_membrana_telgopor->PRE_PRO.' Bs.</td><td><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td><td>PERFILES '.$query_membrana_telgopor->NOM_PRO.'</td><td>'.$resultado_membrana_telgopor*$query_membrana_telgopor->PRE_PRO.' Bs.</td></tr>';

		$pisos=\App\Producto::where('ID_TIP',3)->get();// PISO FLOTANTE
		foreach ($pisos as $piso) {
			$resultado_piso=round(($cotizacion->ALTURA*$cotizacion->BASE)/0.24);
			$body.='<tr class="info"><td>'.$mts2.' /mts2</td><td>'.$piso->PRE_PRO.' Bs</td><td><b>'.$resultado_piso.'</b> (Unidades)</td><td>'.$piso->NOM_PRO.'</td><td>'.$resultado_piso*$piso->PRE_PRO.' Bs.</td></tr>';
		}
		// *******************  FIN PISO FLOTANTE ***************************
		echo $body;
		?>
	</table>
</div>
</body>
</html>