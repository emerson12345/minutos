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
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>SI</b>CERE
            </div>
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

                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary">
                            Ingresar
                        </button>
                    </div>

                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </body>
</html>