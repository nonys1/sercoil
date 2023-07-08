@extends('layouts.master')
@section('reporte')
active
@endsection
@section('title')
REPORTES DEL SISTEMA
@endsection
@section('content')
<div class="col-md-12">
<div class="col-md-6">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">VENTAS POR FECHAS</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">FECHA INICIO:</label>
						<input type="date" class="form-control" name="fec_ini" id="fec_ini" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" onchange="click_fechas();" required>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">FECHA FINAL:</label>
						<input type="date" class="form-control" name="fec_fin" id="fec_fin" value="" onchange="click_fechas();" required>
					</div>
				</div>
				<div class="col-md-12 text-center" id="div_venta_fechas"></div>
			</div>	
		</div>
	</div>
</div>

<div class="col-md-6">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">VENTAS CLIENTES</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">CLIENTES:</label>
						<select class="form-control" name="id_cli" id="id_cli" onchange="click_cliente()">
							<option selected="" disabled="">-SELECCIONE UN CLIENTE-</option>
							@foreach($clientes as $cliente)
							<option value="{{$cliente->ID_CLI}}">{{$cliente->NOM_CLI}}</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="col-md-12 text-center" id="div_venta_clientes"></div>
			</div>	
		</div>
	</div>
</div>
</div>
<div class="col-md-12 row">
	
<div class="col-md-6">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">VENTAS PRODUCTOS</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">PRODUCTOS:</label>
						<select class="form-control" name="id_pro" id="id_pro" onchange="click_producto()">
							<option selected="" disabled="">-SELECCIONE UN PRODUCTO-</option>
							@foreach($productos as $producto)
							<option value="{{$producto->ID_PRO}}">{{$producto->NOM_PRO}}</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="col-md-12 text-center" id="div_venta_productos"></div>
			</div>	
		</div>
	</div>
</div>
	<div class="col-md-6">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">INGRESOS POR FECHAS</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">FECHA INICIO:</label>
						<input type="date" class="form-control" name="fec_ini_ing" id="fec_ini_ing" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" onchange="ingreso_fechas();" required>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleInputEmail1">FECHA FINAL:</label>
						<input type="date" class="form-control" name="fec_fin_ing" id="fec_fin_ing" value="" onchange="ingreso_fechas();" required>
					</div>
				</div>
				<div class="col-md-12 text-center" id="div_ingreso_fechas"></div>
			</div>	
		</div>
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
				<h4 class="modal-title">REPORTE</h4>
			</div>
			<!-- /modal-body -->
			<div id="div_reporte"></div>
		</div>
	</div>
</div>
<!--FIN DE MODAL NUEVO-->
@endsection
@section('js')
<script type="text/javascript">
	function click_fechas(){
		$('#div_venta_fechas').html('<button class="btn btn-info btn-block" onclick="venta_fechas()"><i class="fa fa-eye"></i> MOSTRAR</button>');
	}
	function venta_fechas(){
		var inicio=$('#fec_ini').val();
		var final=$('#fec_fin').val();
		var route= "{{route('reporte.fechas')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',     
			dataType:'html',     
			data: {inicio:inicio, final:final},
			success: function(data){
				console.log(data);
				$('#modalNuevo').modal('show');
				$('#div_reporte').html(data);
				
			},
			error: function(data){
				console.log(data);
			}
		});
		//$('#div_venta_fechas').html('<a href="reporte-fechas/'+inicio+'/'+final+'" target="_blank" class="btn btn-danger btn-block"><i class="fa fa-print"></i> IMPRIMIR</a>');
	}


	function click_cliente(){
		$('#div_venta_clientes').html('<button class="btn btn-info btn-block" onclick="venta_cliente()"><i class="fa fa-eye"></i> MOSTRAR</button>');
	}
	function venta_cliente(){
		var id_cli=$('#id_cli').val();
		var route= "{{route('reporte.clientes')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',     
			dataType:'html',     
			data: {"id_cli":id_cli},
			success: function(data){
				console.log(data);
				$('#modalNuevo').modal('show');
				$('#div_reporte').html(data);
				
			},
			error: function(data){
				console.log(data);
			}
		});
		//$('#div_venta_clientes').html('<a href="reporte-clientes/'+id_cli+'" target="_blank" class="btn btn-danger btn-block"><i class="fa fa-print"></i> IMPRIMIR</a>');
	}
	function click_producto(){
		$('#div_venta_productos').html('<button class="btn btn-info btn-block" onclick="venta_producto()"><i class="fa fa-eye"></i> MOSTRAR</button>');
	}
	function venta_producto(){
		var id_pro=$('#id_pro').val();
		var route= "{{route('reporte.productos')}}";
		$.ajax({
			url: route,           
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',     
			dataType:'html',     
			data: {"id_pro":id_pro},
			success: function(data){
				console.log(data);
				$('#modalNuevo').modal('show');
				$('#div_reporte').html(data);
				
			},
			error: function(data){
				console.log(data);
			}
		});
		//$('#div_venta_productos').html('<a href="reporte-productos/'+id_pro+'" target="_blank" class="btn btn-danger btn-block"><i class="fa fa-print"></i> IMPRIMIR</a>');
	}
	function ingreso_fechas(){
		var inicio=$('#fec_ini_ing').val();
		var final=$('#fec_fin_ing').val();
		$('#div_ingreso_fechas').html('<a href="reporte-ingresos/'+inicio+'/'+final+'" target="_blank" class="btn btn-danger btn-block"><i class="fa fa-print"></i> IMPRIMIR</a>');
	}
</script>
@endsection