<?php

require('config.php');
$idTransaksi = $_GET['id'];
$produk = @mysqli_query($conn, "SELECT nama_produk,harga_jual,qty_keluar,harga_keluar,tgl_keluar,total_harga,total_bayar,kembalian FROM transaksi_keluar
    INNER JOIN item_keluar ON item_keluar.id_keluar = transaksi_keluar.id_keluar
    INNER JOIN produk ON produk.id_produk = item_keluar.id_produk
    WHERE transaksi_keluar.id_keluar = $idTransaksi
    ");

$produk1 = mysqli_fetch_assoc($produk);

$tglInput = $produk1['tgl_keluar'];
$totalHarga = $produk1['total_harga'];
$totalBayar = $produk1['total_bayar'];
$kembalian = $produk1['kembalian'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Bebas Neue', cursive, Sans-Serif;
            letter-spacing: 2px;
            margin: 0;
            padding: 0;
            color: #444;
        }
        .container {
            width: 35%;
            margin: 40px auto;
        }
        .text-header {
            font-size: 1.5rem;
        }
        .text-date {
            display: block;
            margin-bottom: 4px;
        }
        .text-footer {
            font-size: 1.1rem;
        }
        .print {
            border: none;
            background: red;
            color: white;
            padding: 10px;
        }
        .flex-transaction {
            display: flex;
            width: 100%;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .flex-transaction .left, .flex-transaction .right {
            width: 50%;
            margin-bottom: 7px;
        }
        .flex-transaction .right {
            text-align: right;
        }

        .flex-detail {
            display: flex;
            width: 100%;
        }
        .flex-detail .left {
            width: 60%;
        }
        .flex-detail .right {
            width: 40%;
        }
        .flex-detail .left,.flex-detail .right {
            text-align: right;
        }
@media screen and (min-width: 480px) {
            .container {
                width: 80%;
            }
        }
@media screen and (min-width: 768px) {
            .container {
                width: 35%;
            }
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <center>
            <span class="text-header">
                Koperasi Prestasi KONI Kota salatiga
                <br>
                Jl.Veteran No.45,Salatiga
            </span>
        </center>
        <br><br>
        <span class="text-date">
            Tanggal : <?= date('Y-m-d', strtotime($tglInput)) ?><br>
            Waktu : <?= date('H:i:s', strtotime($tglInput)) ?>
        </span>
        <hr>
        <br>
        <div class="flex-transaction">
            <?php foreach ($produk as $val): ?>
            <div class="left">
                <?=$val['nama_produk'] ?><br> x<?= $val['qty_keluar']."\t" ?><?=rupiah($val['harga_jual']) ?>
            </div>
            <div class="right">
                <br><?= rupiah($val['harga_keluar']) ?>
            </div>
            <?php endforeach; ?>
        </div>
        <br>
        <hr>
        <br>
        <div class="flex-detail">
            <div class="left">
                Total harga :<br>
                Total Bayar :<br>
                Kembalian :<br>
            </div>
            <div class="right">
                <?=rupiah($totalHarga) ?><br>
                <?=rupiah($totalBayar) ?><br>
                <?=rupiah($kembalian) ?>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <span class="text-footer">
            STRUK INI SEBAGAI BUKTI<br>
            PEMBAYARAN YANG SAH<br>
            MOHON DISIMPAN
        </span>
        <div style="text-align: right;">
            <button class="print" id="print" onclick="display()">PRINT</button>
        </div>
        <script>
            function display() {
                const container = document.getElementById("container");
                const element = document.getElementById('print');
                container.style.width = "100%";
                element.remove();
                window.print();
                window.onafterprint = window.close;
            }
        </script>
    </div>
</body>
</html>