@extends('layouts.master')
@section('categoria')
active
@endsection
@section('title')
CATEGORIAS DEL SISTEMA
@endsection
@section('content')


<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">CATEGORIAS REGISTRADAS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR NUEVA CATEGORIA</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>CATEGORIA</th>
						<th>DESCRIPCION</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					@foreach($categorias as $numero=>$categoria)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$categoria->NOM_CAT}}</td>
						<td>{{$categoria->DES_CAT}}</td>
						<td><button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalUpdate_{{$categoria->ID_CAT}}"><i class="fa fa-pencil"></i></button></td>
					</tr>
					<!--INICIO DE MODAL UPDATE-->
<div class="modal fade scroller" id="modalUpdate_{{$categoria->ID_CAT}}" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">EDITAR CATEGORIA</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{route('categoria.update')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<input type="hidden" name="id_cat" value="{{$categoria->ID_CAT}}">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">NOMBRE DE LA CATEGORIA</label>
									<input type="text" class="form-control" name="nom_cat_u" onkeyup="may(this);" required value="{{$categoria->NOM_CAT}}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">DESCRIPCION</label>
									<input type="text" class="form-control" name="des_cat_u" required onkeyup="may(this);" value="{{$categoria->DES_CAT}}">
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
				<h4 class="modal-title">REGISTRO DE NUEVA CATEGORIA</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/categoria')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">NOMBRE DE LA CATEGORIA</label>
									<input type="text" class="form-control" name="nom_cat" onkeyup="may(this);" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">DESCRIPCION</label>
									<input type="text" class="form-control" name="des_cat" required onkeyup="may(this);">
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