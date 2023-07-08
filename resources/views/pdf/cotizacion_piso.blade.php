<!DOCTYPE html>
<html>
<head>
	<title>PDF - PISO FLOTANTE</title>
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
	<h1 class="format" style="margin-left: 7cm;">PISO FLOTANTE</h1>
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
		<hr width="18cm" style="margin-top: 0.3cm">
		<h3 style="margin-left: 7cm;">DETALLES DE LA COTIZACIÓN</h3>
		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%; text-align: center;">
		<tr>
			<td><h2>BASE: {{$cotizacion->BASE}}</h2></td>
			<td><h2>ALTURA: {{$cotizacion->ALTURA}}</h2></td>
			<td><h2>MTS2: {{$cotizacion->BASE*$cotizacion->ALTURA}}</h2></td>
		</tr>
		</table>
		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%">
			<tr style="background-color: #DDDDDD;">
			 <th colspan="4" style="text-align: center;">PISOS</th>
			</tr>
			<tr style="background-color: #DDDDDD;">
				<th>MTS2</th>
				<th>PRECIOS</th>
				<th>RESULTADO</th>
				<th>PISOS</th>
			</tr>
			<?php 
			$body='';
			$body='';
			$placas=\App\Producto::where('ID_TIP',3)->get();// PISO FLOTANTE;
			$resultado=0;
			$mts2=$cotizacion->BASE*$cotizacion->ALTURA;
			foreach ($placas as $placa) {
				$resultado=$placa->PRE_TOT*$mts2;
				$body.='<tr><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_TOT.' Bs</td><td><b>'.$resultado.' Bs.</b></td><td>'.$placa->NOM_PRO.'</td></tr>';
			}
			echo $body;
			?>
		</table>
		<br>
		<br>
		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; background-color: #DDDDDD;">
		<?php 
		$body='';
		$resultado_membrana_telgopor=round(($cotizacion->ALTURA*$cotizacion->BASE)/24);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE MEMBRANA DE TELGOPOR DE 1.20 X 20 MTS</td><td width="50%"><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td></tr>';
		$resultado_piso_flotante=round(($cotizacion->ALTURA*$cotizacion->BASE)/0.24);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE LAMINAS DE PISO FLOTANTE</td><td width="50%"><b>'.$resultado_piso_flotante.'</b> (Unidades)</td></tr>';
        echo $body;
		 ?>
		 </table>
	</div>
</body>
</html>