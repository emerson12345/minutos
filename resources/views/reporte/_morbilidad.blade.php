<?php
function printHeading($title = 'OTROS'){
    PDF::SetFont('','B',9);

    PDF::Cell(39,8,$title,1,0,'C',true,null,1);
    PDF::Cell(10,4,'< 5 años',1,0,'C',true,null,1);
    PDF::Cell(10,4,'5 a 9',1,0,'C',true,null,1);
    PDF::Cell(10,4,'10 a 20',1,0,'C',true,null,1);
    PDF::Cell(10,4,'21 a 59',1,0,'C',true,null,1);
    PDF::Cell(10,4,'60 o mas',1,0,'C',true,null,1);
    PDF::SetXY(PDF::GetX()-50,PDF::GetY()+3.85);
    for($i = 0;$i<5;$i++){
        PDF::Cell(5,4,'H',1,0,'C',true,null,1);
        PDF::Cell(5,4,'M',1,0,'C',true,null,1);
    }
    PDF::Ln();
    PDF::SetFont('','',9);
}
PDF::SetY(50);
PDF::SetLineWidth(0.2);
PDF::SetFillColor(200);


printHeading('1. MEDICINA FISICA');
$data = DB::select("
select lib_registro.red_descripcion,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as H1,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as M1,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as H2,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as M2,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as H3,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as M3,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as H4,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as M4,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as H5,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as M5
from lib_registro
inner join lib_formulario on lib_formulario.for_id = lib_registro.for_id
inner join lib_columnas on lib_columnas.col_id = lib_formulario.col_id
inner join paciente_hc on paciente_hc.hc_id = lib_registro.hc_id
inner join paciente on paciente.pac_id = paciente_hc.pac_id
where
paciente_hc.hc_fecha BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
and lib_formulario.cua_id = 18
and lib_registro.red_descripcion <> ''
and lib_columnas.col_tipo = 3 and paciente_hc.inst_id = {$inst_id}
group by lib_registro.red_descripcion
ORDER BY lib_registro.red_descripcion asc;
");

$index = 1;
foreach ($data as $rowData){
    $first = true;
    foreach ($rowData as $colData){
        if($first){
            PDF::Cell(39,4,"1.{$index} ".$colData,1,0,'L',false,null,1);
        }else{
            PDF::Cell(5,4,$colData!=0?$colData:'',1,0,'C',false,null,1);
        }
        $first = false;
    }
    $index++;
    PDF::Ln();
}
PDF::Ln();

printHeading('2. FISIOTERAPIA');
$data = DB::select("
select lib_registro.red_descripcion,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as H1,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as M1,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as H2,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as M2,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as H3,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as M3,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as H4,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as M4,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as H5,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as M5
from lib_registro
inner join lib_formulario on lib_formulario.for_id = lib_registro.for_id
inner join lib_columnas on lib_columnas.col_id = lib_formulario.col_id
inner join paciente_hc on paciente_hc.hc_id = lib_registro.hc_id
inner join paciente on paciente.pac_id = paciente_hc.pac_id
where
paciente_hc.hc_fecha BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
and lib_formulario.cua_id = 17
and lib_registro.red_descripcion <> ''
and lib_columnas.col_tipo = 16 and paciente_hc.inst_id = {$inst_id}
group by lib_registro.red_descripcion
ORDER BY lib_registro.red_descripcion asc;
");

$index = 1;
foreach ($data as $rowData){
    $first = true;
    foreach ($rowData as $colData){
        if($first){
            PDF::Cell(39,4,"2.{$index} ".$colData,1,0,'L',false,null,1);
        }else{
            PDF::Cell(5,4,$colData!=0?$colData:'',1,0,'C',false,null,1);
        }
        $first = false;
    }
    $index++;
    PDF::Ln();
}
PDF::Ln();

printHeading('3. FONOAUDIOLOGIA');

$lista = "select lis_descripcion from lib_lista_generica where lis_tabla = 'se_diagnostico_fonoaudiologia'";
$data = DB::select("
select lib_registro.red_descripcion,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as H1,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as M1,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as H2,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as M2,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as H3,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as M3,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as H4,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as M4,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as H5,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as M5
from lib_registro
inner join lib_formulario on lib_formulario.for_id = lib_registro.for_id
inner join lib_columnas on lib_columnas.col_id = lib_formulario.col_id
inner join paciente_hc on paciente_hc.hc_id = lib_registro.hc_id
inner join paciente on paciente.pac_id = paciente_hc.pac_id
where
paciente_hc.hc_fecha BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
and lib_formulario.cua_id = 20
and lib_registro.red_descripcion in ({$lista})
and lib_columnas.col_tipo = 15 and paciente_hc.inst_id = {$inst_id}
group by lib_registro.red_descripcion
ORDER BY lib_registro.red_descripcion asc;
");

$index = 1;
foreach ($data as $rowData){
    $first = true;
    foreach ($rowData as $colData){
        if($first){
            PDF::Cell(39,4,"3.{$index} ".$colData,1,0,'L',false,null,1);
        }else{
            PDF::Cell(5,4,$colData!=0?$colData:'',1,0,'C',false,null,1);
        }
        $first = false;
    }
    $index++;
    PDF::Ln();

}
PDF::Ln();

PDF::SetPage(1);
PDF::SetXY(106,50);

printHeading('4. PSICOPEDAGOGIA');
$lista = "(545,546,547,548)";
$data = DB::select("
select lib_columnas.col_combre,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as H1,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as M1,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as H2,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as M2,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as H3,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as M3,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as H4,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as M4,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as H5,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as M5
from lib_registro
inner join lib_formulario on lib_formulario.for_id = lib_registro.for_id
inner join lib_columnas on lib_columnas.col_id = lib_formulario.col_id
inner join paciente_hc on paciente_hc.hc_id = lib_registro.hc_id
inner join paciente on paciente.pac_id = paciente_hc.pac_id
where
paciente_hc.hc_fecha BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
and lib_formulario.cua_id = 21
and lib_registro.red_descripcion = '1'
and lib_columnas.col_id in {$lista} and paciente_hc.inst_id = {$inst_id}
group by lib_columnas.col_combre
ORDER BY lib_columnas.col_combre asc;
");

$index = 1;
foreach ($data as $rowData){
    $first = true;
    PDF::SetX(106);
    foreach ($rowData as $colData){
        if($first){
            PDF::Cell(39,4,"4.{$index} ".$colData,1,0,'L',false,null,1);
        }else{
            PDF::Cell(5,4,$colData!=0?$colData:'',1,0,'C',false,null,1);
        }
        $first = false;
    }
    $index++;
    PDF::Ln();

}
PDF::Ln();

PDF::SetX(106);
printHeading('5. TERAPIA OCUPACIONAL');
$lista = "select lis_descripcion from lib_lista_generica where lis_tabla = 'se_diagnostico_te_ocupa'";
$data = DB::select("
select lib_registro.red_descripcion,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as H1,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as M1,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as H2,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as M2,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as H3,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as M3,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as H4,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as M4,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as H5,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as M5
from lib_registro
inner join lib_formulario on lib_formulario.for_id = lib_registro.for_id
inner join lib_columnas on lib_columnas.col_id = lib_formulario.col_id
inner join paciente_hc on paciente_hc.hc_id = lib_registro.hc_id
inner join paciente on paciente.pac_id = paciente_hc.pac_id
where
paciente_hc.hc_fecha BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
and lib_formulario.cua_id = 24
and lib_registro.red_descripcion in ({$lista})
and lib_columnas.col_tipo = 15 and paciente_hc.inst_id = {$inst_id}
group by lib_registro.red_descripcion
ORDER BY lib_registro.red_descripcion asc;
");

$index = 1;
foreach ($data as $rowData){
    $first = true;
    PDF::SetX(106);
    foreach ($rowData as $colData){
        if($first){
            PDF::Cell(39,4,"5.{$index} ".$colData,1,0,'L',false,null,1);
        }else{
            PDF::Cell(5,4,$colData!=0?$colData:'',1,0,'C',false,null,1);
        }
        $first = false;
    }
    $index++;
    PDF::Ln();

}
PDF::Ln();

PDF::SetX(106);
printHeading('6. CONSULTA PSICOLOGIA');
$lista = "select lis_descripcion from lib_lista_generica where lis_tabla = 'se_diagnostico_psicologico'";
$data = DB::select("
select lib_registro.red_descripcion,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as H1,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad<5 then 1 else 0 end),0 ) as M1,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as H2,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 5 and 9 then 1 else 0 end),0 ) as M2,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as H3,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 10 and 20 then 1 else 0 end),0 ) as M3,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as H4,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 21 and 59 then 1 else 0 end),0 ) as M4,
COALESCE(sum(case when paciente.pac_sexo = 'H' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as H5,
COALESCE(sum(case when paciente.pac_sexo = 'M' and paciente_hc.pac_edad between 60 and 200 then 1 else 0 end),0 ) as M5
from lib_registro
inner join lib_formulario on lib_formulario.for_id = lib_registro.for_id
inner join lib_columnas on lib_columnas.col_id = lib_formulario.col_id
inner join paciente_hc on paciente_hc.hc_id = lib_registro.hc_id
inner join paciente on paciente.pac_id = paciente_hc.pac_id
where
paciente_hc.hc_fecha BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
and lib_formulario.cua_id = 22
and lib_registro.red_descripcion in ({$lista})
and lib_columnas.col_tipo = 15 and paciente_hc.inst_id = {$inst_id}
group by lib_registro.red_descripcion
ORDER BY lib_registro.red_descripcion asc;
");

$index = 1;
foreach ($data as $rowData){
    $first = true;
    PDF::SetX(106);
    foreach ($rowData as $colData){
        if($first){
            PDF::Cell(39,4,"6.{$index} ".$colData,1,0,'L',false,null,1);
        }else{
            PDF::Cell(5,4,$colData!=0?$colData:'',1,0,'C',false,null,1);
        }
        $first = false;
    }
    $index++;
    PDF::Ln();

}
PDF::Ln();