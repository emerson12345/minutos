{!! Form::model($actividad) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('act_nro','Nro. de orden') !!}
            {!! Form::text('act_nro',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_fecha','Fecha') !!}
            {!! Form::text('act_fecha',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_apellido_nombre','Apellidos y nombres (profesional)') !!}
            {!! Form::text('act_apellido_nombre',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_educativas_familia','Nro. de actividades educativas de rehabilitacion enfocadas a la familia') !!}
            {!! Form::text('act_nro_educativas_familia',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_comunidad','Nro. de actividades realizadas con participación de la comunidad' ) !!}
            {!! Form::text('act_nro_comunidad',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_cai', 'Nro. CAI de Servicio de Rehabilitación') !!}
            {!! Form::text('act_nro_cai',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('act_nro_cai_os', 'Nro. Comunidades y/o Organizaciones Sociales que participaron en el CAI del Servicio de Rehabilitacion') !!}
            {!! Form::text('act_nro_cai_os',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_comite_salud','Nro. Reuniones Comites Loc De Salud Mun Salud' ) !!}
            {!! Form::text('act_nro_comite_salud',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_supervision','Supervisiones al Servicio de Rehabilitacion' ) !!}
            {!! Form::text('act_nro_supervision',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_auditoria','Nro. Auditorias internas en salud en aplicación de norma técnica') !!}
            {!! Form::text('act_nro_auditoria',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_educativas_salud','Nro. Actividades educativas en salud') !!}
            {!! Form::text('act_nro_educativas_salud',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_seleccionable','Vigente') !!}
            {!! Form::text('act_seleccionable',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>
    </div>
</div>

{!! Form::close() !!}