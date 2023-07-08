@extends('layouts.master')
@section('venta')
active
@endsection
@section('title')
DETALLES DE LA VENTA A REALIZAR
@endsection
@section('content')


<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">DETALLES</h3>
	</div>
	<div class="box-body">
		<a href="{{url('/venta')}}" class="btn btn-default pull-left" ><i class="fa fa-share"></i> REGRESAR A VENTAS</a>
		@if($venta->EST_VEN==0)
		<button class="btn btn-success pull-right" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> AGREGAR PRODUCTO</button>
		@if(count($ubicaciones)==0)
		<button class="btn btn-warning pull-right" data-toggle="modal" data-target="#modalDireccion"><i class="fa fa-map-pin"></i> AGREGAR DIRECCION</button>
		@else
		<button class="btn btn-warning pull-right" type="button" disabled=""><i class="fa fa-map-pin"></i> DIRECCION AGREGADA</button>
		@endif
		@else
		<button class="btn btn-success pull-right disabled" ><i class="fa fa-check"></i> VENTA FINALIZADA</button>
		<!-- <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#modalObrero"><i class="fa fa-male"></i> ASIGNAR OBRERO</button> -->
		@endif
		<br>
		<br>
		<div class="row col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">CLIENTE</label>
					<input type="text" class="form-control" name="" value="{{$venta->NOM_CLI.' '.$venta->PAT_CLI.' '.$venta->MAT_CLI}}" readonly="">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">FECHA</label>
					<input type="text" class="form-control" name="" value="{{$venta->FEC_VEN}}" readonly="">
				</div>
			</div>
		</div>
		<div class="table-responsive col-md-12">
			<?php $total_cotizacion=0; ?>
			@if(count($cotizaciones)!=0)
			<table class="table table-bordered table-striped table-hover">
				<tr class="danger">
					<th colspan="5" class="text-center"><h4>VENTAS DE COTIZACIÓN</h4></th>
				</tr>
				<tr class="danger">
					<th>#</th>
					<th>PRODUCTO</th>
					<th>PRECIO UNITARIO</th>
					<th>MTS2</th>
					<th>CANTIDAD</th>
					<th>SUB TOTAL</th>
				</tr>
                <?php
                    $subMateriales = [];
                    foreach($cotizaciones as $numero=>$cotizacion){
                        if($cotizacion->RES_VC==0) {
                            $subMateriales[] = $cotizacion;
                            unset($cotizaciones[$numero]);
                        }
                    }
                ?>
				@foreach($cotizaciones as $numero=>$cotizacion)
    			<tr>
					<th>{{$numero+1}}</th>
					<th>{{$cotizacion->NOM_PRO}}</th>
					<th>{{$cotizacion->PRE_PRO}} Bs.</th>
					<th>{{$cotizacion->MTS_VC}}/Mts2</th>
					<th>{{$cotizacion->CANT_VC}}/u.</th>
					<th class="text-center"><h4><b>@if($cotizacion->RES_VC!=0) {{$cotizacion->RES_VC}} Bs.@endif</b></h4></th>
                </tr>
                    @foreach($subMateriales as $index=>$subMaterial)
					<tr>
                        <th></th>
					    <th>{{$subMaterial->NOM_PRO}}</th>
					    <th>{{$subMaterial->PRE_PRO}} Bs.</th>
					    <th>{{$subMaterial->MTS_VC}}/Mts2</th>
					    <th>{{$subMaterial->CANT_VC / count($cotizaciones) }}/u.</th>
					    <th class="text-center"></th>
                    </tr>
                    @endforeach
					<?php $total_cotizacion=$total_cotizacion+$cotizacion->RES_VC; ?>
				@endforeach
				@if($obrero_costos)
				<tr>
					<th></th>
					<th>ASIGNACIÓN DE OBRERO</th>
					<th>{{$obrero_costos->MTS2_OC}}/Mts2</th>
					<th>1</th>
					<th class="text-center"><h4><b>{{$obrero_costos->TOT_OC}} Bs.</b></h4></th>
					<?php $total_cotizacion=$total_cotizacion+$obrero_costos->TOT_OC; ?>
				</tr>
				@endif
			</table>
			@endif
			<table  class="table table-bordered table-striped table-hover">
				<thead>
					<tr class="success">
						<th colspan="7" class="text-center"><h4>VENTAS POR SEPARADO</h4></th>
					</tr>
					<tr class="success">
						<th>#</th>
						<th>PRODUCTO</th>
						<th>PRECIO UNITARIO</th>
						<th>CANTIDAD</th>
						<th>DESCUENTO</th>
						<th>SUB TOTAL</th>
                        @if($venta->EST_VEN==0)
						<th>ACCION</th>
                        @endif
					</tr>
				</thead>
				<tbody>
					<?php $total=0;
                    foreach( $detalles as $index=>$detalle) {
                        foreach( $productos as $index=>$producto) {
                            if( $detalle["ID_PRO"] == $producto["ID_PRO"] )
                                unset($productos[$index]);
                        }
                    }
                    ?>
					@foreach($detalles as $numero=>$detalle)
					<tr id='row{{$numero+1}}'>
						<td>{{$numero+1}}</td>
						<td>{{$detalle->NOM_PRO}}</td>
						<td>{{$detalle->PRE_UNI}} Bs.</td>
						<td>{{$detalle->CANT_PRO}} /u.</td>
						<td>{{$detalle->DESC_VEN}} %</td>
						<td><h4>{{$detalle->TOT_VEN}} Bs.</h4></td>
                        @if($venta->EST_VEN==0)
						<th>
							<form action="{{route('venta.eliminarproducto')}}" method="POST">
								{{csrf_field()}}
								<div class="">
									<input type="hidden" name="id_vd" id="id_vd" value="{{$detalle->ID_VD}}">
									<button type='submit' data-row='row{{$numero+1}}' title="Eliminar" class='btn btn-danger btn-xs remove-add-nuevogrupocarrera_1'><span class='fa fa-times'></span>
								</div>
							</form>
							<div class="">
								<input type="hidden" name="id_vd" id="id_vd" value="{{$detalle->ID_VD}}">
                                <button class="btn btn-warning btn-xs" title="Editar" data-toggle="modal" data-target="#modalEditar" onclick="busca_producto_editar({{$detalle->ID_PRO}}, {{$detalle->CANT_PRO}}, {{$detalle->ID_VD}});"><i class="fa fa-edit"></i></span></button>
							</div>
							<!-- <form action="{{url('/ventaDetalle/'.$detalle->ID_VD)}}" method="POST" parsley-validate novalidate>
								@csrf
								{{method_field('DELETE')}}
									<button type='submit' data-row='row{{$numero+1}}' class='btn btn-danger btn-xs remove-add-nuevogrupocarrera_1'><span class='fa fa-times'></span></button>
							</form> -->
						</th>
                        @endif
						<?php $total=$total+$detalle->TOT_VEN; ?>
					</tr>
					@endforeach
				</tbody>

				<tr>
					<td colspan="7" class="danger text-center">
						<h4>TOTAL A PAGAR: <b>{{$total=$total+$total_cotizacion}}</b> Bs.</h4>
					</td>
				</tr>
				@if(count($ubicaciones)!=0)
				@foreach($ubicaciones as $ubicacion)
				<tr class="warning">
					<td colspan="4">
						<b>UBICACION</b>: {{$ubicacion->UBI_UBI}}<br>
						<b>PRECIO ENVÍO</b>: {{$ubicacion->PRE_UBI}} Bs.
					</td>
					<td colspan="3">
					<?php $chofer=\App\User::find($venta->ID_USU_CH); ?>
						<b>CHOFER ASIGNADO:</b> {{$chofer->NOM_USU.' '.$chofer->PAT_USU.' '.$chofer->MAT_USU}}<br>
						<b>DESDE: </b>{{$venta->HOR_INI}} <b>HASTA: </b>{{$venta->HOR_FIN}}
					</td>
				</tr>
				@endforeach
				@endif
			</table>
			@if(count($cotizaciones)==0)
			<form method="POST" action="{{route('venta.empleado')}}" parsley-validate novalidate>
				{{csrf_field()}}
				<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
				<table class="table table-bordered">
					<tr class="info">
						<td>
							<div class="form-group">
								<select class="form-control" name="id_empl" id="id_empleado" required>
									<option selected="" value="" disabled="">-ASIGNAR EMPLEADO-</option>
									@foreach($empleados as $empleado)
									<option value="{{$empleado->ID_USU}}" {{$venta->ID_USU_ENC==$empleado->ID_USU?'selected':''}}>{{$empleado->NOM_USU.' '.$empleado->PAT_USU.' '.$empleado->MAT_USU}}</option>
									@endforeach
								</select>
							</div>
						</td>
						<td>
							<button type="submit" disabled="" class="btn btn-info btn-block" id="id_btn_asignar"><i class="fa fa-user"></i> ASIGNAR EMPLEADO</button>
						</td>
					</tr>
				</table>
			</form>
			@else
				@if($venta->ID_USU_ENC!=0)
				<table class="table table-bordered">
						<tr class="info">
							<td>
							@php $obrero=\App\User::find($venta->ID_USU_ENC); @endphp
								<h4><b>ASIGNADO AL OBRERO: {{$obrero->NOM_USU.' '.$obrero->PAT_USU.' '.$obrero->MAT_USU}}</b></h4>
							</td>
						</tr>
					</table>
				@endif
			@endif

		</div>
		@if($venta->EST_VEN!=0)
		<div class="col-md-6"><button type="button" disabled="" class="btn btn-danger btn-block disabled"><i class="fa fa-check"></i> VENTA FINALIZADA</button></div>
		<div class="col-md-6"><a href="{{url('recibo/'.$venta->ID_VEN)}}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-print"></i> IMPRIMIR FACTURA</a></div>
		@else
		<form action="{{route('venta.finaliza')}}" method="POST">
			{{csrf_field()}}
			<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
			<div class="col-md-6"><button type="submit" class="btn btn-danger btn-block" id="finalizarVenta"><i class="fa fa-check"></i> FINALIZAR VENTA</button></div>
		</form>
		@endif
	</div>
</div>
<!--INICIO DE MODAL NUEVO-->
<div class="modal fade scroller" id="modalNuevo"  role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">AGREGAR PRODUCTO</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/ventaDetalle')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PRODUCTO</label>
									<select class="form-control" name="id_pro" id="id_pro" style="width: 100%;" onchange="busca_producto();" required>
										<option selected="" disabled="">-SELECCIONE UN PRODUCTO-</option>
										@foreach($productos as $producto)
										<option value="{{$producto->ID_PRO}}">{{$producto->NOM_PRO}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PRECIO UNITARIO</label>
									<div class="input-group">
										<input type="text" class="form-control" name="pre_uni" id="pre_uni" readonly=""> <span class="input-group-addon">Bs.</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">UNIDADES DISPONIBLES</label>
									<div class="input-group">
										<input type="text" class="form-control" name="uni_dis" id="uni_dis" value="" readonly="" ><span class="input-group-addon">/Unidades</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CANTIDAD</label>
									<div class="input-group">
										<input type="text" class="form-control" name="cant_pro" id="cant_pro" readonly="" required onkeyup="cantidad(this)"><span class="input-group-addon">/Unidades</span>
									</div>
									<small class="text-danger">*La cantidad solicitada no puede superar a las unidades disponibles</small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">TOTAL</label>
									<div class="input-group">
										<input type="text" class="form-control" name="tot_ven" id="tot_ven" value="" readonly="" ><span class="input-group-addon">Bs.</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Añadir producto</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--FIN DE MODAL NUEVO-->
<!--INICIO DE EDITAR PRODUCTO-->
<div class="modal fade scroller" id="modalEditar"  role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">EDITAR PRODUCTO</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{route('venta.udateVenta')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
                                    <label for="exampleInputEmail1">PRODUCTO</label>
									<div class="input-group">
										<input type="text" class="form-control" name="pro_edit" id="pro_edit" readonly=""> <span class="input-group-addon"></span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PRECIO UNITARIO</label>
									<div class="input-group">
										<input type="text" class="form-control" name="pre_uni_edit" id="pre_uni_edit" readonly=""> <span class="input-group-addon">Bs.</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">UNIDADES DISPONIBLES</label>
									<div class="input-group">
										<input type="text" class="form-control" name="uni_dis_edit" id="uni_dis_edit" value="" readonly="" ><span class="input-group-addon">/Unidades</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CANTIDAD</label>
									<div class="input-group">
										<input type="text" class="form-control" name="cant_pro_edit" id="cant_pro_edit" required onkeyup="cantidadEdit(this)"><span class="input-group-addon">/Unidades</span>
									</div>
									<small class="text-danger">*La cantidad solicitada no puede superar a las unidades disponibles</small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">TOTAL</label>
									<div class="input-group">
										<input type="text" class="form-control" name="tot_ven_edit" id="tot_ven_edit" value="" readonly="" ><span class="input-group-addon">Bs.</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-footer -->
				<div class="modal-footer">
                    <input type="hidden" name="id_vd_edit" id="id_vd_edit">
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Editar producto</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--FIN DE EDITAR PRODUCTO-->
<!--INICIO DE MODAL OBREROS-->
<div class="modal fade scroller" id="modalObrero" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">LISTA DE OBREROS DISPONIBLES</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/ventaDetalle')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
						<div class="row">
							<?php $contador=0; ?>
							@foreach($obreros as $obrero)
							<div class="col-lg-12">
								<div class="input-group">
									<span class="input-group-addon">
										<input type="radio" name="obrero" value="{{$obrero->ID_USU}}">
									</span>
									<input type="text" class="form-control" value="{{$obrero->NOM_USU.' '.$obrero->PAT_USU.' '.$obrero->MAT_USU}}" readonly="">
									<span class="input-group-addon">
										<i class="fa fa-male"></i>
									</span>
								</div>
								<!-- /input-group -->
							</div>
							<?php $contador++; ?>
							@endforeach




						</div>
					</div>
				</div>
				<!-- /.box-footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Asignar obrero</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--FIN DE MODAL OBREROS-->

<!-- Modal -->
<div class="modal fade" id="modalDireccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">AGREGAR DIRECCION</h4>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('venta.ubicacion')}}" parsley-validate novalidate>
					{{csrf_field()}}
					<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
					<input type="hidden" name="lat_ubi" id="lat_ubi" value="">
					<input type="hidden" name="lon_ubi" id="lon_ubi" value="">

					<input type="hidden" id="latitud_new" name="latitud_new" class="coords" /><br>
					<input type="hidden" id="longitud_new" name="longitud_new" class="coords" />
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">PRECIO ENVÍO</label>
							@if($total>=4000)
							<div class="input-group">
								<input type="number" class="form-control" name="pre_ubi" id="pre_ubi" value="0" readonly="" required> <span class="input-group-addon">Bs.</span>
							</div>
							<p class="text-success">*El total del pedido es mayor a 4000 Bs. por lo tanto el envio es GRATIS</p>
							@else
							<div class="input-group">
								<input type="number" class="form-control" name="pre_ubi" id="pre_ubi" value="" required> <span class="input-group-addon">Bs.</span>
							</div>
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="exampleInputEmail1">DIRECCION</label>
							<input type="text" class="form-control" name="ubi_ubi" id="ubi_ubi" value="" readonly="" required>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 modal_body_map">
							<div class="location-map" id="location-map">
								<div style="width: 850px; height: 200px;" id="map"></div>
							</div>
						</div>
					</div>
					<br>
					<div class="row col-md-12">
						<div class="col-md-4 form-group">
							<label>ASIGNE UN CHOFER:</label>
							<select class="form-control" name="id_usu_ch" id="id_usu_ch">
								<option selected="" disabled="">-ESCOJA UN CHOFER-</option>
								@foreach($choferes as $chofer)
								<option value="{{$chofer->ID_USU}}">{{$chofer->NOM_USU.' '.$chofer->PAT_USU.' '.$chofer->MAT_USU}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-2 form-group">
							<label>HORA INICIO</label>
							<input type="text" class="form-control datetimepicker" name="hor_ini" id="hor_ini" value="">
						</div>
						<div class="col-md-2 form-group">
							<label>HORA FINAL</label>
							<input type="text" class="form-control datetimepicker" name="hor_fin" id="hor_fin" value="">
						</div>
						<div class="col-md-3 form-group">
							<label>FECHA</label>
							<input type="date" class="form-control " name="fec_env" id="fec_env" value="">
						</div>
						<div class="col-md-1">
							<label></label>
							<button type="button" class="btn btn-warning btn-lg"  onclick="chofer()"><i class="fa fa-search"></i></button>
						</div>
					</div>
					<div id="div_chofer" class="row col-md-12"></div>

				</div>
				<div class="modal-footer">

				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$('#id_pro').select2();
    var arrayDetalles=<?php echo json_encode($detalles);?>;
    if (document.getElementById('id_empleado') != null){
        console.log("entra")
        let empleado = document.getElementById('id_empleado').value;
        changeEmp();
        document.getElementById('id_empleado').addEventListener("change", function () {
        if (empleado == this.value) {
            document.getElementById('id_btn_asignar').disabled = true;
        } else {
            document.getElementById('id_btn_asignar').disabled = false;
        }
    })

    }
    function changeEmp() {
        let empleado = document.getElementById('id_empleado').value;
        let finalizarVenta = document.getElementById('finalizarVenta');
        if (finalizarVenta == null) {
            return;
        }
        if( empleado != "" && arrayDetalles.length > 0) {
            document.getElementById('finalizarVenta').disabled = false;
        } else {
            document.getElementById('finalizarVenta').disabled = true;
        }
    }

	$(document).on('click','.remove-add-nuevogrupocarrera_1',function(){
        var id_prod = $((this).parent().parent().children().second().text());
        var delete_row = $(this).data("row");
        $('#'+delete_row).remove();
    });

	function busca_producto(){
		var id_pro = $('#id_pro').val();
		var route= "{{route('producto.busca')}}";
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',
			data: {"id_pro": id_pro},
			success: function(data){
				console.log(data);
				$('#pre_uni').val(data.PRE_PRO);
				$('#uni_dis').val(data.EXT_PRO);
				if (data.EXT_PRO==0) {
					$('#cant_pro').attr('readonly',true);
					$.notify({icon:'<i class="fa fa-ban"></i> ',title:' <strong>ERROR!</strong></br>',message:"{{'  El producto que selecciono se encuentra AGOTADO, porfavor seleccione otro PRODUCTO'}}"},{z_index: 2000, type:'danger',animate:{enter:'animated fadeInDown',exit:'animated fadeOutUp'}});
					$('#cant_pro').val('');

				}else{
					$('#cant_pro').attr('readonly',false);
				}
			},
			error: function(data){
				console.log(data);
			}
		});
	}

	function busca_producto_editar(id_pro, cant_pro, id_vd){
        console.log("editar", id_pro);
		var route= "{{route('producto.busca')}}";
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',
			data: {"id_pro": id_pro},
			success: function(data){
				console.log(data);
 				$('#pro_edit').val(data.NOM_PRO);
                 $('#pre_uni_edit').val(data.PRE_PRO);
                 $('#uni_dis_edit').val(data.EXT_PRO + cant_pro);
                 $('#cant_pro_edit').val(cant_pro);
                 $('#id_vd_edit').val(id_vd);
                 cantidadEdit(cant_pro)
                },
			error: function(data){
				console.log(data);
			}
		});
	}
    function cantidadEdit(input){
		if (input.value>parseInt($('#uni_dis_edit').val())) {input.value=$('#uni_dis_edit').val()}
			var cantidad = $('#cant_pro_edit').val() == "" ? 0 : parseInt($('#cant_pro_edit').val());
		var precio=parseFloat($('#pre_uni_edit').val());
		console.log($('#pre_uni_edit').val(), cantidad);
		$('#tot_ven_edit').val(cantidad*precio);
	}
</script>
<script type="text/javascript">
	function chofer(){
		var id_usu_ch=$('#id_usu_ch').val();
		var hor_ini=$('#hor_ini').val();
		var hor_fin=$('#hor_fin').val();
		var fec_env=$('#fec_env').val();
		var route= "{{route('venta.chofer')}}";
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',
			data: {id_usu_ch: id_usu_ch, hor_ini:hor_ini, hor_fin:hor_fin, fec_env:fec_env},
			success: function(data){
				console.log(data);
				$('#div_chofer').html(data);
			},
			error: function(data){
				console.log(data);
			}
		});
	}
</script>
<script type="text/javascript">
	function cantidad(input){
		if (input.value>parseInt($('#uni_dis').val())) {input.value=$('#uni_dis').val()}
			var cantidad=$('#cant_pro').val() == "" ? 0 : parseInt($('#cant_pro').val());
		var precio=parseFloat($('#pre_uni').val());
		console.log($('#pre_uni').val());
		$('#tot_ven').val(cantidad*precio);
	}
</script>
<script>


var marker;          //variable del marcador
var coords = {};    //coordenadas obtenidas con la geolocalización
var latitud_mia=$('#lat_ubi').val();
var longitud_mia=$('#lon_ubi').val();
if (latitud_mia=='') {latitud_mia='-16.49548807954866'}
	if (longitud_mia=='') {longitud_mia='-68.13338436646728'}
		console.log(latitud_mia);
//Funcion principal
initMap = function ()
{

    //usamos la API para geolocalizar el usuario
    navigator.geolocation.getCurrentPosition(
    	function (position){
    		coords =  {
    			lng: position.coords.longitude,
    			lat: position.coords.latitude
    		};
            setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa


        },function(error){console.log(error);});

}



function setMapa (coords)
{
      //Se crea una nueva instancia del objeto mapa
      var map = new google.maps.Map(document.getElementById('map'),
      {
      	zoom: 13,

        //center:new google.maps.LatLng(coords.lat,coords.lng),//esto capturaba la ubicacion actual de la pc
        center:new google.maps.LatLng(latitud_mia,longitud_mia),

    });
      //geocoder me permite capturar la direccion a la que apunta mis coordenadas
      var geocoder = new google.maps.Geocoder();
      console.log(geocoder);
      //Creamos el marcador en el mapa con sus propiedades
      //para nuestro obetivo tenemos que poner el atributo draggable en true
      //position pondremos las mismas coordenas que obtuvimos en la geolocalización
      marker = new google.maps.Marker({
      	map: map,
      	draggable: true,
      	animation: google.maps.Animation.DROP,
        //position: new google.maps.LatLng(coords.lat,coords.lng),

        //position: new google.maps.LatLng(coords.lat,coords.lng),//esto capturaba la ubicacion actual de la pc
        position: new google.maps.LatLng(latitud_mia,longitud_mia),

    });
      //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
      //cuando el usuario a soltado el marcador
      marker.addListener('click', toggleBounce);

      marker.addListener( 'dragend', function (event)
      {
        //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
        document.getElementById("latitud_new").value = this.getPosition().lat();
        document.getElementById("longitud_new").value = this.getPosition().lng();
    });


      google.maps.event.addListener(marker,'position_changed',function () {
      	var lat = marker.getPosition().lat();
      	var lng = marker.getPosition().lng();
      	$('#latitud_new').val(lat);
      	$('#longitud_new').val(lng);
      	geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
      		if (status == google.maps.GeocoderStatus.OK) {
      			var address = results[0]['formatted_address'];
      			var lat = results[0].geometry.location.lat();
      			var lng = results[0].geometry.location.lng();

                        //con este codigo muestro la direccion a la que apuntan mis coordenadas
                        $('#ubi_ubi').val(address);
                    }
                });
      });
  }

//callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce() {
	if (marker.getAnimation() !== null) {
		marker.setAnimation(null);
	} else {
		marker.setAnimation(google.maps.Animation.BOUNCE);
	}
}


// Carga de la libreria de google maps

</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDw85SWy6oYum_19rBl6SVsv8YJ2WGvcVY&sensor=false&callback=initMap"></script>
<script type="text/javascript">
$('.datetimepicker').datetimepicker({
	icons:
	{
		up: 'fa fa-angle-up',
		down: 'fa fa-angle-down',
		next: 'fa fa-angle-right',
		previous: 'fa fa-angle-left'
	},
	format: 'HH:mm',

});

</script>
@endsection
