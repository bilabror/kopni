<?php

session_start();
date_default_timezone_set('Asia/Jakarta');
$conn = @mysqli_connect('localhost', 'root', '', 'tokoku');


/*------------------ FUNCTIONS ----------------------*/

function baseUrl($params = '') {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);

    $uri_parts = explode('/', $uri_parts[0]);
    return $protocol . $_SERVER['HTTP_HOST'] . '/' . $uri_parts[1] . '/' . $params;
}

function idBarangCustom($id) {
    return "BRG".sprintf("%'.04d", $id);
}

function rupiah($number = 0) {
    return "Rp." . number_format($number, 0, '', '.');
}

function rupiahToNumber($str) {
    return (int)str_replace('Rp', '', str_replace('.', '', $str));
}


function tgl_indo($tanggal) {
    $bulan = array (
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}