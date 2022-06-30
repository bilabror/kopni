<?php

isAdmin();

// get data kategori
$kategori = @mysqli_query($conn, "SELECT * FROM kategori_produk");

// get produk
$produks = @mysqli_query($conn, "SELECT * FROM produk");

// get data satuan barang
$satuanBarang = @mysqli_query($conn, "SELECT * FROM satuan_barang");

// get id produk terbaru
$lastId = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT id_produk FROM produk ORDER BY id_produk DESC LIMIT 1 "))['id_produk']+1;

// START proses tambah data
if (isset($_POST['submit'])) {


    $idProduk = $_POST['id_produk'];
    $stokAwal = $_POST['stok_awal'];
    $stokTambahan = $_POST['stok_tambahan'];
    $totalStok = $stokAwal + $stokTambahan;
    $tglInput = $_POST['tgl_input']. " " . date("H:i:s");
    $idStok = $_POST['id_stok'];


    $insertHistory = @mysqli_query($conn, "INSERT INTO riwayat_tambah_stok VALUE('', $idProduk, $stokTambahan, '$tglInput')");
    $updateStok = @mysqli_query($conn, "UPDATE stok_awal SET qty_stok=(qty_stok+$stokTambahan) WHERE id_stok=$idStok");


    if ($updateStok) {
        echo "<script>window.alert('Stok Berhasil Ditambahkan')</script>";
        echo "<script>window.location.href = '".baseUrl("?page=stok-barang")."'</script>";
    } else {
        die;
        echo "<script>window.alert('Stok Gagal Ditambahkan') </script> ";
        echo "<script>window.location.href = '".baseUrl("?page=stok-barang")."'</script> ";
    }
}
// END proses tambah data


?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Stok Barang</h1>
    <a href="<?= baseUrl('?page=stok-barang') ?>" class="btn btn-secondary mb-3">KEMBALI</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Stok Barang
        </div>
        <div class="card-body">
            <form action="" method="post">
                <input type="hidden" name="id_produk">
                <input type="hidden" name="id_stok">
                <div class="mb-3 row">
                    <label for="tgl_input" class="col-sm-3 col-form-label">Tanggal Input</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="tgl_input" name="tgl_input" value="<?=date("Y-m-d") ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_kategori" class="col-sm-3 col-form-label">Produk</label>
                    <div class="col-sm-9">
                        <select name="idproduk" id="idproduk" class="form-select" required onchange="getStok()">
                            <option value="" selected hidden>PILIH PRODUK</option>
                            <?php foreach ($produks as $val): ?>
                            <option value="<?=$val['id_produk'] ?>"><?=$val['nama_produk'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stok_awal" class="col-sm-3 col-form-label">Stok Sekarang</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="stok_awal" name="stok_awal" readonly="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stok_tambahan" class="col-sm-3 col-form-label">Stok Tambahan</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="stok_tambahan" name="stok_tambahan" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <button class="btn btn-primary" name="submit" type="submit"><i class="fa-solid fa-plus"></i> Insert</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>