@extends('layouts.master')
@section('rol')
active
@endsection
@section('title')
ROLES DEL SISTEMA
@endsection
@section('content')

<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">ROLES REGISTRADOS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR NUEVO ROL</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>ROL</th>
						<th>PERMISOS</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					@foreach($roles as $numero=>$rol)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$rol->display_name}}</td>
						@php $perms=$rol->perms()->get(); @endphp
								<td>
									@foreach($perms as $perm)
									<span class="label bg-blue">{{$perm->display_name}}</span>

									@endforeach
								</td>
						<td><button class="btn btn-warning btn-sm" id="{{$rol->id}}" onclick="edit(this.id);"><i class="fa fa-pencil"></i></button></td>
					</tr>
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
				<h4 class="modal-title" id="myModalLabel">REGISTRO ROLES</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<form method="POST" action="{{url('/rol')}}" parsley-validate novalidate>
					{{csrf_field()}}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">ROL</label>
								<input type="text" class="form-control min lc letras" name="name" onkeyup="" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">NOMBRE DE PANTALLA</label>
								<input type="text" class="form-control  may letras lc" name="display_name" onkeyup="may(this);" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">DESCRIPCION DEL ROL</label>
								<input type="text" class="form-control may" name="description" onkeyup="may(this);" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">PERMISOS</label>
								<select class="form-control select2" multiple="multiple" name="permisos[]" id="permisos"   data-placeholder="Seleccione un permiso" style="width: 100%;">
									@foreach($permisos as $permiso)
									<option value="{{$permiso->id}}">{{$permiso->display_name}}</option>
									@endforeach
								</select>
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
<!--INICIO DE MODAL EDITA-->
<div class="modal fade scroller" id="modalEdit" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- /modal-header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title" id="myModalLabel">REGISTRO ROLES</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<form method="POST" action="{{route('rol.update')}}" parsley-validate novalidate>
					{{csrf_field()}}
					<input type="hidden" name="id_rol" id="id_rol" value="">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">ROL</label>
								<input type="text" class="form-control" name="name_u" id="name_u" onkeyup="" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">NOMBRE DE PANTALLA</label>
								<input type="text" class="form-control" name="display_name_u" id="display_name_u" onkeyup="may(this);" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">DESCRIPCION DEL ROL</label>
								<input type="text" class="form-control" name="description_u" id="description_u" onkeyup="may(this);" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">PERMISOS</label>
								<select class="form-control select2" multiple="multiple" name="permisos_u[]" id="permisos_u"  data-placeholder="Seleccione un permiso" style="width: 100%;">
									@foreach($permisos as $permiso)
									<option value="{{$permiso->id}}">{{$permiso->display_name}}</option>
									@endforeach
								</select>
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
<!--FIN DE MODAL EDITA-->
@endsection
@section('js')
<script type="text/javascript">
	$('.select2').select2();
	function edit(id_rol){
		$('#permisos_u').empty();
		var route= "{{route('rol.busca')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',            
			data: {"id_rol": id_rol},
			success: function(data){
				console.log(data);
				$('#id_rol').val(id_rol);
				$('#name_u').val(data.rol.name);
				$('#display_name_u').val(data.rol.display_name);
				$('#description_u').val(data.rol.description);
				
				//primero preguntamos si tiene algun permiso asignado
				if (data.asignados.length==0) {
					$.each(data.permisos, function(permisos,permiso){
						$("#permisos_u").append('<option value="'+permiso.id+'">'+permiso.display_name+'</option>');						
					});
				}
				else{
					//si tiene recoreremos dos arrays
					for(var i=0; i<data.permisos.length; i++){
						if (data.asignados.length!=0) {
						var contador=0;	
						for(var j=0; j<data.asignados.length; j++){
							if (data.permisos[i].id==data.asignados[j].id) {
								$("#permisos_u").append('<option value="'+data.permisos[i].id+'" selected>'+data.permisos[i].display_name+'</option>');
								data.asignados.splice(j, 1);
								//si encuentra uno que coincida se sale del bucle
								break;

							}else{
								//si no va contando cuantas veces no existe, si al final del recorrido es igual al array entonces no existe ese elemento
								contador++;
								if (contador==data.asignados.length) {
								$("#permisos_u").append('<option value="'+data.permisos[i].id+'">'+data.permisos[i].display_name+'</option>');
								}
							}			
						};				
					}else{
								$("#permisos_u").append('<option value="'+data.permisos[i].id+'">'+data.permisos[i].display_name+'</option>');
					}
					};
				}
				$('#modalEdit').modal('show'); 
			},
			error: function(data){
				console.log(data);
			}
		});
	}
	
</script>
@endsection