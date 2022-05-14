<?php

session_start();
$array = $_SESSION['dataExport'];

header("Content-Disposition: attachment; filename=demo.xls");
header("Content-Type: application/vnd.ms-excel; ");
header("Pragma: no-cache");
header("Expires: 0");
$out = fopen("php://output", 'w');
foreach ($array as $data) {
    fputcsv($out, $data, "\t");
}

unset($_SESSION['dataExport']);
fclose($out);