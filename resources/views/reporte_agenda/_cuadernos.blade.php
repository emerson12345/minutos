@if($cuadernos->count())
    <div class="btn-group">
        <button type="button" id="btn-check" class="btn btn-default btn-xs"><i class="fa fa-check-square-o"></i> Todos</button>
        <button type="button" id="btn-uncheck" class="btn btn-default btn-xs"><i class="fa fa-square-o"></i> Ninguno</button>
    </div>
    <br>
    @foreach($cuadernos as $cuaderno)
        <input type="checkbox" name="cuaderno[{{$cuaderno->cua_id}}]" value="{{$cuaderno->cua_id}}" id="cuaderno_{{$cuaderno->cua_id}}" class="cua_check">
        <label for="cuaderno_{{$cuaderno->cua_id}}">{{$cuaderno->cua_nombre}}</label><br>
    @endforeach
@else
    <div class="alert alert-info">
        <strong>Atención!!!. </strong>
        <p>
            Este usuario no tiene ningún cuaderno asociado.
        </p>
    </div>
@endif