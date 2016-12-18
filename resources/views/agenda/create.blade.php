{!! Form::model($agenda,['class'=>'form-horizontal','id'=>'agenda-form']) !!}

<div class="form-group">
    {!! Form::label('pac_id', 'Paciente', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <select name="pac_id" id="pac_id" class="form-control" data-url="{{route('agenda.pacientes')}}">
        </select>
        <span class="label label-warning"></span>
    </div>
</div>
<!--Comment-->

<div class="form-group">
    {!! Form::label('cua_id', 'Servicio', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <?php $cuaderno = Auth::user()->cuadernos()->where('cua_seleccionable',1)->pluck('lib_cuadernos.cua_nombre','lib_cuadernos.cua_id');?>
        {!! Form::select('cua_id',$cuaderno,null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('agenda_fec_ini', 'Fecha y hora', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('agenda_fec_ini',null,['class'=>'form-control']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('agenda_descripcion', 'Pauta de tratamiento', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('agenda_descripcion',null,['class'=>'form-control','maxlength'=>200]) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('duracion', 'Duración (min)', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('duracion',35,['class'=>'form-control','id'=>'duracion']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('sesiones', 'Número de sesiones', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        {!! Form::text('sesiones',1,['class'=>'form-control','id'=>'sesiones']) !!}
        <span class="label label-warning"></span>
    </div>
</div>

<div class="form-group">
    {!! Form::label('dias','Días',['class'=>'col-sm-2 control-label']) !!}
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
        <input type="checkbox" name="dia[]" value="5" id="dia-vie" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="dia-sab">Sab.</label>
        <input type="checkbox" name="dia[]" value="6" id="dia-sab" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;
        <label for="dia-dom">Dom.</label>
        <input type="checkbox" name="dia[]" value="0" id="dia-dom" class="week-day">&nbsp;&nbsp;&nbsp;&nbsp;<br>
        <span class="label label-warning"></span>
    </div>
</div>
{!! Form::close() !!}