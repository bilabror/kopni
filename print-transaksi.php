<?php

require('config.php');
$idTransaksi = $_GET['id'];
$produk = @mysqli_query($conn, "SELECT nama_produk,qty_keluar,harga_keluar,tgl_keluar,total_harga,total_bayar,kembalian FROM transaksi_keluar
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
    <style>
        * {
            font-family: arial,Sans-Serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 40px auto;
        }
        header {
            text-align: right;
        }
        .table-item {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 50px;
        }

        .table-item td, .table-item th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table-item tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-item tr:hover {
            background-color: #ddd;
        }

        .table-item th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }

        .table-bayar td {
            padding: 8px;
        }
        .print {
            border: none;
            background: red;
            color: white;
            padding: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Koperasi KONI</h1>
            <p>
                <?=$tglInput ?>
            </p>
        </header>
        <table class="table-item">
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
            <?php foreach ($produk as $key => $val): ?>
            <tr>
                <td><?=$val['nama_produk'] ?></td>
                <td><?=$val['qty_keluar'] ?></td>
                <td><?=$val['harga_keluar'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <table class="table-bayar" style="margin-top:30px">
            <tr>
                <td>Total Harga</td>
                <td>:</td>
                <td><?=rupiah($totalHarga) ?></td>
            </tr>
            <tr>
                <td>Total Bayar</td>
                <td>:</td>
                <td><?=rupiah($totalBayar) ?></td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td>:</td>
                <td><?=rupiah($kembalian) ?></td>
            </tr>
        </table>
        <div style="text-align: right;">
            <button class="print" id="print" onclick="display()">PRINT</button>
        </div>
        <script>
            function display() {
                const element = document.getElementById('print');
                element.remove(); // Removes the div with the 'div-02' id
                window.print();
            }
        </script>
    </div>
</body>
</html>