<?php

isAdmin();

$idProduk = $_GET['idproduk'] ?? "";

$whereByProduk = !empty($idProduk) ? "WHERE riwayat_tambah_stok.id_produk=$idProduk" : "";

$prefixPage = 'stok-barang';

// get produk
$produks = @mysqli_query($conn, "SELECT * FROM produk");


$sql = "SELECT *,riwayat_tambah_stok.tgl_input as tgl_input_stok FROM riwayat_tambah_stok
        INNER JOIN produk ON produk.id_produk=riwayat_tambah_stok.id_produk
        $whereByProduk
        ORDER BY riwayat_tambah_stok.tgl_input DESC
        ";
$listData = @mysqli_query($conn, $sql);
echo mysqli_error($conn);

?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Stok Barang</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabel History Tambah Stok Barang
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="<?=baseUrl('?page=tambah-stok-barang') ?>" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Tambah Stok</a>
                </div>
                <div>
                    <form action="" class="form-inline">
                        <input type="hidden" name="page" value="stok-barang">
                        <div class="row">
                            <div class="form-group col-auto">
                                <select name="idproduk" id="idproduk" class="form-select" required>
                                    <option value="" selected>Semua Produk</option>
                                    <?php foreach ($produks as $val): ?>
                                    <option <?= $idProduk == $val['id_produk'] ? 'selected' : '' ?>
                                        value="<?=$val['id_produk'] ?>">
                                        <?=$val['nama_produk'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-auto">
                                <button class="btn btn-info col-auto"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Id Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok masuk</th>
                            <th>Tgl input</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listData as $key => $value):
                        ?>

                        <tr>
                            <td><?=$key+1 ?></td>
                            <td><?=idBarangCustom($value['id_produk']) ?></td>
                            <td><?=$value['nama_produk'] ?></td>
                            <td><?=$value['stok_tambahan'] ?></td>
                            <td><?=date("d M Y", strtotime($value['tgl_input_stok'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>