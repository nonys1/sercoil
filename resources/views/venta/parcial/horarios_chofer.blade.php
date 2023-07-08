<?php 
$ha=\Carbon\Carbon::now()->format('H:i:s');
$asignado=\App\Venta::join('users','users.ID_USU','venta.ID_USU_CH')
->join('ubicacion','ubicacion.ID_VEN','venta.ID_VEN')
->where('FEC_ENV',$fec_env)
->where('ID_USU_CH',$chofer->ID_USU)
->where('HOR_INI','<',$hor_fin)
->where('HOR_FIN','>',$hor_ini)
->first();
?>
@if($asignado)
<div class="box-body">
	<div class="alert alert-danger ">
		<h4><i class="icon fa fa-ban"></i> EXISTE UN HORARIO ASIGNADO</h4>
		<table class="table table-bordered">
			<tr>
				<td>
					<b>CHOFER:</b> {{$asignado->NOM_USU.' '.$asignado->PAT_USU.' '.$asignado->MAT_USU}}
				</td>
				<td>
					<b>DESDE:</b> {{$asignado->HOR_INI}} <b>HASTA:</b> {{$asignado->HOR_FIN}}
				</td>
			</tr>
			<tr>
				<td>
					<b>FECHA:</b> {{$asignado->FEC_ENV}}
				</td>
				<td>
					<b>DIRECCION:</b> {{$asignado->UBI_UBI}}
				</td>
			</tr>
		</table>
	</div>
</div>
@else
<div class="box-body">
	<div class="alert alert-success ">
		<h4><i class="icon fa fa-check-circle"></i> CHOFER DISPONIBLE</h4>
		<p>Los horarios que asignó se encuentran disponibles</p>
	</div>
</div>
<div class="">
	<button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Registrar direccion</button>
	<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
</div>
@endif
