@extends('layouts.master')
@section('usuario')
active
@endsection
@section('title')
USUARIOS DEL SISTEMA
@endsection
@section('content')
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">USUARIOS REGISTRADOS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR NUEVO USUARIO</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>NOMBRE</th>
						<th>CI</th>
						<th>USUARIO</th>
						<th>ROL</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					@foreach($usuarios as $numero=>$usuario)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$usuario->NOM_USU.' '.$usuario->PAT_USU.' '.$usuario->MAT_USU}}</td>
						<td>{{$usuario->CI_USU.' '.$usuario->EXP_USU}}</td>
						<td>{{$usuario->USU_USU}}</td>
						<td><span class="label bg-green">{{$usuario->display_name}}</span></td>
						<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalUpdate_{{$usuario->ID_USU}}"><i class="fa fa-pencil"></i></button></td>
					</tr>
					<!--INICIO DE MODAL UPDATE-->
					<div class="modal fade scroller" id="modalUpdate_{{$usuario->ID_USU}}" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<!-- /modal-header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
									<h4 class="modal-title" id="myModalLabel">EDITA USUARIO</h4>
								</div>
								<!-- /modal-body -->
								<div class="modal-body">
									<div class="box-body">
										<form method="POST" action="{{route('usuario.update')}}" parsley-validate novalidate>
											{{csrf_field()}}
											<input type="hidden" name="id_usu" value="{{$usuario->ID_USU}}">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">NOMBRES</label>
														<input type="text" class="form-control  may letras lc" name="nom_usu_u" required value="{{$usuario->NOM_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">APELLIDO PATERNO</label>
														<input type="text" class="form-control  may letras lc" name="pat_usu_u" required value="{{$usuario->PAT_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">APELLIDO MATERNO</label>
														<input type="text" class="form-control  may letras lc" name="mat_usu_u" required value="{{$usuario->MAT_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CORREO ELECTRONICO</label>
														<input type="text" class="form-control min" name="email_u" required value="{{$usuario->email}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">USUARIO</label>
														<input type="text" class="form-control min" name="usu_usu_u" required value="{{$usuario->USU_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CI</label>
														<input type="text" class="form-control num ln" name="ci_usu_u" required value="{{$usuario->CI_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">EXP</label>
														<select class="form-control" name="exp_usu_u" required>
															<option value="LP" {{$usuario->EXP_USU=='LP'?'selected':''}}>LP</option>
															<option value="CBA" {{$usuario->EXP_USU=='CBA'?'selected':''}}>CBA</option>
															<option value="SCZ" {{$usuario->EXP_USU=='SCZ'?'selected':''}}>SCZ</option>
															<option value="BNI" {{$usuario->EXP_USU=='BNI'?'selected':''}}>BNI</option>
															<option value="CHQ" {{$usuario->EXP_USU=='CHQ'?'selected':''}}>CHQ</option>
															<option value="ORU" {{$usuario->EXP_USU=='ORU'?'selected':''}}>ORU</option>
															<option value="PND" {{$usuario->EXP_USU=='PND'?'selected':''}}>PND</option>
															<option value="PSI" {{$usuario->EXP_USU=='PSI'?'selected':''}}>PSI</option>
															<option value="TJA" {{$usuario->EXP_USU=='TJA'?'selected':''}}>TJA</option>
														</select>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CONTRASEÑA</label>
														<input type="text" class="form-control" name="password_u" >
														<small class="text-danger">*Complete solo si desea cambiar la contraseña al usuario</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">DIRECCION</label>
														<input type="text" class="form-control may" name="dir_usu_u" required value="{{$usuario->DIR_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CELULAR</label>
														<input type="number" class="form-control" name="tel_usu_u" required value="{{$usuario->CEL_USU}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">ROL</label>
														<select class="form-control" name="id_rol_u" id="id_rol_u" required>
															<option selected="" disabled="">-SELECCIONE ROL-</option>
															@foreach($roles as $rol)
															<option value="{{$rol->id}}" {{$usuario->roles()->first()->name==$rol->name?'selected':''}}>{{$rol->display_name}}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /.box-footer -->
									<div class="modal-footer">
										<button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
										<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Actualizar</button>
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
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">REGISTRO USUARIO</h4>
			</div>
			<!-- /modal-body -->
			<div class="modal-body">
				<div class="box-body">
					<form method="POST" action="{{url('/usuario')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">NOMBRES</label>
									<input type="text" class="form-control may letras lc ao" name="nom_usu" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">APELLIDO PATERNO</label>
									<input type="text" class="form-control may letras lc ao" name="pat_usu" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">APELLIDO MATERNO</label>
									<input type="text" class="form-control may letras lc ao" name="mat_usu" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CORREO ELECTRONICO</label>
									<input type="text" class="form-control min" name="email" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">USUARIO</label>
									<input type="text" class="form-control min ao" name="usu_usu" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CI</label>
									<input type="text" class="form-control num ln ao" name="ci_usu" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">EXP</label>
									<select class="form-control" name="exp_usu" required>
										<option  value="LP">LP</option>
										<option value="CBA">CBA</option>
										<option value="SCZ">SCZ</option>
										<option value="BNI">BNI</option>
										<option value="CHQ">CHQ</option>
										<option value="ORU">ORU</option>
										<option value="PND">PND</option>
										<option value="PSI">PSI</option>
										<option value="TJA">TJA</option>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CONTRASEÑA</label>
									<input type="text" class="form-control ao" name="password" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">DIRECCION</label>
									<input type="text" class="form-control may ao" name="dir_usu" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CELULAR</label>
									<input type="number" class="form-control ao ln" name="tel_usu" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">ROL</label>
									<select class="form-control" name="id_rol" id="id_rol" required>
										<option selected="" disabled="">-SELECCIONE ROL-</option>
										@foreach($roles as $rol)
										<option value="{{$rol->id}}">{{$rol->display_name}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Registrar</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--FIN DE MODAL NUEVO-->
@endsection