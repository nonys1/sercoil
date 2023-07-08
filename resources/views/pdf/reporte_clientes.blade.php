<!DOCTYPE html>
<html>
<head>
	<title></title>
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
	<h1 class="format" style="margin-left: 5.5cm;">REPORTE POR CLIENTE</h1>
	<img width="10%" src="{{url('img/logo.jpg')}}" style="margin-top: -0.3cm; margin-left: 18cm;" class="format">
	<div id="watermark"><img width="700" src="{{url('img/logo.jpg')}}"></div>
	<div class="format" style="margin-top: 1cm;">

		<hr width="16cm" style="margin-top: 0.3cm">
		<h2 style="margin-left: 0cm;">VENTAS REALIZADAS AL CLIENTE: <b>{{$cliente->NOM_CLI.' '.$cliente->PAT_CLI.' '.$cliente->MAT_CLI}}</b></h2>
		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; text-align: center;">
			<tr style="background-color: #DCDCDC;">
				<th>#</th>
				<th>CLIENTE</th>
				<th>USUARIO</th>
				<th>FECHA</th>
				<th>HORA</th>
				<th>ESTADO</th>
			</tr>
			<?php $contador=0; ?>
			@foreach($ventas as $numero=>$venta)
			<?php $contador=$contador+1; ?>
			@if($contador>=50)
			</table>
			<div style="page-break-inside:avoid; page-break-after:always; " class="format"></div>
			<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; text-align: center; margin-top: 1cm;">
			<tr style="background-color: #DCDCDC;">
				<th>#</th>
				<th>CLIENTE</th>
				<th>USUARIO</th>
				<th>FECHA</th>
				<th>HORA</th>
				<th>ESTADO</th>
			</tr>
			<?php $contador=0 ?>
			@endif
			<tr>
				<td>{{$numero+1}}</td>
				<td>{{$venta->NOM_CLI.' '.$venta->PAT_CLI.' '.$venta->MAT_CLI}}</td>
				<td>{{$venta->NOM_USU.' '.$venta->PAT_USU.' '.$venta->MAT_USU}}</td>
				<td>{{$venta->FEC_VEN}}</td>
				<td>{{$venta->HOR_VEN}}</td>
				@if($venta->EST_VEN==0)
				<td>PENDIENTE</td>
				@elseif($venta->EST_VEN==1)
				<td>ASIGNADO</td>
				@elseif($venta->EST_VEN==2)
				<td>ENTREGADO</td>
				@elseif($venta->EST_VEN==3)
				<td>FINALIZADO</td>
				@else
				<td></td>
				@endif
			</tr>
			@endforeach
		</table>
	</div>
</body>
</html>