{!! Form::model($rrhh,['class'=>'form-horizontal']) !!}
    <div class="form-group">
        {!! Form::label('rrhh_ci', 'C.I.', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-10">
            {!! Form::text('rrhh_ci',null,['class'=>'form-control']) !!}
            <span class="label label-warning"></span>
        </div>
    </div>
                <div class="form-group">
                    {!! Form::label('rrhh_ap_prim', 'PRIMER APELLIDO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rrhh_ap_prim',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_ap_seg', 'SEGUNDO APELLIDO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rrhh_ap_seg',null,['class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_nombre', 'NOMBRE', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rrhh_nombre',null,['class'=>'form-control','required'=>true]) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_fecha_nac', 'FECHA DE NACIMIENTO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rrhh_fecha_nac',null,['class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_sexo', 'SEXO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        HOMBRE
                        {!! Form::radio('rrhh_sexo','H') !!}
                        MUJER
                        {!! Form::radio('rrhh_sexo','M') !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_direccion_calle', 'DIRECCIÓN', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rrhh_direccion_calle',null,['class'=>'form-control','require']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_telf_celular', 'TELÉFONO/CELULAR', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('rrhh_telf_celular',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_email', 'EMAIL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::email('rrhh_email',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('prof_id', 'PROFECIÓN', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('prof_id',$profesion_list ,null,['placeholder'=>'Selecciona','class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_tipo_id', 'TIPO DE PERSONAL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('rrhh_tipo_id',$tipo_rrhh_list,null,['placeholder'=>'Selecciona','class'=>'form-control','require']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('rrhh_seleccionable', 'ESTADO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        Vigente
                        {!! Form::radio('rrhh_seleccionable','1',true) !!}
                        No vigente
                        {!! Form::radio('rrhh_seleccionable','0') !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

{!! Form::close() !!}
