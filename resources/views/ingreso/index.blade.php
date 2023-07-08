@extends('layouts.master')
@section('ingreso')
active
@endsection
@section('title')
REGISTRO DE INGRESOS DE PRODUCTOS AL INVENTARIO
@endsection
@section('content')


<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">INGRESOS REGISTRADAS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR UN NUEVO INGRESO</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>USUARIO</th>
						<th>FECHA</th>
						<th>PROVEEDOR</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					@foreach($ingresos as $numero=>$ingreso)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$ingreso->NOM_USU.' '.$ingreso->PAT_USU.' '.$ingreso->MAT_USU}}</td>
						<td>{{$ingreso->FEC_ING}}</td>
						<td>{{$ingreso->NOM_PROV}}</td>
						<td><a href="{{url('/registro/ingreso/'.$ingreso->ID_ING)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a></td>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">REGISTRO DE NUEVA CATEGORIA</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/ingreso')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">USUARIO</label>
									<input type="text" class="form-control" name="" readonly="" value="{{Auth::user()->NOM_USU.' '.Auth::user()->PAT_USU.' '.Auth::user()->MAT_USU}}">
									<input type="hidden" class="form-control" name="id_usu" readonly="" value="{{Auth::user()->ID_USU}}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">FECHA DE INGRESO</label>
									<input type="date" class="form-control" name="fec_ing" required readonly="" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="exampleInputEmail1">PROVEEDOR</label>
									<select class="form-control" name="id_prov">
										<option disabled="" selected="">-SELECCIONE UN PROVEEDOR-</option>
										@foreach($proveedores as $proveedor)
										<option value="{{$proveedor->ID_PROV}}">{{$proveedor->NOM_PROV}}</option>
										@endforeach
									</select>
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

@endsection