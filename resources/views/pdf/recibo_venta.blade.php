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
	<h1 class="format" style="margin-left: 8cm; font-size: 2.5em;">FACTURA</h1>
	<br>
	<img width="10%" src="{{url('img/logo.jpg')}}" style="margin-top: -0.3cm; margin-left: 18cm;" class="format">
	<div id="watermark"><img width="700" src="{{url('img/logo.jpg')}}"></div>
	<div class="format" style="margin-top: 1cm;">

		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%">
			<tr>
				<td width="50%"><b>FECHA:</b> {{$venta->FEC_VEN}}</td>
				<td width="50%"><b>HORA:</b> {{$venta->HOR_VEN}}</td>
			</tr>
			<tr>
				<td><b>NIT/CI:</b> {{$venta->NIT_CLI!=NULL?$venta->NIT_CLI:$venta->CI_CLI}}</td>
				<td><b>SEÑOR(A):</b> {{$venta->NOM_CLI.' '.$venta->PAT_CLI.' '.$venta->MAT_CLI}}</td>
			</tr>
			<tr>
				<td><b>USUARIO:</b> {{$venta->NOM_USU.' '.$venta->PAT_USU.' '.$venta->MAT_USU}}</td>
				<td><b>CODIGO FACTURACION:</b> {{$venta->COD_VEN}}</td>
			</tr>
		</table>
		<hr width="18cm" style="margin-top: 0.3cm">

		<?php $total_cotizacion=0; ?>
		@if(count($cotizaciones)!=0)
		<h3 style="margin-left: 5.5cm;">DETALLE DE LA VENTA POR COTIZACION</h3>
		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%">
			<tr>
				<th>#</th>
				<th width="45%">PRODUCTO</th>
				<th>PRECIO UNITARIO</th>
				<th>MTS2</th>
				<th>CANTIDAD</th>
				<th>SUB TOTAL</th>
			</tr>
			@foreach($cotizaciones as $numero=>$cotizacion)
			<tr>
				<td>{{$numero+1}}</td>
				<td>{{$cotizacion->NOM_PRO}}</td>
				<td>{{$cotizacion->PRE_PRO}}</td>
				<td>{{$cotizacion->MTS_VC}}/Mts2</td>
				<td>{{$cotizacion->CANT_VC}}</td>
				<td><b>{{$cotizacion->RES_VC}}</b></td>
				<?php $total_cotizacion=$total_cotizacion+$cotizacion->RES_VC; ?>
			</tr>
			@endforeach
			@if($obrero_costos)
				<tr>
					<td></td>
					<td>ASIGNACIÓN DE OBRERO</td>
					<td>{{$obrero_costos->MTS2_OC}}/Mts2</td>
					<td>1</td>
					<td><b>{{$obrero_costos->TOT_OC}} Bs.</b></td>
					<?php $total_cotizacion=$total_cotizacion+$obrero_costos->TOT_OC; ?>
				</tr>
				@endif
			</table>
			<hr width="18cm" style="margin-top: 0.3cm">
			@endif

			<h3 style="margin-left: 6cm;">DETALLE DE VENTA POR SEPARADO</h3>
			<table cellspacing="0" cellpadding="1" border="0" style="width: 100%">
				<tr>
					<th>#</th>
					<th width="45%">PRODUCTO</th>
					<th>PRECIO UNITARIO</th>
					<th>CANTIDAD</th>
					<th>DESCUENTO</th>
					<th>SUB TOTAL</th>
				</tr>
				<?php $total=0; ?>
				@foreach($detalles as $numero=>$detalle)
				<tr>
					<td>{{$numero+1}}</td>
					<td>{{$detalle->NOM_PRO}}</td>
					<td>{{$detalle->PRE_UNI}}</td>
					<td>{{$detalle->CANT_PRO}}</td>
					<td>{{$detalle->DESC_VEN}}</td>
					<td><b>{{$detalle->TOT_VEN}}</b></td>
					<?php $total=$total+$detalle->TOT_VEN; ?>
				</tr>
				@endforeach
			</table>
			@if(count($ubicaciones)!=0)
			<hr width="18cm" style="margin-top: 0.3cm">
			<h3 style="margin-left: 6cm;">DETALLE DE DIRECCION DE ENVÍO</h3>
			<table cellspacing="0" cellpadding="1" border="0" style="width: 100%">
				<tr>
					<th>#</th>
					<th>DIRECCION DE ENVÍO</th>
					<th>PRECIO</th>
				</tr>
				@foreach($ubicaciones as $numero=>$ubi)
				<tr>
					<td>{{$numero+1}}</td>
					<td>{{$ubi->UBI_UBI}}</td>
					<td><b>{{$ubi->PRE_UBI}}</b></td>
					<?php $total=$total+$ubi->PRE_UBI; ?>
				</tr>
				@endforeach
			</table>
			@endif
			<hr width="18cm" style="margin-top: 0.3cm">
			<h2 style="margin-left: 8cm;"><b>TOTAL: {{$total+$total_cotizacion}} Bs.</b></h2>
			<b>Fecha de emision: {{Carbon\Carbon::now()->format('Y-m-d')}}</b>
			<img width="16%" style="margin-top: 0.5cm;" align="right" src="data:image/png;base64, {{!! base64_encode(QrCode::format('png')->size(150)->generate("SERCOIL|".$venta->COD_VEN)) !!}} ">
		</div>
	</body>
	</html>
