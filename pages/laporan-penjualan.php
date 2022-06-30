<?php

$prefixPage = 'list-barang';

$select = "produk.nama_produk,produk.id_produk,kategori_produk.nama_kategori,qty_keluar,harga_keluar,tgl_keluar";
$where = '';

$urlPrint = 'print-laporan.php';


if (!empty($_GET['awal']) && !empty($_GET['akhir'])) {
    $awal = $_GET['awal'];
    $akhir = $_GET['akhir'];
    $where = "WHERE DATE(tgl_keluar) >= '$awal' AND DATE(tgl_keluar) <= '$akhir'";
    $urlPrint = "print-laporan.php/?awal={$awal}&akhir={$akhir}";
}

$produk = @mysqli_query($conn, "SELECT $select FROM transaksi_keluar
    INNER JOIN item_keluar ON item_keluar.id_keluar = transaksi_keluar.id_keluar
    INNER JOIN produk ON produk.id_produk = item_keluar.id_produk
    INNER JOIN kategori_produk ON kategori_produk.id_kategori = produk.id_kategori
    $where
    ORDER BY tgl_keluar desc
    ");


// proses hapus data
if (!empty($_GET['delete'])) {
    $idProduk = $_GET['delete'];
    $idStok = mysqli_fetch_assoc(@mysqli_query($conn, "SELECT id_stok FROM produk WHERE id_produk=$idProduk"))['id_stok'];

    // query hapus data
    $sql = @mysqli_query($conn, "DELETE FROM stok_awal WHERE id_stok=$idStok");
    $sql = @mysqli_query($conn, "DELETE FROM produk WHERE id_produk=$idProduk");

    // jika query berhasil
    if ($sql) {
        echo "<script>
    window.alert('Data Berhasil Dihapus')
</script>
        ";
        echo "<script>
    window.location.href = '".baseUrl("?page={$prefixPage}")."'
</script>
        ";
    }
}

?>



<div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Laporan Penjualan</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Laporan Penjualan
        </div>
        <div class="card-body">
            <div class="d-flex flex-row-reverse">
                <form action="" method="post" class="d-block mx-2">
                    <input type="hidden" name="page" value="laporan-penjualan">
                    <button class="btn btn-success" name="export"><i class="fa fa-file-excel"></i> EXPORT</button>
                </form>
                <a href="<?=$urlPrint ?>" class="d-block btn btn-danger"><i class="fa fa-print"></i> Print</a>
            </div>

            <div class="row">
                <div class="col">
                    <label for="awal" class="form-label">Dari Tanggal</label>
                </div>
                <div class="col">
                    <label for="akhir" class="form-label">Sampai Tanggal</label>
                </div>
                <div class="col">
                </div>
            </div>
            <form class="row">
                <input type="hidden" name="page" value="laporan-penjualan">
                <div class="mb-3 col">
                    <input type="date" class="form-control" name="awal" id="awal" required value="<?=$awal ?>">
                </div>
                <div class="mb-3 col">
                    <input type="date" class="form-control" name="akhir" id="akhir" required value="<?=$akhir ?>">
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                    <a class="btn btn-secondary" href="<?=baseUrl('?page=laporan-penjualan') ?>"><i class="fa fa-refresh"></i></a>
                </div>
            </form>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Barang</th>
                        <th>Kategori</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Tanggal Input</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produk as $key => $val): ?>
                    <tr>
                        <td><?=$key+1 ?></td>
                        <td><?=idBarangCustom($val['id_produk']) ?></td>
                        <td><?=$val['nama_kategori'] ?></td>
                        <td><?=$val['nama_produk'] ?></td>
                        <td><?=$val['qty_keluar'] ?></td>
                        <td><?=rupiah($val['harga_keluar']) ?></td>
                        <td><?=$val['tgl_keluar'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php


if (isset($_POST['export'])) {
    $dataExport = [];
    $dataExport[] = [
        0 => 'No',
        1 => 'Id Barang',
        2 => 'Tanggal Input',
        3 => 'Kategori',
        4 => 'Nama Barang',
        5 => 'Jumlah',
        6 => 'Total'
    ];
    $total = 0;
    foreach ($produk as $key => $val) {
        $dataExport[] = [
            0 => $key+1,
            1 => idBarangCustom($val['id_produk']),
            2 => date('j F Y, H:i', strtotime($val['tgl_keluar'])),
            3 => $val['nama_kategori'],
            4 => $val['nama_produk'],
            5 => $val['qty_keluar'],
            6 => rupiah($val['harga_keluar'])
        ];
        $total += $val['harga_keluar'];
    }

    $dataExport[] = [
        0 => '',
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => 'Total',
        6 => rupiah($total)
    ];

    $_SESSION ['dataExport'] = $dataExport;

    echo "<script>window.location = 'export-excel.php';</script>";

}


?>