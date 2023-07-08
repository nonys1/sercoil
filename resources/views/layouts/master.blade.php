<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>.:PROZAZA:.</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  {!! Html::style('principal/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
  <!-- Font Awesome -->
  {!! Html::style('principal/bower_components/font-awesome/css/font-awesome.min.css') !!}
  <!-- Ionicons -->
  {!! Html::style('principal/bower_components/Ionicons/css/ionicons.min.css') !!}
  <!-- Theme style -->
  {!! Html::style('principal/dist/css/AdminLTE.min.css') !!}
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  {!! Html::style('principal/dist/css/skins/_all-skins.min.css') !!}
  {!! Html::style('principal/plugins/iCheck/all.css') !!}

  {!! Html::style('principal/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') !!}
  {!! Html::style('principal/bower_components/select2/dist/css/select2.min.css') !!}
  {!! Html::style('css/font-awesome-animation.min.css') !!}

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  {!! Html::script('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') !!}</script>
  {!! Html::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') !!}</script>
  <![endif]-->

  <!-- Google Font -->
  {!! Html::style('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic') !!}
  {!! Html::style('principal/bower_components/animate-css/animate.css') !!}

  {!! Html::style('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') !!}
  <style type="text/css">
    .box-body{
      margin:30px; margin-top: 0px; 
      margin-bottom: 0px;
    }
    .color-box{
      background-color: white;
    }
    .color-table{
      background-color: white;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini fixed ">
  <!-- Site wrapper -->
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="../../index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>PRO</b>ZAZA</span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->
         
            <!-- Notifications: style can be found in dropdown.less -->
         
            <!-- Tasks: style can be found in dropdown.less -->
            @if(Auth::user()->can('cotizaciones'))
              <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-dollar"></i>
            </a>
            <ul class="dropdown-menu">
              <li class="header">COTIZACIONES DEL SISTEMA</li>
              <li class="bg-success">
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="{{url('/cotizacion')}}">
                      <i class="fa fa-check text-white"></i> PARED DRYWALL
                    </a>
                  </li>
                  <li>
                    <a href="{{url('/cotizacion_cielo')}}">
                      <i class="fa fa-check text-white"></i> CIELO ACUSTICO
                    </a>
                  </li>
                  <li>
                    <a href="{{url('/cotizacion_piso')}}">
                      <i class="fa fa-check text-white"></i> CIELO PISO FLOTANTE
                    </a>
                  </li>
                  <li>
                    <a href="{{url('/cotizacion_personal')}}">
                      <i class="fa fa-check text-white"></i> PERSONALIZADA
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          @endif
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{url('principal/dist/img/user.png')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->NOM_USU.' '.Auth::user()->PAT_USU}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{url('principal/dist/img/user.png')}}" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->NOM_USU.' '.Auth::user()->PAT_USU}}<br>
                  <b> {{Auth::user()->roles()->first()->display_name}}</b>
                </p>
              </li>
             
              </li>
              <!-- Menu Footer-->
              <li class="user-footer" style="background-color: #064594;">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">USUARIO</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat"  onclick="event.preventDefault();document.getElementById('logout-form').submit();">SALIR</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('principal/dist/img/user.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->NOM_USU.' '.Auth::user()->PAT_USU}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{Auth::user()->roles()->first()->display_name}}</a>
        </div>
      </div>
      <!-- search form -->
     
      <!-- /.search form -->
      <style type="text/css">
        .mili{
          padding-top: 7px !important;
          padding-bottom: 7px !important;
        }
      </style>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU PRINCIPAL</li>
        <li class="@yield('home')"><a class="mili" href="{{url('/home')}}"><i class="fa fa-home"></i> <span>INICIO</span></a></li>
        @if(Auth::user()->can('usuarios'))
        <li class="@yield('usuario')"><a class="mili" href="{{url('/usuario')}}"><i class="fa fa-users"></i> <span>USUARIOS</span></a></li>
        @endif
        @if(Auth::user()->can('roles_permisos'))
        <li class="@yield('rol')"><a class="mili" href="{{url('/rol')}}"><i class="fa fa-tasks"></i> ROLES </a></li>
        <li class="@yield('permiso')"><a class="mili" href="{{url('/permiso')}}"><i class="fa fa-shield"></i> PERMISOS </a></li>
        @endif
        @if(Auth::user()->can('categorias'))
        <li class="@yield('categoria')"><a class="mili" href="{{url('/categoria')}}"><i class="fa fa-folder-open"></i> CATEGORIAS </a></li>
        @endif
        @if(Auth::user()->can('clientes'))
        <li class="@yield('cliente')"><a class="mili" href="{{url('/cliente')}}"><i class="fa fa-users"></i> CLIENTES </a></li>
        @endif
        @if(Auth::user()->can('productos'))
        <li class="@yield('producto')"><a class="mili" href="{{url('/producto')}}"><i class="fa fa-cubes"></i> PRODUCTOS </a></li>
        @endif
        @if(Auth::user()->can('ingresos'))
        <li class="@yield('ingreso')"><a class="mili" href="{{url('/ingreso')}}"><i class="fa fa-mail-reply-all"></i> INGRESOS </a></li>
        @endif
        @if(Auth::user()->can('proveedores'))
        <li class="@yield('proveedor')"><a class="mili" href="{{url('/proveedor')}}"><i class="fa fa-truck"></i> PROVEEDORES </a></li>
        @endif
        
        @if(Auth::user()->can('cotizaciones'))
        <li class="treeview @yield('tree_cotizacion')">
          <a class="mili" href="#">
            <i class="fa fa-dollar"></i> <span>COTIZACIONES</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@yield('li_cotizacion')"><a class="mili" href="{{url('/cotizacion')}}"><i class="fa fa-circle-o"></i> Pared Drywall</a></li>
            <li class="@yield('li_cotizacion_cielo')"><a class="mili" href="{{url('/cotizacion_cielo')}}"><i class="fa fa-circle-o"></i> Cielo Acustico</a></li>
            <li class="@yield('li_cotizacion_piso')"><a class="mili" href="{{url('/cotizacion_piso')}}"><i class="fa fa-circle-o"></i> Piso flotante</a></li>
            <li class="@yield('li_personalizada')"><a class="mili" href="{{url('/cotizacion_personal')}}"><i class="fa fa-circle-o"></i> Personalizada</a></li>
          </ul>
        </li>

        @endif
        @if(Auth::user()->can('ventas'))
        <li class="@yield('venta')"><a class="mili" href="{{url('/venta')}}"><i class="fa fa-money"></i> VENTAS </a></li>
        @endif
        @if(Auth::user()->can('reportes'))
        <li class="@yield('reporte')"><a class="mili" href="{{url('/reporte')}}"><i class="fa fa-file-text-o"></i> REPORTES </a></li>
        <li class="@yield('grafico')"><a class="mili" href="{{url('/grafico')}}"><i class="fa fa-pie-chart"></i> GRAFICOS </a></li>
        <li class="@yield('grafico')"><a class="mili" href="{{url('/grafico')}}"><i class="fa fa-circle-o"></i> OPTIMIZADOR CORTES </a></li>
        @endif
        
        

        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>@yield('title')</h1>

    </section>

    <!-- Main content -->
    <section class="content">






     @if (Session::has('exito'))
     {!! Html::script('principal/bower_components/jquery/dist/jquery.min.js') !!}
     <script type="text/javascript">
       $(document).ready(function(){ 
        $.notify({
          icon:'<i class="fa fa-check"></i> ',
          title:'<strong>EXITO!</strong></br>',
          message:"{{ '  '.Session::get('exito')}}"
        },{
          type:'success',
          animate:{
            enter:'animated flipInY',
            exit:'animated flipOutY'
          }
        });
      });
    </script>
    @endif
    @if (Session::has('error'))
    {!! Html::script('principal/bower_components/jquery/dist/jquery.min.js') !!}
    <script type="text/javascript">
     $(document).ready(function(){ 
      $.notify({
       icon:'<i class="fa fa-ban"></i> ',
       title:'<strong>ERROR!</strong></br>',
       message:"{{ '  '.Session::get('error')}}"
     },{
      type:'danger',
      animate:{
        enter:'animated flipInY',
        exit:'animated flipOutY'
      }
    });
    });
  </script>
  @endif




  @yield('content')







</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.0
  </div>
  <strong>Copyright &copy; {{date('Y')}} <a href="#">PROZAZA</a>.</strong> Derechos reservados.
</footer>


  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
{!! Html::script('principal/bower_components/jquery/dist/jquery.min.js') !!}
<!-- Bootstrap 3.3.7 -->
{!! Html::script('principal/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
<!-- SlimScroll -->
{!! Html::script('principal/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') !!}
<!-- FastClick -->
{!! Html::script('principal/bower_components/fastclick/lib/fastclick.js') !!}
<!-- AdminLTE App -->
{!! Html::script('principal/dist/js/adminlte.min.js') !!}
<!-- AdminLTE for demo purposes -->
{!! Html::script('principal/dist/js/demo.js') !!}
<!-- DataTables -->
{!! Html::script('principal/bower_components/datatables.net/js/jquery.dataTables.min.js') !!}
{!! Html::script('principal/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') !!}
{!! Html::script('principal/bower_components/select2/dist/js/select2.full.min.js') !!}
<!-- Notificaciones -->
{!! Html::script('principal/bower_components/notifications/bootstrap-notify.js') !!}
{!! Html::script('principal/bower_components/validation/parsley.min.js') !!}
{!! Html::script('principal/plugins/iCheck/icheck.min.js') !!}

{!! Html::script('plugins/moment/moment.min.js') !!}
{!! Html::script('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}
{!! Html::script('validation/mivalidacion.js') !!}
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
<script>

  $(function () {

    $('#datatable').DataTable({


       destroy:true, //habilita que podamos editar con este codigo y que no muestre la ventanita de error
       searching:true,
       "ordering":false,
       "pagingType":
       "full_numbers",
       "lengthMenu":[
       [10,25,50,-1],
       [10,25,50,"All"]
       ],
       responsive:true,
       "language": {
        serarch: "_INPUT_",
        searchPlaceholder:
        "Buscar","lengthMenu":"Mostrar _MENU_ Registro por página",
        "zeroRecords": "No se encontro ningun  registro","info":"Mostrando pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros","infoFiltered":"(Filtro de_MAX_registros)",
        "paginate":{
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
      },
      "sSearch":"Buscar",
      "decimal": "",
      "emptyTable": "No existe ningun registro...",
      "infoPostFix": "",
      "thousands": ",",
      "loadingRecords":
      "Cargando registros...",
      "processing":
      "Procesando registro...",
  }
});
    $('#datatable2').DataTable({
       destroy:true, //habilita que podamos editar con este codigo y que no muestre la ventanita de error
       searching:true,
       "pagingType":
       "full_numbers",
       "lengthMenu":[
       [10,25,50,-1],
       [10,25,50,"All"]
       ],
       responsive:true,
       "language": {
        serarch: "_INPUT_",
        searchPlaceholder:
        "Buscar","lengthMenu":"Mostrar _MENU_ Registro por página",
        "zeroRecords": "No se encontro ningun  registro","info":"Mostrando pagina _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros","infoFiltered":"(Filtro de_MAX_registros)",
        "paginate":{
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
      },
      "sSearch":"Buscar",
      "decimal": "",
      "emptyTable": "No existe ningun registro...",
      "infoPostFix": "",
      "thousands": ",",
      "loadingRecords":
      "Cargando registros...",
      "processing":
      "Procesando registro...",
  }
});
});
</script>
<script type="text/javascript">
  function may(e) {
      e.value = e.value.toUpperCase();
  }
</script>
@yield('js')
</body>
</html>
