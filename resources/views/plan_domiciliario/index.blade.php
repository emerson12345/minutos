<div class="row">
<div class="col-md-11">
<table style="margin-left: 3%" class="table table-bordered">
    <thead>
        <tr>
            <th style="width:13%">Area de trabajo</th>
            <th  style="width:13%">Que(Objetivo)</th>
            <th style="width:13%">Como</th>
            <th style="width:13%">Quien</th>
            <th style="width:13%">Tiempo</th>
            <th style="width:13%">Logros</th>
            <th style="width:13%"></th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($listPlanDomiciliario as $value):
    ?>
        <tr>
            <td style="width:13%"><?= $value->areas_trabajo; ?></td>
            <td style="width:13%"><?= $value->que; ?></td>
            <td style="width:13%"><?= $value->como; ?></td>
            <td style="width:13%"><?= $value->quien; ?></td>
            <td style="width:13%"><?= $value->tiempo; ?></td>
            <td style="width:13%"><?= $value->logros_fecha; ?>
            </td>
            <td style="width:13%">
                <a style="margin: 5px" id="btn-pdf-plan" class="btn btn-default pull-right" href="{{asset("plan_domiciliario/pdf_plan/$value->id")}}"><i class="fa fa-file-pdf-o"></i>Imprimir</a>
            </td>
        </tr>
        <?php
            endforeach;
        ?>
    </tbody>
    </table>
</div>
</div>