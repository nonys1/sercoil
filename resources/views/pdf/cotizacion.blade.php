<!DOCTYPE html>
<html>
<head>
	<title>PDF - PARED DRYWALL</title>
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
	<h1 class="format" style="margin-left: 7cm;">PARED DRYWALL</h1>
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
			 <th colspan="4" style="text-align: center;">PLACAS DE UNA SOLA CARA</th>
			</tr>
			<tr style="background-color: #DDDDDD;">
				<th>MTS2</th>
				<th>PRECIOS</th>
				<th>RESULTADO</th>
				<th>PLACAS</th>
			</tr>
			<?php 
			$body='';
			$placas=\App\Producto::where('NOM_PRO','LIKE','%PLACA DE YESO%')->where('ID_CAT',4)->get();
			$resultado=0;
			$mts2=$cotizacion->BASE*$cotizacion->ALTURA;
			foreach ($placas as $placa) {
				$resultado=$placa->PRE_PRO*$mts2;
				$body.='<tr><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs/u</td><td><b>'.$resultado.' Bs.</b></td><td>'.$placa->NOM_PRO.'</td></tr>';
			}
			echo $body;
			?>
		</table>
		<br>
		<br>
		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; background-color: #DDDDDD;">
		<?php 
		$body='';
		$resultado_soleras=round(($cotizacion->BASE/2.40)*2,0);
        $body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILES SOLERAS</td><td width="50%"><b>'.$resultado_soleras.'</b> (Unidades)</td></tr>';
        $resultado_montantes=round((($cotizacion->BASE/0.60)+1)*(($cotizacion->ALTURA/2.40)),0);
        $body.='<tr class="danger"><td>CANTIDAD DE PERFILES MONTANTES</td><td><b>'.$resultado_montantes.'</b> (Unidades)</td></tr>';
        $resultado_placas=round(($cotizacion->BASE*$cotizacion->ALTURA)/2.88,0);
        $body.='<tr class="danger"><td>CANTIDAD DE PLACAS DE YESO</td><td><b>'.$resultado_placas.'</b> (Unidades)</td></tr>';
        echo $body;
		 ?>
		 </table>
	</div>
</body>
</html>