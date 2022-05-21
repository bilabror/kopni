<?php

isAdmin();


// DEKLARASI VARIABLES
$idSatuanBarang = null;
$namaSatuanBarang = '';
$prefixPage = 'satuan-barang';
$satuanBarang = @mysqli_query($conn, "SELECT * FROM satuan_barang");


// START proses menambahkan data
if (isset($_POST['insert'])) {

    // memasukan data ke variable sebelum di insert ke database
    $namaSatuanBarang = $_POST['satuan'];

    // query insert data
    $sql = @mysqli_query($conn, "INSERT INTO satuan_barang VALUE('','$namaSatuanBarang')");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Ditambahkan')</script>";
        echo "<script>window.location.href='".baseUrl("?page={$prefixPage}")."'</script>";
    }
}
// END proses menambahkan data


// START sebelum edit data
if (!empty($_GET['edit'])) {
    $idSatuanBarang = $_GET['edit'];
    $getDataById = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT * FROM satuan_barang WHERE id=$idSatuanBarang"));
    $idSatuanBarang = $getDataById['id'];
    $namaSatuanBarang = $getDataById['satuan'];
}
// END sebelum edit data


// START proses edit data
if (isset($_POST['edit'])) {

    // memasukan data ke variable sebelum di update ke database
    $idSatuanBarang = $_POST['id'];
    $namaSatuanBarang = $_POST['satuan'];

    // query update data
    $sql = @mysqli_query($conn, "UPDATE satuan_barang SET satuan='$namaSatuanBarang' WHERE id=$idSatuanBarang");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Diedit')</script>";
        echo "<script>window.location.href='".baseUrl("?page={$prefixPage}")."'</script>";
    }
}
// END proses edit data


// START proses hapus data
if (!empty($_GET['delete'])) {
    $idSatuanBarang = $_GET['delete'];

    // query hapus data
    $sql = @mysqli_query($conn, "DELETE FROM satuan_barang WHERE id=$idSatuanBarang");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Dihapus')</script>";
        echo "<script>window.location.href='".baseUrl("?page={$prefixPage}")."'</script>";
    }
}
// END proses hapus data


?>
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-3">Satuan Barang</h1>
    <form action="" class="row mb-4" method="post">
        <?php if (!empty($_GET['edit'])): ?>
        <input type="hidden" name="id" value="<?=$idSatuanBarang ?>">
        <div class="col-4">
            <input type="text" class="form-control" name="satuan" value="<?=$namaSatuanBarang ?>" required>
        </div>
        <div class="col">
            <button class="btn btn-success" name="edit">UPDATE</button> <a href="<?=baseUrl("?page={$prefixPage}") ?>" class="btn btn-secondary">KEMBALI</a>
        </div>
        <?php else : ?>
        <div class="col-4">
            <input type="text" class="form-control" name="satuan" required>
        </div>
        <div class="col">
            <button class="btn btn-success" name="insert"><i class="fa-solid fa-plus"></i> Insert</button>
        </div>
        <?php endif; ?>
    </form>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabel Satuan Barang
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="50%">Nama Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($satuanBarang as $key => $val): ?>
                    <tr>
                        <td><?=$key+1 ?></td>
                        <td><?=$val['satuan'] ?></td>
                        <td>
                            <a href="<?=baseUrl("?page={$prefixPage}&edit={$val['id']}") ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <a href="<?=baseUrl("?page={$prefixPage}&delete={$val['id']}") ?>" onclick="javascript:return confirm('Apakah anda yakin akan menghapusnya?');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>