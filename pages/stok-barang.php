<?php

$stok = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT SUM(qty_stok) as jumlah_stok FROM stok_awal"))['jumlah_stok'];

?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Stok Barang</h1>
</div>



<div class="mt-4 d-flex justify-content-center">
    <div class="card text-center" style="width: 27rem;height:270px">
        <div class="card-header bg-success">
            <h4 class="card-title text-white"><i class="fa fa-desktop"></i> Stok Barang</h4>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
            <h1 style="font-size:5em"><?=$stok ?></h1>
        </div>
        <div class="card-footer text-muted">
            <h4 style="font-size:15px;"><a href="<?=baseUrl('?page=list-barang') ?>">Tabel Barang <i class='fa fa-arrow-right'></i></a></h4>
        </div>
    </div>
</div>