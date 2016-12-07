<!DOCTYPE html>
<html>
<head>
    <title>Sistema de información de centros de rehabilitación</title>
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
    <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
    <style>
        h1{
            padding: 0;
            margin: 0;
            color: #fff;
            font-size: 3.5em;
            font-family: "Arial";
            text-shadow: -2px -2px 0px #00f, 2px -2px 0px #00f, -2px 2px 0px #00f, 2px 2px 0px #00f,3px 3px 2px #00f;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="container-fluid">
    <div class="row well">
        <div class="col-md-2">
            <img src="{{asset('template/dist/img/bolivia.gif')}}" height="80px">
        </div>
        <div class="col-md-8 text-center">
            <h1>
                <img src="{{asset('template/dist/img/encabezado.jpg')}}" height="60px">
                <!-- Ministerio -->
            </h1>
        </div>
        <div class="col-md-2">
            <img src="{{asset('template/dist/img/minsalud-logo.jpg')}}" height="60px" class="pull-right">
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            </br></br></br></br></br></br>
            <div style= "float: right;">


                <img src="{{asset('template/dist/img/slogan1.gif')}}" height="100px" width="300px" class="pull-right">

            </div>
        </div>
        <div class="col-md-6">
            <div class="login-box">
                <div class="login-box-body">
                    @if(Auth::check() && Auth::user()->instituciones()->count() > 0)
                        <div class="login-box-msg">Seleccione la institucion a la que desea ingresar</div>
                        {{Form::open()}}
                        <div class="form-group">
                            <?php $list = Auth::user()->instituciones()->pluck('institucion.inst_nombre','institucion.inst_id');?>
                            <?php $list->prepend('Seleccione institucion','0');?>
                            {!! Form::select('selectCenter',$list,null,['class'=>'form-control','id'=>'select-center']) !!}
                        </div>
                        {{Form::close()}}
                    @else
                        <div class="callout callout-info">
                            <h4>Atencion!!!</h4>
                            <p>Ud. no esta registrado en ninguna institucion</p>
                            <p>Contactese con el administrador del sistema</p>
                        </div>
                    @endif
                    {!! Form::open(['route'=>'logout']) !!}
                    <button type="submit" class="btn btn-danger btn-group pull-right">Cancelar</button>
                    {!! Form::close() !!}
                    <div class="clearfix"></div>
                </div>

                </br></br></br></br></br></br>

                <div style="width:500px; height:100px;">
                    <img src="{{asset('template/dist/img/aicslogo.png')}}" height="60px" class="pull-right">

                </div>
            </div>
        </div>

    </div>
</div>




<div class="container-fluid well footer navbar-fixed-bottom" style="margin: 0;padding: 10px; width: 100%;text-align: center">
    <strong>Copyright ©</a>.</strong> Todos los derechos reservados
</div>
</body>
<script src="{{asset('template/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#select-center").on('change',function(){
            $(this).find('option[value = 0]').remove();
            $(this).closest('form').submit();
            return false;
        });
    });
</script>
</html>