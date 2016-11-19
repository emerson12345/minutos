
<?php
$institucion = \Sicere\Models\Institucion::find($rep_institucion);
PDF::SetY(28);
PDF::SetFont('Helvetica','',8);
if($institucion->departamento)
    PDF::Cell(40,5,'SEDES '.$institucion->departamento->dep_nombre,0,0,'L',false,null,1);
else
    PDF::Cell(40,5,'SEDES',0,0,'L',false,null,1);
if($institucion->area)
    PDF::Cell(40,5,'RED: '.$institucion->area->area_nombre,0,0,'L',false,null,1);
else
    PDF::Cell(40,5,'RED: NE',0,0,'L',false,null,1);
if($institucion->municipio)
    PDF::Cell(40,5,'MUNICIPIO: '.$institucion->municipio->mun_nombre,0,0,'L',false,null,1);
else
    PDF::Cell(40,5,'MUNICIPIO: NE',0,0,'L',false,null,1);
PDF::Cell(70,5,'ESTABLECIMIENTO: '.$institucion->inst_nombre,0,0,'L',false,null,1);
PDF::Ln();
PDF::SetFont('Helvetica','',11);
PDF::Cell(0,5,'REPORTE DE PRODUCCION',0,1,'C');
PDF::Cell(0,5,$fec_ini.' - '.$fec_fin,0,1,'C');
PDF::SetDrawColor(128, 0, 0);
PDF::SetLineWidth(0.2);
PDF::SetFont('Helvetica','',9);
$x = 92;
$y = 45;
PDF::setXY($x,$y);
$header = ['De 0 a 4 años', 'De 5 a 9 años', 'De 10 a 20 años', 'De 21 a 59 años', '> 60 años'];
foreach ($header as $i=>$h){
    PDF::setXY($x + $i*30,$y); PDF::Cell(30,5,$h,1,0,'C');
    PDF::setXY($x + $i*30,$y+5);
    PDF::Cell(15,5,'NUEVO',1,0,'C',false,null,1);
    PDF::Cell(15,5,'REPETIDO',1,0,'C',false,null,1);
    PDF::setXY($x + $i*30,$y+10);
    PDF::Cell(7.5,5,'M',1,0,'C',false,null,1);
    PDF::Cell(7.5,5,'F',1,0,'C',false,null,1);
    PDF::Cell(7.5,5,'M',1,0,'C',false,null,1);
    PDF::Cell(7.5,5,'F',1,0,'C',false,null,1);
}
PDF::setXY($x+(5*30),$y);
PDF::Cell(15,15,'Total',1,0,'C');
PDF::Cell(15,15,'%',1,0,'C');
PDF::Ln();
PDF::SetFont('helvetica','',9);
PDF::SetFillColor(200);
$subtotales = [];
$totales = array_fill(0,21,0);
if($cuadernos){
    foreach($cuadernos as $cua_id){
        $cuaderno = \Sicere\Models\LibCuaderno::find($cua_id);
        PDF::Cell(67,5,$cuaderno->cua_nombre,'TBL',0,'L',true,null,1);
        $edades = [ [0,4],[5,9],[10,20],[21,59],[60,200] ];
        $total = 0;

        foreach ($edades as $i=>$edad){
            $datos = $cuaderno->report($fec_ini,$fec_fin,$edad[0],$edad[1],$institucion->inst_id);
            $total += $datos->total;
            $totales[($i*4)+0] += $datos->total_nuevo_masc;
            $totales[($i*4)+1] += $datos->total_nuevo - $datos->total_nuevo_masc;
            $totales[($i*4)+2] += $datos->total_repetido_masc;
            $totales[($i*4)+3] += $datos->total_repetido - $datos->total_repetido_masc;
            PDF::Cell(7.5,5,$datos->total_nuevo_masc,'TB',0,'C',false,null,1);
            PDF::Cell(7.5,5,($datos->total_nuevo - $datos->total_nuevo_masc),'TB',0,'C',false,null,1);
            PDF::Cell(7.5,5,$datos->total_repetido_masc,'TB',0,'C',false,null,1);
            PDF::Cell(7.5,5,($datos->total_repetido - $datos->total_repetido_masc),'TB',0,'C',false,null,1);
        }
        $subtotales[]=$total;
        $totales[20]+=$total;
        PDF::Cell(15,5,$total,'TB',0,'C',false,null,1);
        PDF::Ln();
    }
}
$subtotales[] = $totales[20];
PDF::Cell(67,5,'Totales','TBL',0,'R',true,null,1);
for($i = 0;$i<20;$i++)
    PDF::Cell(7.5,5,$totales[$i],'TB',0,'C',true,null,1);
PDF::Cell(15,5,$totales[20],'TB',0,'C',true,null,1);

foreach ($subtotales as $i=>$sub){
    PDF::SetXY($x+165,$y+15+($i*5));
    if($sub == 0 || $totales[20] == 0)
        PDF::Cell(15,5,number_format(0,2).' %','TBR',0,'R',true,null,1);
    else
        PDF::Cell(15,5,number_format(($sub*100)/$totales[20],2).' %','TBR',0,'R',true,null,1);
}