@extends('layouts.master')
@section('producto')
active
@endsection
@section('title')
PRODUCTOS
@endsection
@section('content')




<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">PRODUCTOS REGISTRADOS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR NUEVO PRODUCTO</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>PRODUCTO</th>
						<th>CATEGORIA</th>
						<th>DESCRIPCION</th>
						<th>EXISTENCIA</th>
						<th>IMAGEN</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					@foreach($productos as $numero=>$producto)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$producto->NOM_PRO}}</td>
						<td>{{$producto->NOM_CAT}}</td>
						<td>{{$producto->DES_PRO}}</td>
						<td>{{$producto->EXT_PRO}}</td>
						<td width="10%" class="text-center"><img class="img-thumbnail" width="70%" src="{{url($producto->IMG_PRO)}}"></td>
						<td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalUpdate_{{$producto->ID_PRO}}"><i class="fa fa-pencil"></i></button></td>
					</tr>
					<!--INICIO DE MODAL UPDATE-->
					<div class="modal fade scroller" id="modalUpdate_{{$producto->ID_PRO}}" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<!-- /modal-header -->
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
									<h4 class="modal-title">EDITA PRODUCTO</h4>
								</div>

								<!-- /modal-body -->
								<div class="box-body">
									<div class="card-body">
										<form method="POST" action="{{route('producto.update')}}" enctype="multipart/form-data" parsley-validate novalidate>
											{{csrf_field()}}
											<input type="hidden" name="id_pro" value="{{$producto->ID_PRO}}">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">NOMBRE DEL PRODUCTO</label>
														<input type="text" class="form-control may" name="nom_pro_u" onkeyup="may(this);" required value="{{$producto->NOM_PRO}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">DESCRIPCION</label>
														<input type="text" class="form-control may" name="des_pro_u" onkeyup="may(this);" required value="{{$producto->DES_PRO}}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">PRECIO DE COMPRA EN BOLIVIANOS</label>
														<div class="input-group">
															<input type="number" class="form-control" name="pre_com_u" required value="{{$producto->PRE_COM}}">
															<span class="input-group-addon">Bs.</span>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">PRECIO DE VENTA EN BOLIVIANOS</label>
														<div class="input-group">
															<input type="number" class="form-control" name="pre_ven_u" required value="{{$producto->PRE_PRO}}">
															<span class="input-group-addon">Bs.</span>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">CATEGORIA</label>
														<select class="form-control" name="id_cat_u" id="id_cat_u" required>
															<option selected="" disabled="">-SELECCIONE CATEGORIA-</option>
															@foreach($categorias as $categoria)
															<option {{$categoria->ID_CAT==$producto->ID_CAT?'selected':''}} value="{{$categoria->ID_CAT}}">{{$categoria->NOM_CAT}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">TIPO DE COTIZACION</label>
														<select class="form-control" name="id_tip_u" id="id_tip_u">
															<option {{$producto->ID_TIP==0?'selected':''}} value="0">-NINGUNO-</option>
															@foreach($tipos as $tipo)
															<option {{$producto->ID_TIP==$tipo->ID_TIP?'selected':''}} value="{{$tipo->ID_TIP}}">{{$tipo->NOM_TIP}}</option>
															@endforeach
														</select>
														<small class="text-info">*Este campo solo debe completarse si el material se calculara para las cotizaciones, de otro modo no es obligatorio</small>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="exampleInputEmail1">IMAGEN DE PRODUCTO</label>
														<input type="file" class="custom-file-input" name="img_pro_u" id="customFile_u" required="">
														<small class="text-danger">*Seleccione una imagen solo si desea reemplazarla por la actual</small>
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
				<h4 class="modal-title">REGISTRO DE NUEVO PRODUCTO</h4>
			</div>
			
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/producto')}}" enctype="multipart/form-data" parsley-validate novalidate>
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">NOMBRE DEL PRODUCTO</label>
									<input type="text" class="form-control" name="nom_pro" onkeyup="may(this);" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">DESCRIPCION</label>
									<input type="text" class="form-control" name="des_pro" onkeyup="may(this);" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PRECIO DE COMPRA EN BOLIVIANOS</label>
									<div class="input-group">
										<input type="number" class="form-control" name="pre_com" required>
										<span class="input-group-addon">Bs.</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PRECIO DE VENTA EN BOLIVIANOS</label>
									<div class="input-group">
										<input type="number" class="form-control" name="pre_ven" required>
										<span class="input-group-addon">Bs.</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CATEGORIA</label>
									<select class="form-control" name="id_cat" id="id_cat" required>
										<option selected="" disabled="">-SELECCIONE CATEGORIA-</option>
										@foreach($categorias as $categoria)
										<option value="{{$categoria->ID_CAT}}">{{$categoria->NOM_CAT}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">TIPO DE COTIZACION</label>
									<select class="form-control" name="id_tip" id="id_tip" >
										<option selected="" value="0">-NINGUNO-</option>
										@foreach($tipos as $tipo)
										<option value="{{$tipo->ID_TIP}}">{{$tipo->NOM_TIP}}</option>
										@endforeach
									</select>
									<small class="text-info">*Este campo solo debe completarse si el material se calculara para las cotizaciones, de otro modo no es obligatorio</small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">IMAGEN DE PRODUCTO</label>
									<input type="file" class="custom-file-input" name="img_pro" id="customFile" required="">
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
	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>
@endsection