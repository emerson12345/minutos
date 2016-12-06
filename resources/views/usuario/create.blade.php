{!! Form::open(['route' => 'adm.usuario.store' ,'class'=>'form-horizontal']) !!}
<div class="form-group">
    {!! Form::label('rrhh_id', 'RRHH', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        {!! Form::select('rrhh_id',[],null,['class'=>'form-control','data-url'=>route('adm.usuario.rrhh')]) !!}
        {!! Form::hidden('user_nombre',null,['id'=>'user_nombre']) !!}
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
    {!! Form::label('role_list','Roles',['class'=>'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <span class="label label-warning"></span>
        {!! Form::select('role_list[]',\Sicere\Models\Rol::where('rol_seleccionable',1)->pluck('rol_nombre','rol_id'),null,
        ['class'=>'form-control roles',
        'multiple'=>true,
        'id'=>'role_list',
        'style'=>'width:100%']) !!}
    </div>
</div>
{!! Form::close() !!}