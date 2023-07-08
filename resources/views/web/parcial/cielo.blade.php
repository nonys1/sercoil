<!DOCTYPE html>
<html>
<head>
	<title>PDF - CIELO ACUSTICO</title>
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
				<td><h2>CIELO ACUSTICO</h2></td>
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
			 <th colspan="4" style="text-align: center;">CIELO FALSO</th>
			</tr>
			<tr style="background-color: #DDDDDD;">
				<th>MTS2</th>
				<th>PRECIOS</th>
				<th>RESULTADO</th>
				<th>PANELES</th>
			</tr>
			<?php 
			$body='';
			$placas=\App\Producto::where('ID_TIP',2)->get();// CIELO ACUSTICO;
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
		$resultado_perimetral_3mts=round((($request->altura/3)+($request->base/3))*2);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA ACÚSTICA MEILUDA PERIMETRAL 3.00 MTS</td><td width="50%"><b>'.$resultado_perimetral_3mts.'</b> (Unidades)</td></tr>';
		$resultado_central_3_66mts=round((($request->base/1.22)-1)*($request->altura/3.66));
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA ACÚSTICA MEILUDA CENTRAL 3.66 MTS</td><td width="50%"><b>'.$resultado_central_3_66mts.'</b> (Unidades)</td></tr>';
		$resultado_transversal_1_22mts=round(($request->base/1.22)*(($request->altura/0.61)-1));
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA MEILUDA TRANSVERSAL DE 1.22 MTS</td><td width="50%"><b>'.$resultado_transversal_1_22mts.'</b> (Unidades)</td></tr>';
		$resultado_transversal_0_61mts=round(($request->base/1.22)*($request->altura/0.61));
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PERFILERÍA MEILUDA TRANSVERSAL DE 0.61 CM</td><td width="50%"><b>'.$resultado_transversal_0_61mts.'</b> (Unidades)</td></tr>';
		$resultado_paneles_0_60mts=round(($request->base*$request->altura)/0.3721);
		$body.='<tr class="danger"><td width="50%">CANTIDAD DE PANELES DE 0.60</td><td width="50%"><b>'.$resultado_paneles_0_60mts.'</b> (Unidades)</td></tr>';
        echo $body;
		 ?>
		 </table>
	</div>
</body>
</html>