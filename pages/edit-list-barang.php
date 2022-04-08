<?php

// get id produk dari parameter edit
$idProduk = $_GET['edit'];

// get data kategori
$kategori = @mysqli_query($conn, "SELECT * FROM kategori_produk");

// get data produk
$produk = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT produk.*,stok_awal.qty_stok,kategori_produk.nama_kategori FROM produk INNER JOIN stok_awal ON stok_awal.id_stok = produk.id_stok INNER JOIN kategori_produk ON kategori_produk.id_kategori = produk.id_kategori WHERE id_produk=$idProduk"));


// START proses edit data
if (isset($_POST['submit'])) {

    // memasukan data ke variable sebelum di update ke database
    $idProduk = $_POST['id_produk'];
    $idKategori = $_POST['id_kategori'];
    $stok = $_POST['stok'];
    $namaProduk = $_POST['nama_produk'];
    $hargaJual = $_POST['harga_jual'];
    $satuan = $_POST['satuan'];
    $tglUpdateStok = date('Y-m-d');
    $idStok = $produk['id_stok'];

    // query update data
    $sql = @mysqli_query($conn, "UPDATE stok_awal SET tgl_stok=$tglUpdateStok,qty_stok=$stok WHERE id_stok=$idStok");
    $sql = @mysqli_query($conn, "UPDATE produk SET id_kategori=$idKategori,nama_produk='$namaProduk',harga_jual=$hargaJual,satuan='$satuan' WHERE id_produk=$idProduk");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Diedit')</script>";
        echo "<script>window.location.href='".baseUrl("?page=list-barang")."'</script>";
    }
}
// END proses edit data


?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit List Barang</h1>
    <a href="<?=baseUrl('?page=list-barang') ?>" class="btn btn-secondary mb-3">KEMBALI</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Edit List Barang
        </div>
        <div class="card-body">
            <form action="" method="post">
                <input type="hidden" name="id_produk" value="<?=$produk['id_produk'] ?>">
                <div class="mb-3 row">
                    <label for="id_produk_custom" class="col-sm-2 col-form-label">ID Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id_produk_custom" value="<?=idBarangCustom($produk['id_produk']) ?>" readonly="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="id_kategori" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <select name="id_kategori" id="id_kategori" class="form-select" required>
                            <option value="" hidden selected>PILIH KATEGORI</option>
                            <?php foreach ($kategori as $val): ?>
                            <option value="<?=$val['id_kategori'] ?>" <?=$produk['id_kategori'] == $val['id_kategori'] ? 'selected' : '' ?>><?=$val['nama_kategori'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama_produk" class="col-sm-2 col-form-label">Nama Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?=$produk['nama_produk'] ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga_jual" class="col-sm-2 col-form-label">Harga Barang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="<?=$produk['harga_jual'] ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="satuan" class="col-sm-2 col-form-label">Satuan Barang</label>
                    <div class="col-sm-10">
                        <select name="satuan" class="form-select" id="satuan" required>
                            <option value="">PILIH SATUAN PRODUK</option>
                            <option value="pcs" <?=$produk['satuan'] == 'pcs' ? 'selected' : '' ?>>PCS</option>
                            <option value="grosir" <?=$produk['satuan'] == 'grosir' ? 'selected' : '' ?>>GROSIR</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="stok" name="stok" required value="<?=$produk['qty_stok'] ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tgl_input" class="col-sm-2 col-form-label">Tanggal Input</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tgl_input" name="tgl_input" value="<?=$produk['tgl_input'] ?>" required readonly="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <button class="btn btn-primary" name="submit" type="submit"><i class="fa-solid fa-floppy-disk"></i> Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>