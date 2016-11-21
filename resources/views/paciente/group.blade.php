<div class="row">
    <div class="col-md-12">
        <span class="text-uppercase">{{$paciente->nombreCompleto}}</span>
        <button class="btn btn-add-group btn-primary btn-xs margin-bottom pull-right" data-url="{{route('adm.paciente.group.create',['pac_id'=>$paciente->pac_id])}}">
            <i class="fa fa-plus"></i> Nuevo
        </button>
    </div>
</div>
@if(count($paciente->grupoFamiliar))
<table class="table table-hover table-bordered table-striped table-condensed">
    <thead>
    <tr>
        <th>Parentestco</th>
        <th>CI</th>
        <th>1er apellido</th>
        <th>2do apellido</th>
        <th>Nombre(s)</th>
        <th>Sexo</th>
        <th>Telf.</th>
        <th>Direccion</th>
        <th>Estado</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($paciente->grupoFamiliar as $persona)
    <tr>
        <td>{{$persona->parentesco->parent_nombre}}</td>
        <td>{{$persona->gru_fam_nro_ci}}</td>
        <td>{{$persona->gru_fam_ap_prim}}</td>
        <td>{{$persona->gru_fam_ap_seg}}</td>
        <td>{{$persona->gru_fam_nombre}}</td>
        <td>{{$persona->gru_fam_sexo}}</td>
        <td>{{$persona->gru_fam_telf}}</td>
        <td>{{$persona->gru_fam_direccion}}</td>
        <td>
            @if($persona->gru_fam_seleccionable)
                <span class="label label-primary">VIGENTE</span>
            @else
                <span class="label label-danger">NO VIGENTE</span>
            @endif
        </td>
        <td>
            <button type="button" class="btn-edit-group btn btn-primary btn-xs" data-url="{{route('adm.paciente.group.update',['pac_id'=>$paciente->pac_id,'group_id'=>$persona->gru_fam_id])}}">
                <i class="fa fa-edit"></i>
            </button>
        </td>
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