<?php

$stok = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT SUM(qty_stok) as jumlah_stok FROM stok_awal"))['jumlah_stok'];

?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Stok Barang</h1>
</div>

<div class="row mt-4 d-flex justify-content-center">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-header bg-success">
                <h5 class="card-title text-white"><i class="fa fa-desktop"></i> Stok Barang</h5>
            </div>
            <div class="card-body">
                <center><h1 class="card-text"><?=$stok ?></h1></center>
            </div>
            <div class="card-footer text-muted">
                <h4 style="font-size:15px;"><a href="<?=baseUrl('?page=list-barang') ?>">Tabel Barang <i class='fa fa-arrow-right'></i></a></h4>
            </div>
        </div>
    </div>
</div>