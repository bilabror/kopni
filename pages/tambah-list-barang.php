<?php

isAdmin();

// get data kategori
$kategori = @mysqli_query($conn, "SELECT * FROM kategori_produk");

// get data satuan barang
$satuanBarang = @mysqli_query($conn, "SELECT * FROM satuan_barang");

// get id produk terbaru
$lastId = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT id_produk FROM produk ORDER BY id_produk DESC LIMIT 1 "))['id_produk']+1;

// START proses tambah data
if (isset($_POST['submit'])) {

    $idProduk = $_POST['id_produk'];
    $idKategori = $_POST['id_kategori'];
    $stok = $_POST['stok'];
    $namaProduk = $_POST['nama_produk'];
    $hargaJual = $_POST['harga_jual'];
    $satuan = $_POST['satuan'];
    $tglInput = $_POST['tgl_input'];

    // insert ke tabel stok_awal
    $insertStok = @mysqli_query($conn, "INSERT INTO stok_awal VALUE('','$tglInput',$stok)");
    $idStok = @mysqli_insert_id($conn);

    // insert ke tabel produk
    $insertProduk = @mysqli_query($conn, "INSERT INTO produk VALUE('$idProduk',$idKategori,$idStok,'$namaProduk','$satuan',$hargaJual,'$tglInput')");

    if ($insertProduk) {
        echo "<script>window.alert('Data Berhasil Ditambahkan')</script>";
        echo "<script>window.location.href='".baseUrl("?page=list-barang")."'</script>";
    } else {
        echo "<script>window.alert('Data Gagal Ditambahkan')</script>";
        echo "<script>window.location.href='".baseUrl("?page=list-barang")."'</script>";
    }
}
// END proses tambah data


?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah List Barang</h1>
    <a href="<?=baseUrl('?page=list-barang') ?>" class="btn btn-secondary mb-3">KEMBALI</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah List Barang
        </div>
        <div class="card-body">
            <form action="" method="post">
                <input type="hidden" name="id_produk" value="<?=$lastId ?>">
                <div class="mb-3 row">
                    <label for="id_produk_custom" class="col-sm-2 col-form-label">ID Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id_produk_custom" value="<?=idBarangCustom($lastId) ?>" readonly="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_kategori" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <select name="id_kategori" id="id_kategori" class="form-select" required>
                            <option value="" hidden selected>PILIH KATEGORI</option>
                            <?php foreach ($kategori as $val): ?>
                            <option value="<?=$val['id_kategori'] ?>"><?=$val['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama_produk" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_jual" class="col-sm-2 col-form-label">Harga Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="satuan" class="col-sm-2 col-form-label">Satuan Barang</label>
                    <div class="col-sm-10">
                        <select name="satuan" class="form-select" id="satuan" required>
                            <option value="">PILIH SATUAN PRODUK</option>
                            <?php foreach ($satuanBarang as $val): ?>
                            <option value="<?=$val['satuan'] ?>"><?=strtoupper($val['satuan']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stok" name="stok" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tgl_input" class="col-sm-2 col-form-label">Tanggal Input</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tgl_input" name="tgl_input" required>
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