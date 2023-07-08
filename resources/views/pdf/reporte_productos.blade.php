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
	<h1 class="format" style="margin-left: 5.5cm;">REPORTE POR PRODUCTO</h1>
	<img width="10%" src="{{url('img/logo.jpg')}}" style="margin-top: -0.3cm; margin-left: 18cm;" class="format">
	<div id="watermark"><img width="700" src="{{url('img/logo.jpg')}}"></div>
	<div class="format" style="margin-top: 1cm;">

		<hr width="16cm" style="margin-top: 0.3cm">
		<h3 style="margin-left: 0cm;">VENTAS REALIZADAS DEL PRODUCTO: <b>{{$producto->NOM_PRO}}</b></h3>
		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; text-align: center;">
			<tr style="background-color: #DCDCDC;">
				<th>#</th>
				<th>PRODUCTO</th>
				<th>PRECIO COMPRA</th>
				<th>PRECIO VENTA</th>
				<th>CANTIDAD</th>
				<th>FECHA</th>
			</tr>
			<?php $contador=0; ?>
			<?php
				 $sub_compra=0; 
				 $sub_venta=0; 
				 ?>
			@foreach($ventas as $numero=>$venta)
			<?php $contador=$contador+1; ?>
			@if($contador>=50)
			</table>
			<div style="page-break-inside:avoid; page-break-after:always; " class="format"></div>
			<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; text-align: center; margin-top: 1cm;">
			<tr style="background-color: #DCDCDC;">
				<th>#</th>
				<th>PRODUCTO</th>
				<th>FECHA</th>
				<th>CANTIDAD</th>
			</tr>
			<?php $contador=0 ?>
			@endif
			<tr>
				<td>{{$numero+1}}</td>
				<td>{{$venta->NOM_PRO}}</td>
				<td>{{$venta->PRE_COM * $venta->CANT_PRO}}</td>
				<td>{{$venta->PRE_PRO * $venta->CANT_PRO}}</td>
				<td>{{$venta->CANT_PRO}}</td>
				<td>{{$venta->FEC_VEN}}</td>
				
			</tr>
			<?php 
					$sub_compra=$sub_compra+($venta->PRE_COM * $venta->CANT_PRO);
					$sub_venta=$sub_venta+($venta->PRE_PRO * $venta->CANT_PRO);
					 ?>
			@endforeach
		</table>
		<div style="text-align: center; background-color: #DCDCDC; ">
			<h2>TOTAL COMPRA: {{$sub_compra}} Bs.</h2>
			<h2>TOTAL VENTA: {{$sub_venta}} Bs.</h2>
			<h2 class="text-danger" style="color:red;">TOTAL GANANCIA: {{$sub_venta-$sub_compra}} Bs.</h2>
		</div>
	</div>
</body>
</html>