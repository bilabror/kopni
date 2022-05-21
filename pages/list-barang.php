<?php

isAdmin();


$prefixPage = 'list-barang';
$produk = @mysqli_query($conn, "SELECT produk.*,stok_awal.qty_stok,kategori_produk.nama_kategori FROM produk
                                INNER JOIN stok_awal ON stok_awal.id_stok = produk.id_stok
                                INNER JOIN kategori_produk ON kategori_produk.id_kategori = produk.id_kategori");




// START proses hapus data
if (!empty($_GET['delete'])) {
    $idProduk = $_GET['delete'];
    $idStok = mysqli_fetch_assoc(@mysqli_query($conn, "SELECT id_stok FROM produk WHERE id_produk=$idProduk"))['id_stok'];

    // query hapus data
    $sql = @mysqli_query($conn, "DELETE FROM stok_awal WHERE id_stok=$idStok");
    $sql = @mysqli_query($conn, "DELETE FROM produk WHERE id_produk=$idProduk");

    // jika query berhasil
    if ($sql) {
        echo "<script>window.alert('Data Berhasil Dihapus')</script>";
        echo "<script>window.location.href='".baseUrl("?page={$prefixPage}")."'</script>";
    }
}
// END proses hapus data



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">List Barang</h1>
    <a href="<?=baseUrl('?page=tambah-list-barang') ?>" class="btn btn-primary mb-3"><i class="fa-solid fa-plus"></i> Insert</a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabel List Barang
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Id Barang</th>
                        <th>Kategori</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th width="8%">Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produk as $key => $val): ?>
                    <?php
                    $bg = '';
                    if ($val['qty_stok'] <= 5) $bg = 'bg-warning';
                    if ($val['qty_stok'] == 0) $bg = 'bg-danger';
                    ?>
                    <tr>
                        <td><?=$key+1 ?></td>
                        <td><?=idBarangCustom($val['id_produk']) ?></td>
                        <td><?=$val['nama_kategori'] ?></td>
                        <td><?=$val['nama_produk'] ?></td>
                        <td><?=$val['harga_jual'] ?></td>
                        <td><?=$val['satuan'] ?></td>
                        <td class="<?=$bg ?>"><?=$val['qty_stok'] ?></td>
                        <td>
                            <a href="<?=baseUrl("?page=edit-{$prefixPage}&edit={$val['id_produk']}") ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <a href="<?=baseUrl("?page={$prefixPage}&delete={$val['id_produk']}") ?>" onclick="javascript:return confirm('Apakah anda yakin akan menghapusnya?');" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>