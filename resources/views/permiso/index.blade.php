@extends('layouts.master')
@section('permiso')
active
@endsection
@section('title')
PERMISOS DEL SISTEMA
@endsection
@section('content')
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">ROLES REGISTRADOS</h3>
	</div>
	<div class="box-body">
			<br>
			<br>
			<div class="table-responsive">
				<table id="datatable" class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>PERMISO</th>
							<th>DESCRIPCION</th>
						</tr>
					</thead>
					<tbody>
						@foreach($permisos as $numero=>$permiso)
						<tr>
							<td>{{$numero+1}}</td>
							<td>{{$permiso->display_name}}</td>
							<td>{{$permiso->description}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div>
	</div>
</div>
@endsection