@extends('layouts.master')
@section('proveedor')
active
@endsection
@section('title')
PROVEEDORES
@endsection
@section('content')




<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">PROVEEDORES REGISTRADAS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR NUEVO PROVEEDOR</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>NOMBRE</th>
						<th>DIRECCION</th>
						<th>TELEFONO</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					@foreach($proveedores as $numero=>$proveedor)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$proveedor->NOM_PROV}}</td>
						<td>{{$proveedor->DIR_PROV}}</td>
						<td>{{$proveedor->TEL_PROV}}</td>
						<td><button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalUpdate_{{$proveedor->ID_PROV}}"><i class="fa fa-pencil"></i></button></td>
					</tr>
					<!--INICIO DE MODAL NUEVO-->
					<div class="modal fade scroller" id="modalUpdate_{{$proveedor->ID_PROV}}" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<!-- /modal-header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h4 class="modal-title">EDITA PRESENTACION</h4>
								</div>
								<!-- /modal-body -->
								<div class="box-body">
									<div class="card-body">
										<form method="POST" action="{{route('proveedor.update')}}" parsley-validate novalidate>
											{{csrf_field()}}
											<input type="hidden" name="id_prov" value="{{$proveedor->ID_PROV}}">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">NOMBRE DEL PROVEEDOR</label>
														<input type="text" class="form-control" name="nom_prov_u" onkeyup="may(this);" required value="{{$proveedor->NOM_PROV}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">DIRECCION</label>
														<input type="text" class="form-control" name="dir_prov_u" required onkeyup="may(this);" value="{{$proveedor->DIR_PROV}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">TELEFONO</label>
														<input type="text" class="form-control" name="tel_prov_u" required onkeyup="may(this);" value="{{$proveedor->TEL_PROV}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CORRERO ELECTRONICO</label>
														<input type="text" class="form-control" name="email_prov_u" required value="{{$proveedor->EMAIL_PROV}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">DESCRIPCION</label>
														<textarea name="des_prov_u" class="form-control">{{$proveedor->DES_PROV}}</textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /.box-footer -->
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Actualizar</button>
										<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!--FIN DE MODAL NUEVO-->
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
</div>

<!--INICIO DE MODAL NUEVO-->
<div class="modal fade scroller" id="modalNuevo" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">REGISTRO DE NUEVO PROVEEDOR</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/proveedor')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">NOMBRE DEL PROVEEDOR</label>
									<input type="text" class="form-control  may lc" name="nom_prov" onkeyup="may(this);" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">DIRECCION</label>
									<input type="text" class="form-control may" name="dir_prov" required onkeyup="may(this);">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">TELEFONO</label>
									<input type="number" class="form-control" name="tel_prov" required onkeyup="may(this);">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CORRERO ELECTRONICO</label>
									<input type="text" class="form-control min" name="email_prov" required >
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">DESCRIPCION</label>
									<textarea name="des_prov may" class="form-control" ></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Registrar</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--FIN DE MODAL NUEVO-->
@endsection
@section('js')
<script type="text/javascript">
	$('#permisos').select2({
		width: "100%",
		theme: "material"
	});
	
</script>
@endsection