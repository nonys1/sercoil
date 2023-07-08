@extends('layouts.master')
@section('home')
active
@endsection
@section('title')
ERROR DE ACCESO
@endsection
@section('content')
section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3 class="text-danger"><i class="fa fa-warning text-red"></i> SECCION RESTRINGIDA</h3>

          <p>
           Esta tratando de ingresar a una zona RESTRINGIDA, comuniquese con el ADMINISTRADOR para tener acceso
          </p>

          <form class="search-form">
            <a href="{{url('/home')}}" class="btn btn-warning btn-block"><i class="fa fa-home"></i> IR A INICIO</a>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    @endsection