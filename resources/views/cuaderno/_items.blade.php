<?php
    $date= \Carbon\Carbon::createFromFormat('d/m/Y',$fec_ini);
    $date2 = \Carbon\Carbon::createFromFormat('d/m/Y',$fec_fin);
    $index = 0;
?>

@while($date->lte($date2))

    <label for="fecha_{{$index}}" class="btn btn-primary" style="margin-bottom: 3px">
        {{$date->format('d/m/Y')}}
        <input  id="fecha_{{$index}}" class="badgebox" name="fecha[{{$index}}]" type="checkbox" value="{{$date->format('d/m/Y')}}" {{$cuaderno->checkDate($date->format('d/m/Y'))?'checked':''}}>
        <span class="badge">&check;</span>
    </label>
    <br>
    <?php
        $index++;
        $date->addDay();
    ?>
@endwhile
