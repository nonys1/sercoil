@extends('layouts.master')
@section('home')
active
@endsection
@section('title')
BIENVENIDO AL SISTEMA
@endsection
@section('content')

@role(['admin','jefe'])
<div class="col-lg-4 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-red">
		<div class="inner">
			<h3>{{count($agotados)}}</h3>
			<p>PRODUCTOS POR AGOTARSE</p>
		</div>
		<div class="icon">
			<i class="fa fa-exclamation-circle"></i>
		</div>
		<a href="#" data-toggle="modal" data-target="#modalAgotados" class="small-box-footer"> Mas información <i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<div class="col-lg-4 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-green">
		<div class="inner">
			<h3>{{count($usuarios)}}</h3>
			<p>USUARIOS REGISTRADOS</p>
		</div>
		<div class="icon">
			<i class="fa fa-users"></i>
		</div>
		<a href="#" data-toggle="modal" data-target="#modalUsuarios" class="small-box-footer"> Mas información <i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
<div class="col-lg-4 col-xs-6">
	<!-- small box -->
	<div class="small-box bg-yellow">
		<div class="inner">
			<h3>{{count($ventas_mes)}}</h3>
			<p>VENTAS MES ACTUAL</p>
		</div>
		<div class="icon">
			<i class="fa fa-calendar"></i>
		</div>
		<a href="#" data-toggle="modal" data-target="#modalVentas" class="small-box-footer"> Mas información <i class="fa fa-arrow-circle-right"></i>
		</a>
	</div>
</div>
@endrole
@role(['obrero','empleado'])
<h1 class="text-center text-danger">TRABAJOS ASIGNADOS PENDIENTES</h1>
<p class="text-center text-danger">Se le mostrará los trabajos que se le asignaron a su persona </p>
@foreach($asignados as $asignado)
<div class="col-md-6 col-sm-6 col-xs-12">
	<div class="info-box">
		<span class="info-box-icon bg-red"><i class="fa fa-star animated fadeIn infinite"></i></span>
		<div class="info-box-content">
			<button class="btn btn-warning"  data-toggle="modal" data-target="#modalObrero_{{$asignado->ID_VEN}}"><i class="fa fa-info"></i></button>
			
			<span class="info-box-text"><b>ENCARGADO:</b> {{$asignado->NOM_USU.' '.$asignado->PAT_USU.' '.$asignado->MAT_USU}}</span>
			<span class="info-box-text"><b>CLIENTE:</b> {{$asignado->NOM_CLI.' '.$asignado->PAT_CLI.' '.$asignado->MAT_CLI}}</span>
			<span class="info-box-text"><b>FECHA:</b> {{$asignado->FEC_VEN}}</span>
			<span class="info-box-text"><b>ESTADO:</b> <span class="label bg-yellow">PENDIENTE</span></span>
		</div>
		<!-- /.info-box-content -->
	</div>
	<!-- /.info-box -->
</div>
<!--INICIO DE MODAL NUEVO-->
					<div class="modal fade scroller" id="modalObrero_{{$asignado->ID_VEN}}" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<!-- /modal-header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h4 class="modal-title">DETALLES DEL TRABAJO</h4>
								</div>
								<!-- /modal-body -->
								<div class="box-body">
									<div class="card-body">
											{{csrf_field()}}
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">ENCARGADO:</label>
														<input type="text" class="form-control" name="" readonly="" value="{{$asignado->NOM_USU.' '.$asignado->PAT_USU.' '.$asignado->MAT_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CLIENTE:</label>
														<input type="text" class="form-control" name="" readonly="" value="{{$asignado->NOM_CLI.' '.$asignado->PAT_CLI.' '.$asignado->MAT_CLI}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">FECHA:</label>
														<input type="text" class="form-control" name="" readonly="" value="{{$asignado->FEC_VEN}}">
													</div>
												</div>
												<?php $ubicaciones=\App\Ubicacion::where('ID_VEN',$asignado->ID_VEN)->get(); ?>
												<?php $mts=\App\VentaCotizacion::where('ID_VEN',$asignado->ID_VEN)->first(); ?>
												<?php $cotizaciones=\App\VentaCotizacion::where('ID_VEN',$asignado->ID_VEN)->join('producto','producto.ID_PRO','=','venta_cotizacion.ID_PRO')->get(); ?>
												@if(count($ubicaciones)!=0)
												@foreach($ubicaciones as $ubicacion)
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">UBICACIÓN:</label>
														<input type="text" class="form-control" name="" readonly="" value="{{$ubicacion->UBI_UBI}}">
													</div>
												</div>
												@endforeach
												@endif

												@if($mts)
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">MTS 2:</label>
														<input type="text" class="form-control" name="" readonly="" value="{{$mts->MTS_VC}}">
													</div>
												</div>
												@endif
												
												@if(count($cotizaciones)!=0)
												@foreach($cotizaciones as $cotizacion)
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CANTIDAD DE {{$cotizacion->NOM_PRO}}:</label>
														<input type="text" class="form-control" name="" readonly="" value="{{$cotizacion->CANT_VC}} /Unidades">
													</div>
												</div>
												@endforeach
												@endif

												<?php $detalles=\App\VentaDetalle::where('ID_VEN',$asignado->ID_VEN)->join('producto','producto.ID_PRO','=','venta_detalle.ID_PRO')->get(); ?>
												@role('empleado')
												@if(count($detalles)!=0)
												<table class="table table-bordered table-striped text-center">
													<tr class="danger">
														<th>#</th>
														<th>PRODUCTO</th>
														<th>CANTIDAD</th>
													</tr>
													@foreach($detalles as $numero=>$detalle)
													<tr>
														<td>{{$numero+1}}</td>
														<td>{{$detalle->NOM_PRO}}</td>
														<td>{{$detalle->CANT_PRO}} /Unidades</td>
													</tr>
													@endforeach
												</table>
												@endif
												@endrole
												
												
											</div>
										</div>
									</div>
									<!-- /.box-footer -->
									<div class="modal-footer">
										<button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
									</div>
							</div>
						</div>
					</div>
					<!--FIN DE MODAL NUEVO-->
@endforeach
@endrole

<!--INICIO DE MODAL NUEVO-->
<div class="modal fade scroller" id="modalAgotados" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">LISTADO DE PRODUCTOS PROXIMOS A AGOTARSE</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr>
								<th>#</th>
								<th>PRODUCTO</th>
								<th>EXISTENCIA ACTUAL</th>
								<th></th>
							</tr>
							@foreach($agotados as $numero=>$agotado)
							<tr>
								<td>{{$numero+1}}</td>
								<td>{{$agotado->NOM_PRO}}</td>
								<td>{{$agotado->EXT_PRO}} (Unidades)</td>
								<td>
									@if($agotado->EXT_PRO==0)
									<span class="label bg-red animated fadeIn infinite">AGOTADO</span>
									@else
									<span class="label bg-yellow">MENOS DE 20</span>
									@endif
								</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
			<!-- /.box-footer -->
			<div class="modal-footer">
				
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--FIN DE MODAL NUEVO-->  
<!--INICIO DE MODAL USUARIOS-->
<div class="modal fade scroller" id="modalUsuarios" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">LISTADO DE USUARIOS REGISTRADOS</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr>
								<th>#</th>
								<th>NOMBRE</th>
								<th>CI</th>
								<th>CARGO</th>
							</tr>
							@foreach($usuarios as $numero=>$usuario)
							<tr>
								<td>{{$numero+1}}</td>
								<td>{{$usuario->NOM_USU.' '.$usuario->PAT_USU.' '.$usuario->MAT_USU}}</td>
								<td>{{$usuario->CI_USU.' '.$usuario->EXT_USU}}</td>
								<td>{{$usuario->display_name}}</td>
								
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
			<!-- /.box-footer -->
			<div class="modal-footer">
				
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--FIN DE MODAL USUARIOS-->      
<!--INICIO DE MODAL VENTAS-->
<div class="modal fade scroller" id="modalVentas" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">LISTADO DE VENTAS DEL MES ACTUAL</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr>
								<th>#</th>
								<th>USUARIO</th>
								<th>CLIENTE</th>
								<th>FECHA</th>
								<th>ESTADO</th>
							</tr>
							@foreach($ventas_mes as $numero=>$vm)
							<tr>
								<td>{{$numero+1}}</td>
								<td>{{$vm->NOM_USU.' '.$vm->PAT_USU.' '.$vm->MAT_USU}}</td>
								<td>{{$vm->NOM_CLI.' '.$vm->PAT_CLI.' '.$vm->MAT_CLI}}</td>
								<td>{{$vm->FEC_VEN}}</td>
								@if($vm->EST_VEN==0)
								<td><span class="label bg-yellow">PENDIENTE</span></td>
								@elseif($vm->EST_VEN==1)
								<td><span class="label bg-blue">ASIGNADO</span></td>
								@elseif($vm->EST_VEN==2)
								<td><span class="label bg-blue">ENTREGADO</span></td>
								@elseif($vm->EST_VEN==3)
								<td><span class="label bg-green">FINALIZADO</span></td>
								@else
								<td></td>
								@endif
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
			<!-- /.box-footer -->
			<div class="modal-footer">
				
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--FIN DE MODAL VENTAS-->        
@endsection