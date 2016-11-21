<?php
PDF::writeHTML('<br><div align="center" style="font-size: 16px; font-style: italic; font-weight: bold;"><strong>Listado de establecimientos</strong></div>');
PDF::SetFillColor(141, 133, 141);
PDF::SetTextColor(255);
PDF::SetDrawColor(0, 0, 0);
PDF::SetLineWidth(0.1);
PDF::SetFont('', 'B');
// Header
$w = array(18, 53, 18, 40, 32, 32, 32,40);
$header = ['Código','Nombre','Teléfono','Dirección','Departamento','Provincia','Municipio','Área'];
$num_headers = count($header);
for($i = 0; $i < $num_headers; ++$i) {
    PDF::Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
}
PDF::Ln();

//datos
PDF::SetFillColor(224, 235, 255);
PDF::SetTextColor(0);
PDF::SetFont('');
// Data
$fill = 0;
$intNroRow=1;
//for($i=0;$i<10;$i++)
$instituciones=\Sicere\Models\Institucion::get_institucion();
foreach($instituciones as $intitu) {
    PDF::Cell($w[0], 6, $intitu->inst_codigo, 'LR', 0, 'L', $fill,null,1);
    PDF::Cell($w[1], 6, $intitu->inst_nombre, 'LR', 0, 'L', $fill,null,1);
    PDF::Cell($w[2], 6, $intitu->inst_telf1, 'LR', 0, 'L', $fill,null,1);
    PDF::Cell($w[3], 6, $intitu->inst_direccion_calle, 'LR', 0, 'L', $fill,null,1);
    PDF::Cell($w[4], 6, $intitu->dep_nombre, 'LR', 0, 'L', $fill,null,1);
    PDF::Cell($w[5], 6, $intitu->prov_nombre, 'LR', 0, 'L', $fill,null,1);
    PDF::Cell($w[6], 6, $intitu->mun_nombre, 'LR', 0, 'L', $fill,null,1);
    PDF::Cell($w[7], 6, $intitu->area_nombre, 'LR', 0, 'L', $fill,null,1);
    PDF::Ln();
    $fill=!$fill;
}
PDF::Cell(array_sum($w), 0, '', 'T');
