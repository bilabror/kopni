<?php

// DEKLARASI VARIABLES
$idKategori = null;
$namaKategori = '';
$prefixPage = 'kategori-barang';
$kategori = @mysqli_query($conn, "SELECT * FROM kategori_produk");


// START proses menambahkan data
if (isset($_POST['insert'])) {

    // memasukan data ke variable sebelum di insert ke database
    $namaKategori = $_POST['nama_kategori'];
    $tglInput = date('Y-m-d');

    // query insert data
    $sql = @mysqli_query($conn, "INSERT INTO kategori_produk VALUE('','$namaKategori','$tglInput')");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Ditambahkan')</script>";
        echo "<script>window.location.href='".baseUrl("?page={$prefixPage}")."'</script>";
    }
}
// END proses menambahkan data


// START sebelum edit data
if (!empty($_GET['edit'])) {
    $idKategori = $_GET['edit'];
    $getKategoriById = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT * FROM kategori_produk WHERE id_kategori=$idKategori"));
    $idKategori = $getKategoriById['id_kategori'];
    $namaKategori = $getKategoriById['nama_kategori'];
}
// END sebelum edit data


// START proses edit data
if (isset($_POST['edit'])) {

    // memasukan data ke variable sebelum di update ke database
    $idKategori = $_POST['id_kategori'];
    $namaKategori = $_POST['nama_kategori'];

    // query update data
    $sql = @mysqli_query($conn, "UPDATE kategori_produk SET nama_kategori='$namaKategori' WHERE id_kategori=$idKategori");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Diedit')</script>";
        echo "<script>window.location.href='".baseUrl("?page={$prefixPage}")."'</script>";
    }
}
// END proses edit data


// START proses hapus data
if (!empty($_GET['delete'])) {
    $idKategori = $_GET['delete'];

    // query hapus data
    $sql = @mysqli_query($conn, "DELETE FROM kategori_produk WHERE id_kategori=$idKategori");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Dihapus')</script>";
        echo "<script>window.location.href='".baseUrl("?page={$prefixPage}")."'</script>";
    }
}
// END proses hapus data


?>
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Kategori Barang</h1>
    <form action="" class="row mb-4" method="post">
        <?php if (!empty($_GET['edit'])): ?>
        <input type="hidden" name="id_kategori" value="<?=$idKategori ?>">
        <div class="col-4">
            <input type="text" class="form-control" name="nama_kategori" value="<?=$namaKategori ?>" required>
        </div>
        <div class="col">
            <button class="btn btn-success" name="edit">UPDATE</button> <a href="<?=baseUrl("?page={$prefixPage}") ?>" class="btn btn-secondary">KEMBALI</a>
        </div>
        <?php else : ?>
        <div class="col-4">
            <input type="text" class="form-control" name="nama_kategori" required>
        </div>
        <div class="col">
            <button class="btn btn-success" name="insert"><i class="fa-solid fa-plus"></i> Insert</button>
        </div>
        <?php endif; ?>
    </form>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabel Kategori Barang
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="50%">Kategori</th>
                        <th>Tanggal Input</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kategori as $key => $val): ?>
                    <tr>
                        <td><?=$key+1 ?></td>
                        <td><?=$val['nama_kategori'] ?></td>
                        <td><?=$val['tgl_input'] ?></td>
                        <td>
                            <a href="<?=baseUrl("?page={$prefixPage}&edit={$val['id_kategori']}") ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <a href="<?=baseUrl("?page={$prefixPage}&delete={$val['id_kategori']}") ?>" onclick="javascript:return confirm('Apakah anda yakin akan menghapusnya?');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>