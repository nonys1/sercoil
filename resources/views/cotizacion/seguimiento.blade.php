@extends('layouts.master')
@section('venta')
active
@endsection
@section('title')
SEGUIMIENTO A LA VENTA REALIZADA
@endsection
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="box box-widget widget-user">
			<!-- Add the bg color to the header using any of the bg-* classes -->
			<?php
            $encargado=\App\User::where('ID_USU',$venta->ID_USU_ENC)->join('role_user','role_user.user_id','=','users.ID_USU')->join('roles','roles.id','=','role_user.role_id')->first();

            ?>

			<div class="widget-user-header bg-blue">
			@if($encargado)
				<h3 class="widget-user-username">{{$encargado->NOM_USU.' '.$encargado->PAT_USU.' '.$encargado->MAT_USU}}</h3>
				<h5 class="widget-user-desc">{{$encargado->display_name}}</h5>
			@else
				<h5 class="widget-user-username">SIN ENCARGADO</h5>
			@endif
			</div>
			<div class="widget-user-image">
				<img class="img-circle" src="{{url('principal/dist/img/user2.png')}}" alt="User Avatar">
			</div>
			<div class="box-footer">
				<div class="row">
					<div class="col-sm-12 border-right">
						<div class="description-block">
						<h5 class="description-header">ESTADO DEL TRABAJO</h5>
						@if($venta->EST_VEN==1)
							<span class="label bg-yellow">EN PROCESO</span>
						<br>
						<br>
						<form method="POST" action="{{route('cotizacion.finaliza')}}">
							{{csrf_field()}}
							<input type="hidden" name="id_ven" value="{{$venta->ID_VEN}}">
						<button type="submit" class="btn btn-danger btn-block"><i class="fa fa-check"></i> FINALIZAR TRABAJO</button>
						</form>
						@elseif($venta->EST_VEN==3)
							<span class="label bg-green">TRABAJO TERMINADO</span>
						@endif
						</div>
						<!-- /.description-block -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">SEGUIMIENTO</h3>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<?php $total_cotizacion=0; ?>
					<table class="table table-bordered table-striped table-hover">
						<tr class="danger">
							<th colspan="5" class="text-center"><h4>VENTAS DE COTIZACIÓN</h4></th>
						</tr>
						<tr class="danger">
							<th>#</th>
							<th>PRODUCTO</th>
							<th>MTS2</th>
							<th>CANTIDAD</th>
							<th>PRECIO</th>
						</tr>
						@foreach($cotizaciones as $numero=>$cotizacion)
						<tr>
							<th>{{$numero+1}}</th>
							<th>{{$cotizacion->NOM_PRO}}</th>
							<th>{{$cotizacion->MTS_VC}}/Mts2</th>
							<th>{{$cotizacion->CANT_VC}}</th>

							<th class="text-center"><h4>@if($cotizacion->RES_VC!=0) {{$cotizacion->RES_VC}} Bs.@endif</h4></th>
							<?php $total_cotizacion=$total_cotizacion+$cotizacion->RES_VC; ?>

						</tr>
						@endforeach
					</table>
				</div>


			</div>
		</div>
	</div>
</div>


@endsection
