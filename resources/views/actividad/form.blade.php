{!! Form::model($actividad) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('act_nro','Nro. de orden') !!}
            {!! Form::text('act_nro',$actividad->exists?null:$actividad->max_nro_orden()+1,['class'=>'form-control','disabled'=>'disabled']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_fecha','Fecha') !!}
            {!! Form::text('act_fecha',$actividad->act_fecha?date('d/m/Y'):'',['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_apellido_nombre','Apellidos y nombres (profesional)') !!}
            {!! Form::text('act_apellido_nombre',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_educativas_familia','Nro. de actividades educativas de rehabilitacion enfocadas a la familia') !!}
            {!! Form::text('act_nro_educativas_familia',$actividad->act_nro_educativas_familia?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_comunidad','Nro. de actividades realizadas con participación de la comunidad' ) !!}
            {!! Form::text('act_nro_comunidad',$actividad->act_nro_comunidad?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_cai', 'Nro. CAI de Servicio de Rehabilitación') !!}
            {!! Form::text('act_nro_cai',$actividad->act_nro_cai?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('act_nro_cai_os', 'Nro. Comunidades y/o Organizaciones Sociales que participaron en el CAI del Servicio de Rehabilitacion') !!}
            {!! Form::text('act_nro_cai_os',$actividad->act_nro_cai_os?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_comite_salud','Nro. Reuniones Comites Loc De Salud Mun Salud' ) !!}
            {!! Form::text('act_nro_comite_salud',$actividad->act_nro_comite_salud?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_supervision','Supervisiones al Servicio de Rehabilitacion' ) !!}
            {!! Form::text('act_nro_supervision',$actividad->act_nro_supervision?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_auditoria','Nro. Auditorias internas en salud en aplicación de norma técnica') !!}
            {!! Form::text('act_nro_auditoria',$actividad->act_nro_auditoria?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        <div class="form-group">
            {!! Form::label('act_nro_educativas_salud','Nro. Actividades educativas en salud') !!}
            {!! Form::text('act_nro_educativas_salud',$actividad->act_nro_educativas_salud?:0,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>

        @if($actividad->exists)
        <div class="form-group">
            {!! Form::label('act_seleccionable','Vigente') !!}<br>
            <label for="est_si">SI</label>
            {!! Form::radio('act_seleccionable','1',true,['id'=>'est_si']) !!}
            &nbsp;&nbsp;&nbsp;&nbsp;
            <label for="est_no">NO</label>
            {!! Form::radio('act_seleccionable','0',false, ['id'=>'est_no']) !!}
            <span class="label label-warning"></span>
        </div>
        @else
            {!! Form::hidden('act_seleccionable',1) !!}
        @endif
    </div>
</div>

{!! Form::close() !!}