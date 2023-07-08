<div class="box-body">
	<div class="card-body">
		<div class="row">
			<h2 class="text-center">VENTAS POR RANGO DE FECHAS</h2>
			<div class="col-md-6"><label>FECHA INICIO: {{$request->inicio}}</label></div>
			<div class="col-md-6"><label>FECHA FINAL: {{$request->final}}</label></div>
			<table class="table table-striped table-hover table-bordered">
				<tr class="info">
					<th>#</th>
					<th>CLIENTE</th>
					<th>USUARIO</th>
					<th>FECHA</th>
					<th>HORA</th>
					<th>ESTADO</th>
					<th>ACCIONES</th>
				</tr>
				@foreach($ventas as $numero=>$venta)
				<tr>
					<td>{{$numero+1}}</td>
					<td>{{$venta->NOM_CLI.' '.$venta->PAT_CLI.' '.$venta->MAT_CLI}}</td>
					<td>{{$venta->NOM_USU.' '.$venta->PAT_USU.' '.$venta->MAT_USU}}</td>
					<td>{{$venta->FEC_VEN}}</td>
					<td>{{$venta->HOR_VEN}}</td>
					@if($venta->EST_VEN==0)
					<td><span class="label bg-red">PENDIENTE</span></td>
					@elseif($venta->EST_VEN==1)
					<td><span class="label bg-blue">ASIGNADO</span></td>
					@else
					<td><span class="label bg-green">FINALIZADO</span></td>
					@endif
					<td>
						<a href="{{url('registro/venta/'.$venta->ID_VEN)}}" target="_blank" class="btn btn-success" title="Ver detalles"><i class="fa fa-mail-forward"></i></a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
<!-- /.box-footer -->
<div class="modal-footer">
	<a href="{{url('reporte-fechas/'.$request->inicio.'/'.$request->final)}}" target="_blank" class="btn btn-danger pull-right"><i class="fa fa-print"></i> Imprimir</a>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
</div>