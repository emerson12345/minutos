@if($eventos->count())
<table class="table table-bordered table-hover table-striped">
    <thead>
    <tr>
        <th width="15%">Fecha y hora</th>
        <th width="30%">Paciente</th>
        <th width="35%">Descripcion</th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($eventos as $evento)
    <tr>
        <td>{{date('d/m/Y H:i',strtotime($evento->agenda_fec_ini))}}</td>
        <td>{{$evento->paciente->nombreCompleto}}</td>
        <td>{{$evento->agenda_descripcion}}</td>
        <td>
            @if($evento->agenda_estado == 'A')
                <button data-id="{{$evento->agenda_id}}" data-state='T' data-url='{{route('agenda.change')}}' type="button" class="btn btn-change-state btn-xs btn-primary" title="Atendido"><i class="fa fa-check"></i></button>
                <button data-id="{{$evento->agenda_id}}" data-state='N' data-url='{{route('agenda.change')}}' type="button" class="btn btn-change-state btn-xs btn-danger" title="No atendido"><i class="fa fa-close"></i></button>
                <button data-id="{{$evento->agenda_id}}" data-state='C' data-url='{{route('agenda.change')}}' type="button" class="btn btn-change-state btn-xs btn-warning" title="Cancelado"><i class="fa fa-ban"></i></button>
            @else
                <?php switch ($evento->agenda_estado){
                    case 'T': echo '<span class="badge bg-blue">Atendido</span>';break;
                    case 'N': echo '<span class="badge bg-red">No atendido</span>';break;
                    case 'C': echo '<span class="badge bg-yellow">Cancelado</span>';break;
                }
                ?>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
    <div class="alert alert-info">
        <strong>Atencion!!!</strong>
        <p>
            No tiene ninguna cita para las fechas seleccionadas.
        </p>
    </div>
@endif