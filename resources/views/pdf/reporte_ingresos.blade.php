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
	<h1 class="format" style="margin-left: 4.5cm;">REPORTE DE INGRESOS POR FECHA</h1>
	<img width="10%" src="{{url('img/logo.jpg')}}" style="margin-top: -0.3cm; margin-left: 18cm;" class="format">
	<div id="watermark"><img width="700" src="{{url('img/logo.jpg')}}"></div>
	<div class="format" style="margin-top: 1cm;">

		<table cellspacing="0" cellpadding="1" border="0" style="width: 100%">
			
			<tr>
				<td><b>FECHA INICIAL:</b> {{$inicio}}</td>
				<td><b>FECHA FINAL:</b> {{$final}}</td>

			</tr>
		</table>
		<hr width="16cm" style="margin-top: 0.3cm">
		<h3 style="margin-left: 7cm;">INGRESOS REGISTRADOS</h3>

		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; ">
			
			<?php $c_salto=0; ?>
			@foreach($ingresos as $numero=>$ingreso)
			
			<tr>
				<td>{{$numero+1}}</td>
				<td>
					<b>USUARIO:</b> {{$ingreso->NOM_USU.' '.$ingreso->PAT_USU.' '.$ingreso->MAT_USU}}<br>
					<b>FECHA:</b> {{$ingreso->FEC_ING}}<br>
					<b>PROVEEDOR:</b> {{$ingreso->NOM_PROV}}
				</td>
				<td>
					<?php $detalles=\App\IngresoDetalle::where('ID_ING',$ingreso->ID_ING)->join('producto','producto.ID_PRO','=','ingreso_detalle.ID_PRO')->get(); ?>
					@foreach($detalles as $detalle)
					<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; padding: 8px;">
						<tr>
							<td>
								<b>PRODUCTO: </b>{{$detalle->NOM_PRO}}
							</td>
						</tr>
						<tr>
							<td>
								<b>CANTIDAD: </b>{{$detalle->CANT_ID}}
							</td>
						</tr>

					</table>
					<?php $c_salto=$c_salto+1; ?>
					@endforeach
				</td>
			</tr>
			@if($c_salto>=16)
		</table>
		<div style="page-break-inside:avoid; page-break-after:always; " class="format"></div>
		<?php $contador=0 ?>
		<table cellspacing="0" cellpadding="1" border="1" style="width: 100%; margin-top: 1cm;">
			@endif
			@endforeach
		</table>
	</div>
</body>
</html>