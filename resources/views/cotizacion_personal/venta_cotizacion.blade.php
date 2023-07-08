@extends('layouts.master')
@section('venta')
active
@endsection
@section('title')
VENTA DE COTIZACIÓN PERSONALIZADA
@endsection
@section('content')

<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">DETALLES</h3>
	</div>
	<div class="box-body">
		<form method="POST" action="{{route('cotizacion_personal.confirma')}}">
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
						<tr class="danger"><th class="text-center" colspan="6">COTIZACION PERSONALIZADA</th></tr>
						<tr class="danger">
							<th>SELECCIONAR</th>
							<th>MTS2</th>
							<th>PRECIO UNIDAD</th>
							<th>UNIDADES</th>
							<th>MATERIAL</th>
							<th>SUB TOTAL</th>
						</tr>
					</thead>
					<?php
					$body='';
					$mts2=$cotizacion->BASE*$cotizacion->ALTURA;
					// *******************  INICIO PARED DRYWALL ***************************
					$resultado_soleras=round(($cotizacion->BASE/2.40)*2,0);
					$query_solera=\App\Producto::where('ID_PRO',4)->where('EXT_PRO','>=',$resultado_soleras)->first();
					if ($query_solera->EXT_PRO>=$resultado_soleras) {
						$body.='<tr class="success"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$query_solera->ID_PRO.'" value="'.$resultado_soleras*$query_solera->PRE_PRO.'|'.$query_solera->ID_PRO.'|'.$resultado_soleras.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$query_solera->PRE_PRO.' Bs.</td><td><b>'.$resultado_soleras.'</b> (Unidades)</td><td>PERFILES '.$query_solera->NOM_PRO.'</td><td>'.$resultado_soleras*$query_solera->PRE_PRO.' Bs.</td></tr>';
					}else{
						$body.='<tr class="success"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$query_solera->PRE_PRO.' Bs.</td><td><b>'.$resultado_soleras.'</b> (Unidades)</td><td>PERFILES '.$query_solera->NOM_PRO.'</td><td>'.$resultado_soleras*$query_solera->PRE_PRO.' Bs.</td></tr>';
					}


					$resultado_montantes=round((($cotizacion->BASE/0.60)+1)*(($cotizacion->ALTURA/2.40)),0);
					$query_montante=\App\Producto::where('ID_PRO',3)->where('EXT_PRO','>=',$resultado_montantes)->first();
					if ($query_montante->EXT_PRO>=$resultado_montantes) {
						$body.='<tr class="success"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$query_montante->ID_PRO.'" value="'.$resultado_montantes*$query_montante->PRE_PRO.'|'.$query_montante->ID_PRO.'|'.$resultado_montantes.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$query_montante->PRE_PRO.' Bs.</td><td><b>'.$resultado_montantes.'</b> (Unidades)</td><td>PERFILES '.$query_montante->NOM_PRO.'</td><td>'.$resultado_montantes*$query_montante->PRE_PRO.' Bs.</td></tr>';
					}else{
						$body.='<tr class="success"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$query_montante->PRE_PRO.' Bs.</td><td><b>'.$resultado_montantes.'</b> (Unidades)</td><td>PERFILES '.$query_montante->NOM_PRO.'</td><td>'.$resultado_montantes*$query_montante->PRE_PRO.' Bs.</td></tr>';
					}

					$placas=\App\Producto::where('NOM_PRO','LIKE','%PLACA DE YESO%')->where('ID_CAT',4)->get();
					foreach ($placas as $placa) {
						$resultado_placas=round(($cotizacion->BASE*$cotizacion->ALTURA)/2.88,0);
						if ($placa->EXT_PRO>=$resultado_placas) {
						$body.='<tr class="success"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$placa->ID_PRO.'" value="'.$resultado_placas*$placa->PRE_PRO.'|'.$placa->ID_PRO.'|'.$resultado_placas.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs.</td><td><b>'.$resultado_placas.'</b> (Unidades)</td><td>PERFILES '.$placa->NOM_PRO.'</td><td>'.$resultado_placas*$placa->PRE_PRO.' Bs.</td></tr>';
						}else{
							$body.='<tr class="success"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$placa->PRE_PRO.' Bs.</td><td><b>'.$resultado_placas.'</b> (Unidades)</td><td>PERFILES '.$placa->NOM_PRO.'</td><td>'.$resultado_placas*$placa->PRE_PRO.' Bs.</td></tr>';
						}
					}
					// *******************  FIN PARED DRYWALL ***************************
					// *******************  INICIO CIELO FALSO ***************************
					$resultado_perimetral_3mts=round((($cotizacion->ALTURA/3)+($cotizacion->BASE/3))*2);
					$query_perimetral_3mts=\App\Producto::where('ID_PRO',23)->where('EXT_PRO','>=',$resultado_perimetral_3mts)->first();
					if ($query_perimetral_3mts->EXT_PRO>=$resultado_perimetral_3mts) {
						$body.='<tr class="warning"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$query_perimetral_3mts->ID_PRO.'" value="'.$resultado_perimetral_3mts*$query_perimetral_3mts->PRE_PRO.'|'.$query_perimetral_3mts->ID_PRO.'|'.$resultado_perimetral_3mts.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$query_perimetral_3mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_perimetral_3mts.'</b> (Unidades)</td><td>PERFILES '.$query_perimetral_3mts->NOM_PRO.'</td><td>'.$resultado_perimetral_3mts*$query_perimetral_3mts->PRE_PRO.' Bs.</td></tr>';
					}else{
						$body.='<tr class="warning"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$query_perimetral_3mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_perimetral_3mts.'</b> (Unidades)</td><td>PERFILES '.$query_perimetral_3mts->NOM_PRO.'</td><td>'.$resultado_perimetral_3mts*$query_perimetral_3mts->PRE_PRO.' Bs.</td></tr>';
					}

					$resultado_central_3_66mts=round((($cotizacion->BASE/1.22)-1)*($cotizacion->ALTURA/3.66));
					$query_central_3_66mts=\App\Producto::where('ID_PRO',24)->where('EXT_PRO','>=',$resultado_central_3_66mts)->first();
					if ($query_central_3_66mts->EXT_PRO>=$resultado_central_3_66mts) {
						$body.='<tr class="warning"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$query_central_3_66mts->ID_PRO.'" value="'.$resultado_central_3_66mts*$query_central_3_66mts->PRE_PRO.'|'.$query_central_3_66mts->ID_PRO.'|'.$resultado_central_3_66mts.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$query_central_3_66mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_central_3_66mts.'</b> (Unidades)</td><td>PERFILES '.$query_central_3_66mts->NOM_PRO.'</td><td>'.$resultado_central_3_66mts*$query_central_3_66mts->PRE_PRO.' Bs.</td></tr>';
					}else{
						$body.='<tr class="warning"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$query_central_3_66mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_central_3_66mts.'</b> (Unidades)</td><td>PERFILES '.$query_central_3_66mts->NOM_PRO.'</td><td>'.$resultado_central_3_66mts*$query_central_3_66mts->PRE_PRO.' Bs.</td></tr>';
					}

					$resultado_transversal_1_22mts=round(($cotizacion->BASE/1.22)*(($cotizacion->ALTURA/0.61)-1));
					$query_transversal_1_22mts=\App\Producto::where('ID_PRO',25)->where('EXT_PRO','>=',$resultado_transversal_1_22mts)->first();
					if ($query_transversal_1_22mts->EXT_PRO>=$resultado_transversal_1_22mts) {
						$body.='<tr class="warning"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$query_transversal_1_22mts->ID_PRO.'" value="'.$resultado_transversal_1_22mts*$query_transversal_1_22mts->PRE_PRO.'|'.$query_transversal_1_22mts->ID_PRO.'|'.$resultado_transversal_1_22mts.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$query_transversal_1_22mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_1_22mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_1_22mts->NOM_PRO.'</td><td>'.$resultado_transversal_1_22mts*$query_transversal_1_22mts->PRE_PRO.' Bs.</td></tr>';
					}else{
						$body.='<tr class="warning"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$query_transversal_1_22mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_1_22mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_1_22mts->NOM_PRO.'</td><td>'.$resultado_transversal_1_22mts*$query_transversal_1_22mts->PRE_PRO.' Bs.</td></tr>';
					}

					$resultado_transversal_0_61mts=round(($cotizacion->BASE/1.22)*($cotizacion->ALTURA/0.61));
					$query_transversal_0_61mts=\App\Producto::where('ID_PRO',26)->where('EXT_PRO','>=',$resultado_transversal_0_61mts)->first();
					if ($query_transversal_0_61mts->EXT_PRO>=$resultado_transversal_0_61mts) {
						$body.='<tr class="warning"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$query_transversal_0_61mts->ID_PRO.'" value="'.$resultado_transversal_0_61mts*$query_transversal_0_61mts->PRE_PRO.'|'.$query_transversal_0_61mts->ID_PRO.'|'.$resultado_transversal_0_61mts.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$query_transversal_0_61mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_0_61mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_0_61mts->NOM_PRO.'</td><td>'.$resultado_transversal_0_61mts*$query_transversal_0_61mts->PRE_PRO.' Bs.</td></tr>';
					}else{
						$body.='<tr class="warning"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$query_transversal_0_61mts->PRE_PRO.' Bs.</td><td><b>'.$resultado_transversal_0_61mts.'</b> (Unidades)</td><td>PERFILES '.$query_transversal_0_61mts->NOM_PRO.'</td><td>'.$resultado_transversal_0_61mts*$query_transversal_0_61mts->PRE_PRO.' Bs.</td></tr>';
					}

					$paneles=\App\Producto::where('ID_TIP',2)->get();// CIELO ACUSTICO;
					foreach ($paneles as $panel) {
						$resultado_panel=round(($cotizacion->BASE*$cotizacion->ALTURA)/0.3721);
						if ($panel->EXT_PRO>=$resultado_panel) {
							$body.='<tr class="warning"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$panel->ID_PRO.'" value="'.$resultado_panel*$panel->PRE_PRO.'|'.$panel->ID_PRO.'|'.$resultado_panel.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$panel->PRE_PRO.' Bs.</td><td><b>'.$resultado_panel.'</b> (Unidades)</td><td>PERFILES '.$panel->NOM_PRO.'</td><td>'.$resultado_panel*$panel->PRE_PRO.' Bs.</td></tr>';
						}else{
							$body.='<tr class="warning"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$panel->PRE_PRO.' Bs.</td><td><b>'.$resultado_panel.'</b> (Unidades)</td><td>PERFILES '.$panel->NOM_PRO.'</td><td>'.$resultado_panel*$panel->PRE_PRO.' Bs.</td></tr>';
						}
					}
					// *******************  FIN CIELO FALSO ***************************
					// *******************  INICIO PISO FLOTANTE ***************************
					$resultado_membrana_telgopor=round(($cotizacion->ALTURA*$cotizacion->BASE)/24);
					$query_membrana_telgopor=\App\Producto::where('ID_PRO',31)->where('EXT_PRO','>=',$resultado_membrana_telgopor)->first();
					if ($query_membrana_telgopor->EXT_PRO>=$resultado_membrana_telgopor) {
						$body.='<tr class="info"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$query_membrana_telgopor->ID_PRO.'" value="'.$resultado_membrana_telgopor*$query_membrana_telgopor->PRE_PRO.'|'.$query_membrana_telgopor->ID_PRO.'|'.$resultado_membrana_telgopor.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$query_membrana_telgopor->PRE_PRO.' Bs.</td><td><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td><td>PERFILES '.$query_membrana_telgopor->NOM_PRO.'</td><td>'.$resultado_membrana_telgopor*$query_membrana_telgopor->PRE_PRO.' Bs.</td></tr>';
					}else{
						$body.='<tr class="info"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$query_membrana_telgopor->PRE_PRO.' Bs.</td><td><b>'.$resultado_membrana_telgopor.'</b> (Unidades)</td><td>PERFILES '.$query_membrana_telgopor->NOM_PRO.'</td><td>'.$resultado_membrana_telgopor*$query_membrana_telgopor->PRE_PRO.' Bs.</td></tr>';
					}

					$pisos=\App\Producto::where('ID_TIP',3)->get();// PISO FLOTANTE
					foreach ($pisos as $piso) {
						$resultado_piso=round(($cotizacion->ALTURA*$cotizacion->BASE)/0.24);
						if ($piso->EXT_PRO>=$resultado_piso) {
							$body.='<tr class="info"><td><input type="checkbox" class="flat-red combo" name="ch[]" id="'.$piso->ID_PRO.'" value="'.$resultado_piso*$piso->PRE_PRO.'|'.$piso->ID_PRO.'|'.$resultado_piso.'" onchange="elije(this)"></td></td><td>'.$mts2.' /mts2</td><td>'.$piso->PRE_PRO.' Bs.</td><td><b>'.$resultado_piso.'</b> (Unidades)</td><td>PERFILES '.$piso->NOM_PRO.'</td><td>'.$resultado_piso*$piso->PRE_PRO.' Bs.</td></tr>';
						}else{
							$body.='<tr class="info"><td class="text-danger"><i class="fa fa-ban fa-2x"></i></td></td><td>'.$mts2.' /mts2</td><td>'.$piso->PRE_PRO.' Bs.</td><td><b>'.$resultado_piso.'</b> (Unidades)</td><td>PERFILES '.$piso->NOM_PRO.'</td><td>'.$resultado_piso*$piso->PRE_PRO.' Bs.</td></tr>';
						}
					}
					// *******************  FIN PISO FLOTANTE ***************************

					echo $body;
					?>
					<input type="hidden" name="" id="seleccion_obrero" value="0">
					<tr id="body" class="warning"></tr>
					<tr class="danger">
						<td colspan="6" class="text-center">
							<h4>TOTAL:<b id="text_total">0</b> Bs.</h4>
							<input type="hidden" name="total_pagar" id="total_pagar" value="0">
						</td>
					</tr>
				</table>

				<table class="table table-bordered">
					<tr class="info">
						<td width="50%">
							<div class="form-group">
								<select class="form-control" name="id_obr" id="id_obr" onchange="obrero(this.value)">
									<option selected="" value="0">SIN OBRERO</option>
									@foreach($obreros as $obrero)
									<option value="{{$obrero->ID_USU}}">{{$obrero->NOM_USU.' '.$obrero->PAT_USU.' '.$obrero->MAT_USU}}</option>
									@endforeach
								</select>
							</div>
						</td>
						<td>
							<b>* ESTE CAMPO ES OPCIONAL</b><br>
							<b class="text-danger">(TOME EN CUENTA QUE SI SELECCIONA UN OBRERO SE LE AGREGARA 45 Bs. POR METRO CUADRADO AL TOTAL)</b>
						</td>
					</tr>
				</table>

                <input type="hidden" name="cantidad_seleccionada" id="cantidad_seleccionada" value="0">
				<button type="sumbit" class="btn btn-success btn-block" id="btn_confirma" disabled=""><i class="fa fa-ban"></i> DEBE SELECCIONAR AL MENOS UN PRODUCTO</button>


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
			$('#btn_confirma').html('<i class="fa fa-check"></i> CONFIRMAR VENTA');
			$('#btn_confirma').attr('disabled',false);
		}else{
			$('#btn_confirma').html('<i class="fa fa-ban"></i> DEBE SELECCIONAR AL MENOS UNA PLACA');
			$('#btn_confirma').attr('disabled',true);
		}

	});
</script>
<script type="text/javascript">
	function obrero(valor){
		console.log(valor);
		var total=parseInt($('#total_pagar').val());
		var costo_obrero=parseInt({{$mts2}}*45);
		var seleccion=$('#seleccion_obrero').val();
		if (valor==0) {
			var resultado=total-costo_obrero;
			$('#total_pagar').val(resultado);
			$('#text_total').html(resultado);
			$('#body').empty()
			$('#seleccion_obrero').val(0);
		}else{
			if (seleccion==0) {
				var resultado=total+costo_obrero;
				$('#total_pagar').val(resultado);
				$('#text_total').html(resultado);
				$('#body').html('<td colspan="6" class="text-center"><b>COSTO POR OBRERO 25 MTS2 x 45 Bs :</b> '+resultado+' Bs.</td>');
				$('#seleccion_obrero').val(1);
			}
		}

	}
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
