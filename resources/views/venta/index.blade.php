@extends('layouts.master')
@section('venta')
active
@endsection
@section('title')
REALIZAR VENTAS
@endsection
@section('content')


<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">VENTAS REGISTRADAS</h3>
	</div>
	<div class="box-body">
		<button class="btn btn-success" data-toggle="modal" data-target="#modalNuevo"><i class="fa fa-plus"></i> REGISTRAR NUEVA VENTA</button>
		<br>
		<br>
		<div class="table-responsive">
			<table id="datatable" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>USUARIO</th>
						<th>FECHA</th>
						<th>CLIENTE</th>
						<th>ESTADO</th>
						<th>ACCIONES</th>
					</tr>
				</thead>
				<tbody>
					@foreach($ventas as $numero=>$venta)
					<tr>
						<td>{{$numero+1}}</td>
						<td>{{$venta->NOM_USU.' '.$venta->PAT_USU.' '.$venta->MAT_USU}}</td>
						<td><i class="fa fa-calendar"></i> {{$venta->FEC_VEN}}<br><i class="fa fa-clock-o"></i> {{$venta->HOR_VEN}}</td>
						<td>{{$venta->NOM_CLI.' '.$venta->PAT_CLI.' '.$venta->MAT_CLI}}</td>
						@if($venta->EST_VEN==0)
						<td><span class="label bg-red">PENDIENTE</span></td>
						@elseif($venta->EST_VEN==1)
						<td><span class="label bg-blue">ASIGNADO</span></td>
						@else
						<td><span class="label bg-green">FINALIZADO</span></td>
						@endif
						<td>
						<a href="{{url('/registro/venta/'.$venta->ID_VEN)}}"  title="Detalles de la venta" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
						@if($venta->EST_VEN!=0)
						<a href="{{url('/recibo/'.$venta->ID_VEN)}}" target="_blank" title="Imprimir Recibo" class="btn btn-warning btn-sm"><i class="fa fa-print"></i></a>
						@endif
						</td>
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
				<h4 class="modal-title">REGISTRO DE NUEVA VENTA</h4>
			</div>
			<!-- /modal-body -->
			<div class="box-body">
				<div class="card-body">
					<form method="POST" action="{{url('/venta')}}" parsley-validate novalidate>
						{{csrf_field()}}
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="exampleInputEmail1">DIGITE EL NUMERO DE CEDULA DE IDENTIDAD EL CLIENTE</label>
									<input type="text" class="form-control" name="ci_cli" id="ci_cli" autocomplete="off"  required onkeyup="busca_cedula();">
								</div>
							</div>
							<fieldset class="col-md-12">
								<legend>DATOS DEL CLIENTE</legend>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">CEDULA DE IDENTIDAD</label>
										<input type="text" class="form-control" name="ci_cli2" id="ci_cli2" required readonly="">
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
							</fieldset>
							<fieldset class="col-md-12">
								<legend>DATOS DE LA VENTA</legend>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputEmail1">FECHA DE LA VENTA</label>
										<input type="date" class="form-control" name="fec_ven" id="fec_ven" readonly="" value="{{Carbon\Carbon::now()->format('Y-m-d')}}">
									</div>
								</div>
								
								
							</fieldset>
						</div>
					</div>
				</div>
				<!-- /.box-footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Registrar Venta</button>
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
	function busca_cedula(){
		var ci_cli = $('#ci_cli').val();
		$('#ci_cli2').val(ci_cli);
		var route= "{{route('cliente.buscaCedula')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',            
			data: {"ci_cli": ci_cli},
			success: function(data){
				console.log(data);
				if (data!='FALSE') {
					console.log('encontro');
					$('#nom_cli').val(data.NOM_CLI);
					$('#pat_cli').val(data.PAT_CLI);
					$('#mat_cli').val(data.MAT_CLI);
					$('#fec_nac').val(data.FEC_NAC);
					$('#dir_cli').val(data.DIR_CLI);
					$('#tel_cli').val(data.TEL_CLI);
					$('#email_cli').val(data.EMAIL_CLI);
					$('.field').attr("readonly",true);
				}else{
					console.log('nada');
					$('#nom_cli').val('');
					$('#pat_cli').val('');
					$('#mat_cli').val('');
					$('#fec_nac').val('');
					$('#dir_cli').val('');
					$('#tel_cli').val('');
					$('#email_cli').val('');

					$('.field').attr("readonly",false);
				}
				
			},
			error: function(data){
				console.log(data);
			}
		});
	}
</script>
@endsection