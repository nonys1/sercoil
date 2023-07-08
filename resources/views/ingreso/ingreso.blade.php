@extends('layouts.master')
@section('ingreso')
active
@endsection
@section('title')
REGISTRO DE NUEVO INGRESO
@endsection
@section('content')


<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">NUEVO REGISTRO</h3>
	</div>
	<div class="box-body">
		<a href="{{route('ingreso.index')}}" class="btn btn-default pull-left"><i class="fa fa-share"></i> VOLVER A REGISTRO</a>
		<button class="btn btn-success pull-right" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> INGRESAR DETALLE AL INGRESO</button>
		<div class="row col-md-12">
			
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">USUARIO</label>
					<input type="text" class="form-control" name="" value="{{$ingreso->NOM_USU.' '.$ingreso->PAT_USU.' '.$ingreso->MAT_USU}}" readonly="">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">FECHA DE INGRESO</label>
					<input type="text" class="form-control" name="" value="{{$ingreso->FEC_ING}}" readonly="">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="exampleInputEmail1">PROVEEDOR</label>
					<input type="text" class="form-control" name="" value="{{$ingreso->NOM_PROV}}" readonly="">
				</div>
			</div>
			
		</div>
		<br>
		<br>
		<div class="table-responsive col-md-12">
			<table class="table table-striped table-hover table-bordered">
				<tr class="info">
					<th>#</th>
					<th>PRODUCTO</th>
					<th>CANTIDAD</th>
					<th>PRECIO DE VENTA</th>
					<th>FECHA DE PRODUCCION</th>
					<th>FECHA DE VENCIMIENTO</th>
				</tr>
				@foreach($detalles as $numero=>$detalle)
				<tr>
					<td>{{$numero+1}}</td>
					<td>{{$detalle->NOM_PRO}}</td>
					<td>{{$detalle->CANT_ID}}</td>
					<td>{{$detalle->PRE_PRO}} Bs./u</td>
					<td>{{$detalle->FEC_PROD}}</td>
					<td>{{$detalle->FEC_VENC}}</td>
				</tr>
				@endforeach
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
				<h4 class="modal-title">NUEVO DETALLE AL INGRESO</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/ingresoDetalle')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<input type="hidden" name="id_ing" value="{{$ingreso->ID_ING}}">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">CATEGORIA</label>
									<select class="form-control" name="id_cat" id="id_cat" required onchange="buscaProductos();">
										<option selected="" disabled="">-ELIJA UNA CATEGORIA-</option>
										@foreach($categorias as $categoria)
										<option value="{{$categoria->ID_CAT}}">{{$categoria->NOM_CAT}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PRODUCTO</label>
									<select class="form-control" name="id_pro" id="id_pro" required>
										<option selected="" disabled="" >-ELIJA UNA CATEGORIA-</option>
										
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">CANTIDAD</label>
									<input type="number" class="form-control" name="cant_id" required >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">FECHA DE PRODUCCION</label>
									<input type="date" class="form-control" name="fec_prod" required >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="exampleInputEmail1">FECHA DE VENCIMIENTO</label>
									<input type="date" class="form-control" name="fec_venc" id="fec_venc" required >
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
<script type="text/javascript">

	function buscaProductos(){
		var id_cat = $('#id_cat').val();
		var route= "{{route('detalle.buscaProductos')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST', 
			dataType:'html',           
			data: {"id_cat": id_cat},
			success: function(data){
				console.log(data);
				$('#id_pro').html(data);
				if (id_cat!='2') {
					$('#fec_venc').attr('disabled',true);
					$('#fec_venc').val('');
				}else{
					$('#fec_venc').attr('disabled',false);
				}
			},
			error: function(data){
				console.log(data);
			}
		});
	}
</script>
@endsection