{!! Form::model($agenda,['class'=>'form-horizontal','id'=>'agenda-form']) !!}

<div class="form-group">
    {!! Form::label('pac_id', 'PACIENTE', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <select name="pac_id" id="pac_id" class="form-control" data-url="{{route('agenda.pacientes')}}">
        </select>
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('rrhh_id', 'MEDICO', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <select name="rrhh_id" id="rrhh_id" class="form-control"  data-url="{{route('agenda.medicos')}}">
        </select>
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('agenda_fec_ini', 'FECHA Y HORA', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('agenda_fec_ini',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('agenda_descripcion', 'DESCRIPCION', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('agenda_descripcion',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('duracion', 'DURACION (min)', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('duracion',15,['class'=>'form-control','id'=>'duracion']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('sesiones', 'SESIONES', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('sesiones',1,['class'=>'form-control','id'=>'sesiones']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('dias','DIAS',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <label for="dia-lun">Lun.</label>
        <input type="checkbox" name="dia[]" value="1" id="dia-lun" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="dia-mar">Mar.</label>
        <input type="checkbox" name="dia[]" value="2" id="dia-mar" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="dia-mie">Mie.</label>
        <input type="checkbox" name="dia[]" value="3" id="dia-mie" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="dia-jue">Jue.</label>
        <input type="checkbox" name="dia[]" value="4" id="dia-jue" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="dia-vie">Vie.</label>
        <input type="checkbox" name="dia[]" value="5" id="dia-vie" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;<br>
        <span class="label label-warning"></span>
    </div>
</div>
{!! Form::close() !!}