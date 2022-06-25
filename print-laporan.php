<?php

require('config.php');

$select = "produk.nama_produk,produk.id_produk,kategori_produk.nama_kategori,qty_keluar,harga_keluar,tgl_keluar";
$where = '';
if (!empty($_GET['awal']) && !empty($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $where = "WHERE DATE(tgl_keluar) >= '$awal' AND DATE(tgl_keluar) <= '$akhir'";
}

$produk = @mysqli_query($conn, "SELECT $select FROM transaksi_keluar
    INNER JOIN item_keluar ON item_keluar.id_keluar = transaksi_keluar.id_keluar
    INNER JOIN produk ON produk.id_produk = item_keluar.id_produk
    INNER JOIN kategori_produk ON kategori_produk.id_kategori = produk.id_kategori
    $where
    ORDER BY tgl_keluar desc
    ");

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
            width: 90%;
            margin: 40px auto;
        }
        .text-header {
            font-size: 1.5rem;
            font-weight: bold;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table th, table td {
            padding: 5px;
        }
        .print {
            border: none;
            background: red;
            color: white;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <center>
            <span class="text-header">
                Laporan Penjualan
                <br>
                Koperasi Pretasi Koni Salatiga
                <br>
                <?=date("d/m/Y") ?>
            </span>
        </center>
        <br>

        <table>
            <tr>
                <th style="text-align:left">Tanggal Input</th>
                <th style="text-align:left">Nama Barang</th>
                <th style="text-align:left">Jumlah Barang</th>
                <th style="text-align:left">Total</th>
            </tr>
            <?php foreach ($produk as $val): ?>
            <tr>
                <td><?=$val['tgl_keluar'] ?></td>
                <td><?=$val['nama_produk'] ?></td>
                <td><?=$val['qty_keluar'] ?></td>
                <td><?=rupiah($val['harga_keluar']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <div style="text-align: right;">
            <button class="print" id="print" onclick="display()">PRINT</button>
        </div>
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
</body>
</html>