<?php


require('config.php');
$awal = "";
$akhir = "";

if (empty($_GET['awal']) || empty($_GET['akhir'])) {
    $url = baseUrl('?page=laporan-penjualan');
    //header("location: {$url}");
    //exit();
}


$select = "produk.nama_produk,produk.id_produk,kategori_produk.nama_kategori,qty_keluar,harga_keluar,tgl_keluar";
$where = '';
if (!empty($_GET['awal']) && !empty($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $where = "WHERE DATE(tgl_keluar) >= '$awal' AND DATE(tgl_keluar) <= '$akhir'";
}
if ($awal == $akhir && $awal != "" && $akhir != "") $periode = tgl_indo(date('Y-m-d', strtotime($awal)));
elseif ($awal == "" && $akhir == "") $periode = "semua periode";
else
    $periode = tgl_indo(date('Y-m-d', strtotime($awal))) ." - ". tgl_indo(date('Y-m-d', strtotime($akhir)));

$produk = @mysqli_query($conn, "SELECT $select FROM transaksi_keluar
    INNER JOIN item_keluar ON item_keluar.id_keluar = transaksi_keluar.id_keluar
    INNER JOIN produk ON produk.id_produk = item_keluar.id_produk
    INNER JOIN kategori_produk ON kategori_produk.id_kategori = produk.id_kategori
    $where
    ORDER BY tgl_keluar desc
    ");

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <style>
        img.kiri {
            float: left;
            margin-right: 20px;
            width: 85px;
        }

        p.ex1 {
            margin-bottom: 75px;
        }

        h4.a,h2.a,h5.a {
            font-family: Tahoma, sans-serif;
            font-weight: bold;
            text-align: center;
            margin: 0;
            padding: 0;
        }


        table.table-pinjam > tbody > tr > td {
            padding: 0 !important;
            margin: 0 !important;
        }

    </style>

    <title></title>
</head>

<body>
    <div class="container">
        <div class="row pt-4">
            <div class="col-md-1">
                <img src="<?=baseUrl('assets/img/logokoni.jpeg') ?>" class="kiri" alt="">
            </div>
            <div class="col-md-11">
                <h2 class="a">LAPORAN PENJUALAN</h2>
                <h4 class="a">KOPERASI PRESTASI KONI SALATIGA</h4>
                <h5 class="a"><?= $periode ?></h5>
            </div>
        </div>
        <hr style="border: 1px solid black;">

        <div class="row pt-3">
            <div class="col">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal Input</th>
                            <th scope="col">Nama Barang</th>
                            <th scope="col">Jumlah Barang</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; foreach ($produk as $val):
                        $total += $val['harga_keluar'];
                        ?>
                        <tr>
                            <td><?=$val['tgl_keluar'] ?></td>
                            <td><?=$val['nama_produk'] ?></td>
                            <td><?=$val['qty_keluar'] ?></td>
                            <td><?=rupiah($val['harga_keluar']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><b>Jumlah</b></td>
                            <td><?=rupiah($total) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-md-6">
                <p class="text-white">
                    .
                </p>
                <p class="ex1">
                    Penanggung jawab Koperasi
                </p>
                <div class="d-inline-block" style="width:200px;border-bottom:1px solid black;"></div>
            </br>
            <b>Manager Koperasi</b></br>
    </div>
    <div class="col-md-6 text-right">
        <p>
            Salatiga, <?= tgl_indo(date('Y-m-d')) ?>
        </p>
        <p class="ex1">
            Mengetahui
        </p>
        <div class="d-inline-block" style="width:200px;border-bottom:1px solid black;"></div>
    </br>
    <b>Ketua Koni Kota Salatiga</b></br>
</div>
</div>



</div>

<script>
window.print();
//window.onafterprint = window.close;
</script>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>