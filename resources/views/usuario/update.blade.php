{!! Form::model($usuario,['route' => ['adm.usuario.edit',$usuario->user_id] ,'class'=>'form-horizontal']) !!}

<div class="form-group">
    {!! Form::label('user_nombre', 'Recurso humano', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('user_nombre',null,['class'=>'form-control', 'disabled'=>'disabled']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_codigo', 'Nombre de usuario', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::text('user_codigo',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_password', 'Contraseña', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::password('user_password',['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_password2', 'Repetir contraseña', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::password('user_password2',['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_email', 'Email', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::email('user_email',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('user_seleccionable', 'Estado', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        Vigente
        {!! Form::radio('user_seleccionable','1',true) !!}
        No vigente
        {!! Form::radio('user_seleccionable','0') !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('role_list','Roles',['class'=>'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <span class="label label-warning"></span>
        {!! Form::select('role_list[]',\Sicere\Models\Rol::where('rol_seleccionable',1)->pluck('rol_nombre','rol_id'),$usuario->roles()->pluck('rol.rol_id')->toArray(),['class'=>'form-control roles', 'multiple'=>true,'id'=>'role_list','style'=>'width:100%']) !!}
    </div>
</div>

{!! Form::close() !!}