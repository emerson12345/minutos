{!! Form::open(['route' => 'adm.usuario.store' ,'class'=>'form-horizontal']) !!}
<div class="form-group">
    {!! Form::label('user_nombre', 'NOMBRE COMPLETO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('user_nombre',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_codigo', 'USUARIO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('user_codigo',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_password', 'PASSWORD', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::password('user_password',['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_password2', 'REPETIR PASSWORD', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::password('user_password2',['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_email', 'EMAIL', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::email('user_email',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_seleccionable', 'SEL', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        Vigente
        {!! Form::radio('user_seleccionable','1',true) !!}
        No vigente
        {!! Form::radio('user_seleccionable','0') !!}
        <span class="label label-warning"></span>
    </div>
</div>
<div class="form-group">
    {!! Form::label('role_list','ROLES',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('role_list[]',\Sicere\Models\Rol::where('rol_seleccionable',1)->pluck('rol_nombre','rol_id'),null,['class'=>'form-control', 'multiple'=>true,'id'=>'role_list','style'=>'width:100%']) !!}
    </div>
</div>
{!! Form::close() !!}