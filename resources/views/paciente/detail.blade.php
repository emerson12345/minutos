<table class="table table-bordered table-hover table-striped table-condensed">
    <thead>
    <tr>
        <th colspan="2" style="text-align: center">
            DETALLE DEL PACIENTE
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th width="30%">Número H.C.</th>
        <td>{{$paciente->pac_nro_hc}}</td>
    </tr>
    <tr>
        <th>C.I.</th>
        <td>{{$paciente->pac_nro_ci}} ({{$paciente->expedido->exp_nombre}})</td>
    </tr>
    <tr>
        <th>Apellidos y nombre(s)</th>
        <td>{{$paciente->nombreCompleto}}</td>
    </tr>
    <tr>
        <th>Sexo</th>
        <td>{{$paciente->pac_sexo=='M'?'Mujer':'Hombre'}}</td>
    </tr>
    <tr>
        <th>Fecha de nacimiento - Edad</th>
        <td>{{date('d/m/Y',strtotime($paciente->pac_fecha_nac))}} - {{$paciente->pac_edad_anio}}</td>
    </tr>
    <tr>
        <th>Estado civil</th>
        <td>{{$paciente->estadoCivil? $paciente->estadoCivil->est_civ_nombre:''}}</td>
    </tr>

    <tr>
        <th>Ocupación</th>
        <td>{{$paciente->pac_ocupacion}}</td>
    </tr>

    <tr>
        <th>Departamento</th>
        <td>{{$paciente->departamento?$paciente->departamento->dep_nombre:''}}</td>
    </tr>

    <tr>
        <th>Municipio</th>
        <td>{{$paciente->municipio?$paciente->municipio->mun_nombre:''}}</td>
    </tr>

    <tr>
        <th>Comunidad</th>
        <td>{{$paciente->pac_comunidad}}</td>
    </tr>

    <tr>
        <th>Dirección</th>
        <td>{{$paciente->pac_direccion}}</td>
    </tr>

    <tr>
        <th>Teléfono</th>
        <td>{{$paciente->pac_nro_telf}}</td>
    </tr>

    <tr>
        <th>Con discapacidad permanente</th>
        <td>
            @if($paciente->pac_con_discapaci)
                <span class="badge bg-blue">SI</span>
                {{$paciente->tipoDiscapacidad? ' TIPO: '.$paciente->tipoDiscapacidad->tipo_disc_nombre:''}}
                {{$paciente->gradoDiscapacidad? ' GRADO: '.$paciente->gradoDiscapacidad->grad_disc_nombre:''}}
            @else
                <span class="badge bg-blue">NO</span>
            @endif
        </td>
    </tr>
    <tr>
        <th>Estado</th>
        <td>
            @if($paciente->pac_seleccionable)
                <span class="badge bg-blue">VIGENTE</span>
            @else
                <span class="badge bg-red">NO VIGENTE</span>
            @endif

        </td>
    </tr>
    <tr>
        <th>Fecha de alta</th>
        <td>{{date('d/m/Y H:i:s',strtotime($paciente->pac_fec_alta))}}</td>
    </tr>
    <tr>
        <th>Fecha de última modificación</th>
        <td>{{date('d/m/Y H:i:s',strtotime($paciente->pac_fec_mod))}}</td>
    </tr>
    </tbody>
</table>

@if(count($paciente->grupoFamiliar))
    <table class="table table-hover table-bordered table-striped table-condensed">
        <thead>
        <tr>
            <th colspan="7" style="text-align: center">GRUPO FAMILIAR</th>
        </tr>
        <tr>
            <th>Parentestco</th>
            <th>CI</th>
            <th>Apellidos y nombres</th>
            <th>Sexo</th>
            <th>Dirección</th>
            <th>Teléfono</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paciente->grupoFamiliar as $persona)
            <tr>
                <td>{{$persona->parentesco->parent_nombre}}</td>
                <td>{{$persona->gru_fam_nro_ci}}</td>
                <td>
                    {{$persona->gru_fam_ap_prim}} {{$persona->gru_fam_ap_seg}} {{$persona->gru_fam_nombre}}
                    @if(!$persona->gru_fam_seleccionable)
                        (Fallecido)
                    @endif
                </td>
                <td>{{$persona->gru_fam_sexo=='M'?'Mujer':'Hombre'}}</td>
                <td>{{$persona->gru_fam_direccion}}</td>
                <td>{{$persona->gru_fam_telf}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-info">
        <strong>Atencion!!!</strong>
        No existe registros para el grupo familiar del paciente
    </div>
@endif
