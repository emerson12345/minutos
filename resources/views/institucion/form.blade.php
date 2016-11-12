{!! Form::model($institucion,['class'=>'form-horizontal']) !!}

                <div class="form-group">
                    {!! Form::label('inst_codigo', 'CÓDIGO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_codigo',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_nombre', 'NOMBRE', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_nombre',null,['class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_telf1', 'TELÉFONO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_telf1',null,['class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_telf2', 'TELÉFONO DOS', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_telf2',null,['class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_fax', 'FAX', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_fax',null,['class'=>'form-control','require']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_email', 'EMAIL', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::email('inst_email',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_nit', 'NIT', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_nit',null,['class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('dep_id', 'DEPARTAMENTO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('dep_id',$departamento ,null,['placeholder'=>'Selecciona','class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('prov_id', 'PROVINCIA', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('prov_id',$provincia,$institucion->prov_id,['placeholder'=>'Selecciona','class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('mun_id', 'MUNICIPIO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::select('mun_id',$municipio,$institucion->mun_id,['placeholder'=>'Selecciona','class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_localidad', 'LOCALIDAD', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_localidad',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_direccion_zona', 'ZONA', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_direccion_zona',null,['class'=>'form-control']) !!}
                        <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_direccion_calle', 'DIRECCIÓN', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('inst_direccion_calle',null,['class'=>'form-control']) !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('inst_seleccionable', 'ESTADO', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        Vigente
                        {!! Form::radio('inst_seleccionable','1',true) !!}
                        No vigente
                        {!! Form::radio('inst_seleccionable','0') !!}
                            <span class="label label-warning"></span>
                    </div>
                </div>

{!! Form::close() !!}

    <script>
        $('#dep_id').change(function (e) {
            var parent = e.target.value;
            $.get('{{ url('provincia/')}}' + '/getprovincia?dep_id=' + parent, function (data) {
                $('#prov_id').empty();
                $.each(data, function (key, value) {
                    var option = $("<option></option>")
                            .attr("value", key)
                            .text(value);
                    $('#prov_id').append(option);
                });
            });
        });
        /*-----------------*/
        $('#prov_id').change(function (e) {
            var parent = e.target.value;
            $.get('{{ url('municipio/')}}' + '/getmunicipio?prov_id=' + parent, function (data) {
                $('#mun_id').empty();
                $.each(data, function (key, value) {
                    var option = $("<option></option>")
                            .attr("value", key)
                            .text(value);
                    $('#mun_id').append(option);
                });
            });
        });

    </script>