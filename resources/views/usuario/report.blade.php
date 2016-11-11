<?php
    PDF::writeHTML('La lista de usuarios');
    PDF::SetFillColor(255, 0, 0);
    PDF::SetTextColor(255);
    PDF::SetDrawColor(128, 0, 0);
    PDF::SetLineWidth(0.3);
    PDF::SetFont('', 'B');
    // Header
    $w = array(32, 25, 39, 32, 32);
    $header = ['Nombre','Usuario','Email','Fecha alta','Fecha mod.'];
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
    for($i=0;$i<10;$i++)
        foreach(\Sicere\User::all() as $user) {
            PDF::Cell($w[0], 6, $user->user_nombre, 'LR', 0, 'L', $fill,null,1);
            PDF::Cell($w[1], 6, $user->user_codigo, 'LR', 0, 'L', $fill,null,1);
            PDF::Cell($w[2], 6, $user->user_email, 'LR', 0, 'R', $fill,null,1);
            PDF::Cell($w[3], 6, $user->user_fec_alta->format('d/m/Y H:i'), 'LR', 0, 'R', $fill,null,1);
            PDF::Cell($w[4], 6, $user->user_fec_mod->format('d/m/Y H:i'), 'LR', 0, 'R', $fill,null,1);
            PDF::Ln();
            $fill=!$fill;
        }
    PDF::Cell(array_sum($w), 0, '', 'T');
