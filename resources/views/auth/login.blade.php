<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('template/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('template/font-awesome/css/font-awesome.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('template/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('template/dist/css/skins/_all-skins.min.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        h1{
            padding: 0;
            margin: 0;
            color: #fff;
            font-size: 3.5em;
            font-family: "Arial Black";
            text-shadow: -2px -2px 0px #00f, 2px -2px 0px #00f, -2px 2px 0px #00f, 2px 2px 0px #00f,3px 3px 2px #00f;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="container-fluid">
    <div class="row well">
        <div class="col-md-2">
            <img src="{{asset('template/dist/img/bolivia.gif')}}" height="60px">
        </div>
        <div class="col-md-8 text-center">
            <h1>
                Ministerio de salud
            </h1>
        </div>
        <div class="col-md-2">
            <img src="{{asset('template/dist/img/minsalud-logo.jpg')}}" height="60px" class="pull-right">
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="login-box">
                <div class="login-box-body">
                    <div class="login-box-msg">Ingrese sus datos para iniciar sesion</div>
                    <form role="form" method="POST" action="{{ url('/login') }}">
                        {{csrf_field()}}
                        <div class="form-group has-feedback{{ $errors->has('user_codigo') ? ' has-error' : '' }}">
                            <input id="user_codigo" type="text" class="form-control" name="user_codigo" value="{{ old('user_codigo') }}" required autofocus placeholder="Usuario">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            @if ($errors->has('user_codigo'))
                                <span class="help-block">
                                <strong>{{ $errors->first('user_codigo') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            @if ($errors->has('password'))
                                <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Ingresar
                            </button>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid well" style="bottom: 0; position: absolute; margin: 0;padding: 10px; width: 100%;text-align: center">
    <strong>Copyright ©</a>.</strong> Todos los derechos reservados
</div>
</body>
</html>