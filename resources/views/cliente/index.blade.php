@extends('layouts.master')
@section('cliente')
active
@endsection
@section('title')
CLIENTES
@endsection
@section('content')




<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">CLIENTE REGISTRADOS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR NUEVO CLIENTE</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>NOMBRE</th>
						<th>APELLIDO PATERNO</th>
						<th>APELLIDO MATERNO</th>
						<th>CEDULA IDENTIDAD</th>
						<th>EXPEDIDA</th>
						<th>FECCHA NACIMIENTO</th>
						<th>DIRECCION</th>
						<th>TELEFONO</th>
						<th>EMAIL</th>
						<th>ACCION</th>
					</tr>
				</thead>
				<tbody>
					@foreach($clientes as $numero=>$cliente)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$cliente->NOM_CLI}}</td>
						<td>{{$cliente->PAT_CLI}}</td>
						<td>{{$cliente->MAT_CLI}}</td>
						<td>{{$cliente->CI_CLI}}</td>
						<td>{{$cliente->EXP_CLI}}</td>
						<td>{{$cliente->FEC_NAC}}</td>
						<td>{{$cliente->DIR_CLI}}</td>
						<td>{{$cliente->TEL_CLI}}</td>
						<td>{{$cliente->EMAIL_CLI}}</td>

						<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalUpdate_{{$cliente->ID_CLI}}"><i class="fa fa-pencil"></i></button></td>
					</tr>
					<!--INICIO DE MODAL UPDATE-->
					<div class="modal fade scroller" id="modalUpdate_{{$cliente->ID_CLI}}" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<!-- /modal-header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h4 class="modal-title">EDITAR CLIENTE</h4>
								</div>

								<!-- /modal-body -->
								<div class="box-body">
									<div class="card-body">
										<form method="POST" action="{{route('cliente.update')}}" parsley-validate novalidate>
											{{csrf_field()}}
											<input type="hidden" name="id_cli" value="{{$cliente->ID_CLI}}">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CEDULA DE IDENTIDAD</label>
														<input type="text" class="form-control" name="ci_cli2" id="ci_cli2" value="{{$cliente->CI_CLI}}" required>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">EXPEDIDO:</label>
														<select class="form-control field" id="exp_cli" name="exp_cli" value="{{$cliente->EXP_CLI}}"> 	
															<option style="color: #c4bfbf;" disabled="" selected="" value="{{$cliente->EXP_CLI}}">{{$cliente->EXP_CLI}}</option>
															<option value="LP">LP</option>
															<option value="CBA">CBA</option>
															<option value="SCZ">SCZ</option>
															<option value="BNI">BNI</option>
															<option value="CHQ">CHQ</option>
															<option value="ORU">ORU</option>
															<option value="PND">PND</option>
															<option value="PSI">PSI</option>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">NOMBRE</label>
														<input type="text" class="form-control field" name="nom_cli" id="nom_cli" value="{{$cliente->NOM_CLI}}" required onkeyup="may(this);">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">APELLIDO PATERNO</label>
														<input type="text" class="form-control field" name="pat_cli" id="pat_cli" value="{{$cliente->PAT_CLI}}" required onkeyup="may(this);">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">APELLIDO MATERNO</label>
														<input type="text" class="form-control field" name="mat_cli" id="mat_cli" value="{{$cliente->MAT_CLI}}"required onkeyup="may(this);">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">FECHA DE NACIMIENTO</label>
														<input type="date" class="form-control field" name="fec_nac" id="fec_nac" value="{{$cliente->FEC_NAC}}"required >
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">DIRECCION</label>
														<input type="text" class="form-control field" name="dir_cli" id="dir_cli" value="{{$cliente->DIR_CLI}}"required onkeyup="may(this);">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">TELEFONO</label>
														<input type="text" class="form-control field" name="tel_cli" id="tel_cli" value="{{$cliente->TEL_CLI}}"required onkeyup="may(this);">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CORREO ELECTRONICO</label>
														<input type="text" class="form-control field" name="email_cli" id="email_cli" value="{{$cliente->EMAIL_CLI}}" >
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
					<!--FIN DE MODAL UPDATE-->
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
				<h4 class="modal-title">REGISTRO DE NUEVO CLIENTE</h4>
			</div>
			
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/cliente')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<legend>DATOS DEL CLIENTE</legend>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">CEDULA DE IDENTIDAD</label>
								<input type="text" class="form-control" name="ci_cli2" id="ci_cli2" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">EXPEDIDO:</label>
								<select class="form-control field" id="exp_cli" name="exp_cli"> 
									<option value="LP">LP</option>
									<option value="CBA">CBA</option>
									<option value="SCZ">SCZ</option>
									<option value="BNI">BNI</option>
									<option value="CHQ">CHQ</option>
									<option value="ORU">ORU</option>
									<option value="PND">PND</option>
									<option value="PSI">PSI</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">NOMBRE</label>
								<input type="text" class="form-control field" name="nom_cli" id="nom_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">APELLIDO PATERNO</label>
								<input type="text" class="form-control field" name="pat_cli" id="pat_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">APELLIDO MATERNO</label>
								<input type="text" class="form-control field" name="mat_cli" id="mat_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">FECHA DE NACIMIENTO</label>
								<input type="date" class="form-control field" name="fec_nac" id="fec_nac" required >
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">DIRECCION</label>
								<input type="text" class="form-control field" name="dir_cli" id="dir_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">TELEFONO</label>
								<input type="text" class="form-control field" name="tel_cli" id="tel_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">CORREO ELECTRONICO</label>
								<input type="text" class="form-control field" name="email_cli" id="email_cli"  >
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
	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
@endsection