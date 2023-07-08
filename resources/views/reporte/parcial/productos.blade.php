<div class="box-body">
	<div class="card-body">
		<div class="row">
			<h2 class="text-center">REPORTE POR PRODUCTO</h2>
			<div class="col-md-6"><label>PRODUCTO: {{$producto->NOM_PRO}}</label></div>
			<table class="table table-striped table-hover table-bordered">
				<tr class="info">
					<th>#</th>
					<th>PRODUCTO</th>
					<th>PRECIO COMPRA</th>
					<th>PRECIO VENTA</th>
					<th>FECHA</th>
					<th>CANTIDAD</th>
					<th>ESTADO</th>
					<th>ACCIONES</th>
				</tr>
				<?php
				 $sub_compra=0; 
				 $sub_venta=0; 
				 ?>
				@foreach($ventas as $numero=>$venta)
				<tr>
					<td>{{$numero+1}}</td>
					<td>{{$venta->NOM_PRO}}</td>
					<td>{{$venta->PRE_COM * $venta->CANT_PRO}} Bs.</td>
					<td>{{$venta->PRE_PRO * $venta->CANT_PRO}} Bs.</td>
					<td>{{$venta->FEC_VEN}}</td>
					<td>{{$venta->CANT_PRO}}/u</td>
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
					<?php 
					$sub_compra=$sub_compra+($venta->PRE_COM * $venta->CANT_PRO);
					$sub_venta=$sub_venta+($venta->PRE_PRO * $venta->CANT_PRO);
					 ?>
				</tr>
				@endforeach
			</table>
			<div class="text-center bg-info">
				
			<h4>TOTAL COMPRA: {{$sub_compra}} Bs.</h4>
			<h4>TOTAL VENTA: {{$sub_venta}} Bs.</h4>
			<h4 class="text-danger">TOTAL GANANCIA: {{$sub_venta-$sub_compra}} Bs.</h4>
			</div>
		</div>
	</div>
</div>
<!-- /.box-footer -->
<div class="modal-footer">
	<a href="{{url('reporte-productos/'.$producto->ID_PRO)}}" target="_blank" class="btn btn-danger pull-right"><i class="fa fa-print"></i> Imprimir</a>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
</div>