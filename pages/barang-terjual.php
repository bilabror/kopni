<?php

$item_keluar = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT SUM(qty_keluar) as qty_keluar FROM item_keluar"))['qty_keluar'];

?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Barang Terjual</h1>
</div>

<div class="row mt-4 d-flex justify-content-center">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-header bg-success">
                <h5 class="card-title text-white"><i class="fa fa-desktop"></i> Barang Terjual</h5>
            </div>
            <div class="card-body">
                <center><h1 class="card-text"><?=$item_keluar ?></h1></center>
            </div>
            <div class="card-footer text-muted">
                <h4 style="font-size:15px;"><a href="<?=baseUrl('?page=laporan-penjualan') ?>">Tabel Laporan <i class='fa fa-arrow-right'></i></a></h4>
            </div>
        </div>
    </div>
</div>