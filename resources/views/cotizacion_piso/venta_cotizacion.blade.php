@extends('layouts.master')
@section('venta')
active
@endsection
@section('title')
VENTA DE COTIZACIÓN PISO FALSO
@endsection
@section('content')

<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">DETALLES</h3>
	</div>
	<div class="box-body">
		<form method="POST" action="{{route('cotizacion_piso.confirma')}}">
			{{csrf_field()}}
			<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
			<input type="hidden" name="id_cot" value="{{$cotizacion->ID_COT}}">
			<input type="hidden" name="mts2" value="{{$cotizacion->BASE*$cotizacion->ALTURA}}">
			<a href="{{url('/venta')}}" class="btn btn-default pull-left" ><i class="fa fa-share"></i> REGRESAR A VENTAS</a>

			<br>
			<br>
			<div class="row col-md-12">
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">CLIENTE</label>
						<input type="text" class="form-control" name="" value="{{$venta->NOM_CLI.' '.$venta->PAT_CLI.' '.$venta->MAT_CLI}}" readonly="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">FECHA</label>
						<input type="text" class="form-control" name="" value="{{$venta->FEC_VEN}}" readonly="">
					</div>
				</div>
			</div>
			<div class="row col-md-12">
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">BASE</label>
						<input type="text" class="form-control" name="" value="{{$cotizacion->BASE}}" readonly="">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="exampleInputEmail1">ALTURA</label>
						<input type="text" class="form-control" name="" value="{{$cotizacion->ALTURA}}" readonly="" >
					</div>
				</div>
			</div>
			<div class="table-responsive col-md-12">
				<!-- checkbox -->


				<table  class="table table-bordered table-striped table-hover text-center">
					<thead>
						<tr class="success"><th class="text-center" colspan="6">CIELO FALSO</th></tr>
						<tr class="success">
							<th>SELECCIONAR</th>
							<th>MTS2</th>
							<th>PRECIOS</th>
							<th>RESULTADO</th>
							<th>PANELES</th>
						</tr>
					</thead>
					<?php
					$body='';
					$placas=\App\Producto::where('ID_TIP',3)->get();// CIELO ACUSTICO;
					$resultado=0;
					$mts2=$cotizacion->BASE*$cotizacion->ALTURA;
					$contador=0;
					foreach ($placas as $placa) {
						$resultado=$placa->PRE_TOT*$mts2;
						$rp=round(($cotizacion->BASE*$cotizacion->ALTURA),0);
						if ($placa->EXT_PRO>=$rp) {
							$body.='<tr><td> <input type="checkbox" class="flat-red combo" name="ch_'.$contador.'" id="'.$placa->ID_PRO.'" value="'.$resultado.'|'.$placa->ID_PRO.'" onchange="elije(this)"></td><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs/u</td><td><b>'.$resultado.' Bs.</b></td><td>'.$placa->NOM_PRO.'</td></tr>';
						}else{
							$body.='<tr><td> <input type="checkbox" class="flat-red disabled" disabled ></td><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs/u</td><td><b>'.$resultado.' Bs.</b></td><td>'.$placa->NOM_PRO.' <b class="text-danger"> (INSUFICIENTE)</b></td></tr>';
						}
						$contador++;
					}
					echo $body;
					?>
					<tr class="danger">
						<td colspan="6" class="text-center">
							<h4>TOTAL:<b id="text_total">0</b> Bs.</h4>
							<input type="hidden" name="total_pagar" id="total_pagar" value="0">
						</td>
					</tr>
				</table>
				<table  class="table table-bordered table-striped table-hover text-center">
					<?php
					$body='';
					$ext_membrana_telgopor=0;


					//inicio TELGOPOR 1.20 X 20 MTS
					$resultado_membrana_telgopor=round(($cotizacion->ALTURA*$cotizacion->BASE)/24);
					$disponible_membrana_telgopor='';
					$query_membrana_telgopor=\App\Producto::where('ID_PRO',31)->where('EXT_PRO','>=',$resultado_membrana_telgopor)->first();
					if ($query_membrana_telgopor) {
						$disponible_membrana_telgopor='<b class="text-success">DISPONIBLE</b>';
						$ext_membrana_telgopor=1;
					}else{
						$disponible_membrana_telgopor='<b class="text-danger">CANTIDAD INSUFICIENTE</b>';
					}
					$body.='<tr class="warning"><td width="50%">CANTIDAD DE MEMBRANA DE TELGOPOR DE 1.20 X 20 MTS</td><td width="50%"><b>'.$resultado_membrana_telgopor.'</b> (Unidades) '.$disponible_membrana_telgopor.'<input type="hidden" name="cantidad_membrana_telgopor" value="'.$resultado_membrana_telgopor.'"></td></tr>';
					//final TELGOPOR 1.20 X 20 MTS
					//inicio LAMINAS PISO FLOTANTE
					$resultado_piso_flotante=round(($cotizacion->ALTURA*$cotizacion->BASE)/0.24);

					$body.='<tr class="warning"><td width="50%">CANTIDAD DE PANELES DE 0.60</td><td width="50%"><b>'.$resultado_piso_flotante.'</b> (Unidades)</td><input type="hidden" name="cant_piso_flotante" id="cant_piso_flotante" value="'.$resultado_piso_flotante.'"></tr>';
					//final LAMINAS PISO FLOTANTE


					echo $body;
					?>
				</table>
				<table class="table table-bordered">
					<tr class="info">
						<td>
						<div class="form-group">
							<select class="form-control" name="id_obr" id="id_obr">
								<option selected="" value="" disabled="">-ASIGNAR OBRERO-</option>
								@foreach($obreros as $obrero)
								<option value="{{$obrero->ID_USU}}">{{$obrero->NOM_USU.' '.$obrero->PAT_USU.' '.$obrero->MAT_USU}}</option>
								@endforeach
							</select>
							</div>
						</td>
					</tr>
				</table>
                <input type="hidden" name="cantidad_seleccionada" id="cantidad_seleccionada" value="0">
				@if($ext_membrana_telgopor==1)
				<button type="sumbit" class="btn btn-success btn-block" id="btn_confirma" disabled=""><i class="fa fa-ban"></i> DEBE SELECCIONAR AL MENOS UN MATERIAL</button>
				@else
				<button type="button" class="btn btn-danger btn-block" disabled=""><i class="fa fa-ban"></i> UNO DE LOS MATERIALES NO CUENTA CON LA CANTIDAD SUFICIENTE PARA EL PEDIDO</button>
				@endif


			</form>
		</div>
	</div>
</div>

@endsection
@section('js')

<script type="text/javascript">
    var resultado = 0;
    var cantidadSeleccionada = 0;
    document.getElementById('id_obr').addEventListener("change", function () {
        if (resultado != 0 && this.value != '' ) {
			$('#btn_confirma').html('<i class="fa fa-check"></i> CONFIRMAR VENTA');
			$('#btn_confirma').attr('disabled',false);
		}else{
			$('#btn_confirma').html('<i class="fa fa-ban"></i> DEBE SELECCIONAR AL MENOS UNA PLACA');
			$('#btn_confirma').attr('disabled',true);
		}
    })
	$('.combo').on('ifClicked', function(event){
        var idObre = document.getElementById('id_obr').value;
		var precio=parseInt($(this).val());
		var total_pagar=parseInt($('#total_pagar').val());
		if (!$(this).prop('checked')) {
			/*cantidad_placas($(this).attr('id'))*/

            cantidadSeleccionada += 1;
            $('#cantidad_seleccionada').val(cantidadSeleccionada)
			resultado=total_pagar+precio
			$('#total_pagar').val(resultado);
			$('#text_total').html(resultado);

		}else{
            cantidadSeleccionada -= 1;
            $('#cantidad_seleccionada').val(cantidadSeleccionada)
			resultado=total_pagar-precio
			$('#total_pagar').val(resultado);
			$('#text_total').html(resultado);
		}
		if (resultado!=0 && idObre != '') {
            console.log("que pasa aca",idObre)
			$('#btn_confirma').html('<i class="fa fa-check"></i> CONFIRMAR VENTA');
			$('#btn_confirma').attr('disabled',false);
		}else{
			$('#btn_confirma').html('<i class="fa fa-ban"></i> DEBE SELECCIONAR AL MENOS UNA PLACA');
			$('#btn_confirma').attr('disabled',true);
		}

	});
</script>
<script type="text/javascript">
	//iCheck for checkbox and radio inputs
	$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass   : 'iradio_minimal-blue'
	})
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    	checkboxClass: 'icheckbox_minimal-red',
    	radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    	checkboxClass: 'icheckbox_flat-green',
    	radioClass   : 'iradio_flat-green'
    })
</script>
<script type="text/javascript">
	function cantidad_placas(id_pro){
		console.log(id_pro);
		var route= "{{route('cotizacion.precio')}}";
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',
			datatype:'json',
			data: {"id_pro":id_pro},
			success: function(data){
				if (data.EXT_PRO<=parseInt($('#cant_placa').val())) {
					$.notify({icon:'<i class="fa fa-ban"></i> ',title:' <strong>ERROR!</strong></br>',message:'La placa '+data.NOM_PRO+' tiene una existencia de: '+data.EXT_PRO+' (unidades) insuficiente para el pedido requerido'},{z_index: 2000, type:'danger',animate:{enter:'animated fadeInDown',exit:'animated fadeOutUp'}});
					return false;
				}else{
					return true;
				}

			},
			error: function(data){
				console.log(data);
			}
		});
	}
</script>
@endsection
