@extends('layouts.master')
@section('tree_cotizacion','active menu-open')
@section('li_cotizacion','active')
@section('title','COTIZACIÓN DE PARED DRYWALL')
@section('content')


<form method="POST" action="{{route('cotizacion.guarda')}}" id="form_cotizacion" parsley-validate novalidate>
	{{csrf_field()}}	
	<div class="col-md-12">
		<!-- Custom Tabs -->
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab_1" data-toggle="tab">COTIZACION</a></li>
				<li><a href="#tab_2" data-toggle="tab" onclick="guardado()">MIS COTIZACIONES</a></li>
				<li><a href="#tab_3" data-toggle="tab" >MIS VENTAS</a></li>

			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_1">
					<h3 class="text-center text-info">CALCULO DE  COTIZACIONES</h3>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">INGRES BASE:</label>
								<input type="number" class="form-control" name="base" id="base" value="0">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleInputEmail1">INGRESE ALTURA:</label>
								<input type="number" class="form-control" name="altura" id="altura" value="0">
							</div>
						</div>
						<div class="col-md-4">
							<label for="exampleInputEmail1"> REALIZAR CALCULOS</label>
							<button type="button" class="btn btn-block btn-success" onclick="calcular();"><i class="fa fa-calculator"></i> CALCULAR</button>
						</div>
						<div class="col-md-12" id="div_resultado"></div>
					</div>
				</div>
				<!-- /.tab-pane -->
				<div class="tab-pane" id="tab_2">
					<h3 class="text-center text-info">COTIZACIONES GUARDADAS</h3>
					<div class="row">

						<div class="col-md-12" id="div_guardado"></div>
					</div>

				</div>
				<div class="tab-pane" id="tab_3">
					<h3 class="text-center text-info">VENTAS REGISTRADAS</h3>
					<div class="row">
					<div class="col-md-12 table-responsive">
					<table class="table table-bordered table-striped">
						<tr>
							<th>#</th>
							<th>CLIENTE</th>
							<th>CI CLIENTE</th>
							<th>FECHA</th>
							<th>ESTADO</th>
							<th>ACCIONES</th>
						</tr>
						@foreach($ventas as $numero=>$venta)
						<tr>
							<td>{{$numero+1}}</td>
							<td>{{$venta->NOM_CLI.' '.$venta->PAT_CLI.' '.$venta->MAT_CLI}}</td>
							<td>{{$venta->CI_CLI}}</td>
							<td>{{$venta->FEC_VEN}} - {{$venta->HOR_VEN}}</td>
							@if($venta->EST_VEN==0)
							<td><span class="label bg-yellow">PENDIENTE</span></td>
							@elseif($venta->EST_VEN==1)
							<td><span class="label bg-blue">ASIGNADO</span></td>
							@elseif($venta->EST_VEN==2)
							<td><span class="label bg-blue">ENTREGADO</span></td>
							@elseif($venta->EST_VEN==3)
							<td><span class="label bg-green">FINALIZADO</span></td>
							@else
							<td></td>
							@endif
							<td><a href="{{url('cotizacion/seguimiento/'.$venta->ID_VEN)}}" class="btn btn-danger"><i class="fa fa-share"></i> Seguimiento</a></td>
						</tr>
						@endforeach
					</table>
						
					</div>
						
					</div>

				</div>

			</div>
			<!-- /.tab-content -->
		</div>
		<!-- nav-tabs-custom -->
	</div>



	<!--INICIO DE MODAL NUEVO-->
	<div class="modal fade scroller" id="modalGuarda" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<!-- /modal-header -->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
					<h4 class="modal-title" id="myModalLabel">REGISTRO DE COTIZACIÓN</h4>
				</div>
				<!-- /modal-body -->
				<div class="box-body">
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="exampleInputEmail1">DIGITE EL NUMERO DE NIT O CI DEL CLIENTE</label>
								<input type="text" class="form-control num ln" name="ci_cli" id="ci_cli" autocomplete="off"  required onkeyup="busca_cedula();">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">CI / NIT</label>
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
								<input type="text" class="form-control field may letras lc ao" name="nom_cli" id="nom_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">APELLIDO PATERNO</label>
								<input type="text" class="form-control field may letras lc ao" name="pat_cli" id="pat_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">APELLIDO MATERNO</label>
								<input type="text" class="form-control field may letras lc ao" name="mat_cli" id="mat_cli" required onkeyup="may(this);">
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
								<input type="text" class="form-control field may ao" name="dir_cli" id="dir_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">TELEFONO</label>
								<input type="number" class="form-control field ao" name="tel_cli" id="tel_cli" required onkeyup="may(this);">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="exampleInputEmail1">CORREO ELECTRONICO</label>
								<input type="text" class="form-control field min ao" name="email_cli" id="email_cli"  >
							</div>
						</div>
						
						
					</div>
				</div>
				<!-- /.box-footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary pull-right btn_guarda" id=""><i class="fa fa-check"></i> Registrar cotizacion</button>
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
				</div>
			</div>
		</div>
	</div>
</form>
<!--FIN DE MODAL NUEVO-->
@endsection
@section('js')
<script type="text/javascript">
	function calcular(){
		var base=$('#base').val();
		var altura=$('#altura').val();
		var route= "{{route('cotizacion.calcula')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',     
			dataType:'html',     
			data: {base:base, altura:altura},
			success: function(data){
				console.log(data);
				$('#div_resultado').html(data);
				
			},
			error: function(data){
				console.log(data);
			}
		});
	}
	
</script>
<script type="text/javascript">
	function guardar(){
		var base=$('#base').val();
		var altura=$('#altura').val();
		var route= "{{route('cotizacion.guarda')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',     
			dataType:'json',     
			data: {base:base, altura:altura},
			success: function(data){
				console.log(data);
				if (data=='TRUE') {
					$.notify({icon:'<i class="fa fa-check"></i> ',title:' <strong>EXITO!</strong></br>',message:"{{'  La proforma se guardo exitosamente'}}"},{z_index: 2000, type:'success',animate:{enter:'animated fadeInDown',exit:'animated fadeOutUp'}});
					$('#btn_guarda').prop('disabled',true);
				}else{
					$.notify({icon:'<i class="fa fa-ban"></i> ',title:' <strong>ERROR!</strong></br>',message:"{{'  Ocurrio un problema al guardar, recargue la Pagina'}}"},{z_index: 2000, type:'danger',animate:{enter:'animated fadeInDown',exit:'animated fadeOutUp'}});
				}
				
			},
			error: function(data){
				console.log(data);
			}
		});
	}
	
</script>
<script type="text/javascript">
	function guardado(){
		var base=$('#base').val();
		var altura=$('#altura').val();
		var route= "{{url('/guardado')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'GET',     
			dataType:'html',     
			success: function(data){
				console.log(data);
				$('#div_guardado').html(data);
				
			},
			error: function(data){
				console.log(data);
			}
		});
	}
	
</script>
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#form_cotizacion').on("submit",function(ev){
			ev.preventDefault();
			if ($(this).parsley().isValid()) {
				var $form=$(this);
				var button=$form.find("[type='submit']");
				$.ajax({
					url: $form.attr('action'),           
					headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
					dataType:"json",
					type:'POST',

					data: $form.serialize(),
					beforeSend: function(){

					},
					success: function(data){
						console.log(data);
						console.log(data);
						if (data!='FALSE') {
							$.notify({icon:'<i class="fa fa-check"></i> ',title:' <strong>EXITO!</strong></br>',message:"{{'  La proforma se guardó exitosamente'}}"},{z_index: 2000, type:'success',animate:{enter:'animated fadeInDown',exit:'animated fadeOutUp'}});
							$('.btn_guarda').prop('disabled',true);
							$('·div_botonera').empty();
							$('#modalGuarda').modal('hide');
							$('#div_botonera').html('<a href="cotizacion-pdf/'+data.ID_COT+'" target="_blank" class="btn btn-danger"><i class="fa fa-print"></i> IMPRIMIR PROFORMA GUARDADA</a>');
						}else{
							$.notify({icon:'<i class="fa fa-ban"></i> ',title:' <strong>ERROR!</strong></br>',message:"{{'  Ocurrio un problema al guardar, recargue la Pagina'}}"},{z_index: 2000, type:'danger',animate:{enter:'animated fadeInDown',exit:'animated fadeOutUp'}});
						}
					},
					error: function(data){
						console.log(data);
					}

				});
			}
			return false;
		});
	});
</script>
@endsection