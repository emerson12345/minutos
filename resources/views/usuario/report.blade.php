<?php
PDF::writeHTML('<br><div align="center" style="font-family: Calibri; font-size: 11px; font-weight: bold;"><strong>USUARIOS REGISTRADOS EN EL SISTEMA</strong></div>');
//PDF::Text(43,22,'Lista de usuarios');
PDF::SetFillColor(217, 217, 217);
PDF::SetTextColor(0);
PDF::SetDrawColor(0, 0, 0);
PDF::SetLineWidth(0.1);
PDF::SetFont('', 'B');
// Header
$w = array(32, 32, 39,32, 32, 15);
$header = ['Nombre de usuario','Nombre','Email','Fecha de alta','Fecha de ult. modf.','Vigente'];
$num_headers = count($header);
for($i = 0; $i < $num_headers; ++$i) {
    PDF::Cell($w[$i], 7, $header[$i], 0, 0, 'C', 1);
}
PDF::Ln();

//datos
PDF::SetFillColor(242, 242, 242);
PDF::SetTextColor(0);
PDF::SetFont('');
// Data
$fill = 0;
//for($i=0;$i<10;$i++)
foreach(\Sicere\User::all() as $user) {
    PDF::Cell($w[0], 6, $user->user_codigo, 'R', 0, 'L', $fill,null,0);
    PDF::Cell($w[1], 6, $user->user_nombre, 'RL', 0, 'L', $fill,null,1);
    PDF::Cell($w[2], 6, $user->user_email, 'RL', 0, 'L', $fill,null,0);
    PDF::Cell($w[3], 6, $user->user_fec_alta->format('d/m/Y H:i'), 'RL', 0, 'L', $fill,null,1);
    PDF::Cell($w[4], 6, $user->user_fec_mod->format('d/m/Y H:i'), 'RL', 0, 'L', $fill,null,1);
    if($user->user_seleccionable==1)$blnVigente='SI';
    else $blnVigente='NO';
    PDF::Cell($w[5], 6, $blnVigente, 'L', 0, 'C', $fill,null,1);
    PDF::Ln();
    $fill=!$fill;
}
PDF::Cell(array_sum($w), 0, '', 'T');
