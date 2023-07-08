<!DOCTYPE html>
                <html>
                <head>
                  <meta charset="utf-8">
                  <meta http-equiv="X-UA-Compatible" content="IE=edge">
                  <title>.:PROZAZA:.</title>
                  <!-- Tell the browser to be responsive to screen width -->
                  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                  <!-- Bootstrap 3.3.7 -->
                  <link rel="stylesheet" href="principal/bower_components/bootstrap/dist/css/bootstrap.min.css">
                  <!-- Font Awesome -->
                  <link rel="stylesheet" href="fa/css/font-awesome.min.css">
                  <!-- Ionicons -->
                  <!-- Theme style -->
                  <link rel="stylesheet" href="principal/dist/css/AdminLTE.min.css">
                  <!-- iCheck -->
                  <link rel="stylesheet" href="principal/plugins/iCheck/square/blue.css">



                  <!-- Google Font -->
                  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
              </head>
              <body  style=" background-image:url('{{ url('img/banner.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center; background-attachment: fixed; " ">
                <div class="login-box">
                  <div class="login-logo" style="background-color: white;">
                      <a href="" ><b>PROZAZA</b></a>
                      <br>
                      <img src="{{url('img/logo.jpg')}}" width="30%">
                  </div>
                  <!-- /.login-logo -->
                  
                  <div class="login-box-body">
                    <form  method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group has-feedback">
                          <div class="form-group{{ $errors->has('USU_USU') ? ' has-error' : '' }}">
                            <input id="USU_USU" type="text" class="form-control" name="USU_USU" value="{{ old('USU_USU') }}" required autofocus placeholder="USUARIO">
                            @if ($errors->has('USU_USU'))
                            <span class="help-block">
                                <strong>{{ $errors->first('USU_USU') }}</strong>
                            </span>
                            @endif
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="CONTRASEÑA">
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                </div>
                <div class="row">
                    
              <!-- /.col -->
              <div class="col-xs-12 text-center">
                  <button type="submit" class="btn btn-primary btn-block ">INGRESAR</button>
              </div>
              <!-- /.col -->
          </div>
      </form>
       <p class="login-box-msg">Inicie sesion para poder ingresar al sistema</p>
  </div>



  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="principal/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="principal/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plantilla-dist/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
  });
});
</script>
</body>
</html>