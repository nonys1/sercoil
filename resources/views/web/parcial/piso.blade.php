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
		
	</style>
</head>
<body>

	<div class="format" style="margin-top: 1cm;">

		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%; text-align: center;">
			<tr style="background-color: #DDDDDD;">
				<td><h2>PROFORMA DE COTIZACIÓN</h2></td>
			</tr>
			<tr style="background-color: #DDDDDD;">
				<td><h2>PISO FLOTANTE</h2></td>
			</tr>
		</table>
		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%; text-align: center;">
		<tr>
			<td><h2>BASE: {{$request->base}}</h2></td>
			<td><h2>ALTURA: {{$request->altura}}</h2></td>
			<td><h2>MTS2: {{$request->base*$request->altura}}</h2></td>
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
			$mts2=$request->base*$request->altura;
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
		$resultado_membrana_telgopor=round(($request->altura*$request->base)/24);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE MEMBRANA DE TELGOPOR DE 1.20 X 20 MTS</td><td width="50%"><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td></tr>';
		$resultado_piso_flotante=round(($request->altura*$request->base)/0.24);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE LAMINAS DE PISO FLOTANTE</td><td width="50%"><b>'.$resultado_piso_flotante.'</b> (Unidades)</td></tr>';
        echo $body;
		 ?>
		 </table>
	</div>
</body>
</html>