<?php

isAdmin();

$produkInKasir = [];


if (isset($_SESSION['produkInKasir'])) {

    $where = '';
    foreach (array_unique($_SESSION['produkInKasir']) as $key) {
        $where .= "id_produk=$key and ";
    }
    $where = substr($where, 0, strlen($where)-5);
    $idsProduk = implode(',', array_unique($_SESSION['produkInKasir']));

    $produkInKasir = mysqli_query($conn, "SELECT produk.*,stok_awal.qty_stok,kategori_produk.nama_kategori FROM produk
                                INNER JOIN stok_awal ON stok_awal.id_stok = produk.id_stok
                                INNER JOIN kategori_produk ON kategori_produk.id_kategori = produk.id_kategori
				WHERE id_produk IN ($idsProduk) AND qty_Stok > 0");

}


if (isset($_POST['submit'])) {
    $totalHarga = rupiahToNumber($_POST['totalharga']);
    $qtyBarang = $_POST['qty_barang'];
    $bayar = $_POST['bayar'];
    $idProduk = $_POST['idproduk'];
    $idStok = $_POST['idstok'];
    $tglInput = date('Y-m-d H:i:s');
    $kembalian = $bayar - $totalHarga;
    echo $kembalian;

    foreach ($_POST['subtotal'] as $key => $val) {
        $subTotal[] = rupiahToNumber($_POST['subtotal'][$key]);
    }

    $insertTranssksi = @mysqli_query($conn, "INSERT INTO transaksi_keluar VALUE('','$tglInput',$totalHarga,$bayar,$kembalian)");
    $idTransaksi = mysqli_insert_id($conn);

    foreach ($idProduk as $key => $value) {
        @mysqli_query($conn, "INSERT INTO item_keluar VALUE('',$idTransaksi,$idProduk[$key],$qtyBarang[$key],$subTotal[$key])");

    }

    foreach ($idStok as $key => $value) {
        @mysqli_query($conn, "UPDATE stok_awal SET qty_stok=qty_stok-$qtyBarang[$key] WHERE id_stok=$value");
    }



    unset($_SESSION['produkInKasir']);

    echo "<script>window.alert('Data Berhasil Disimpan')</script>";
    echo "<script>window.location.href='".baseUrl("print-transaksi.php?id={$idTransaksi}")."'</script>";


}


?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Keranjang Penjualan</h1>

    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fa fa-search me-1"></i>
                    Cari Barang
                </div>
                <div class="card-body">
                    <input type="text" id="cari" class="form-control" name="cari" placeholder="Masukan Nama Barang / Kategori Barang">
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="fa fa-list"></i>
                    Hasil Pencarian
                </div>
                <div class="card-body">
                    <div id="hasil_cari"></div>
                    <div id="tunggu"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fa fa-shopping-cart me-1"></i>
            KASIR
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td><b>Tanggal</b></td>
                    <td><input type="text" readonly="readonly" class="form-control" value="<?php echo date("j F Y, G:i"); ?>" name="tgl"></td>
                </tr>
            </table>
            <form action="" method="post">
                <?php if ($produkInKasir): ?>
                <?php foreach ($produkInKasir as $value): ?>
                <input type="hidden" name="idproduk[]" value="<?=$value['id_produk']; ?>">
                <input type="hidden" name="idstok[]" value="<?=$value['id_stok']; ?>">
                <?php endforeach; ?>
                <?php endif; ?>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="8%">No</th>
                            <th>Nama Barang</th>
                            <th>harga Satuan</th>
                            <th width="10%">Jumlah</th>
                            <th width="20%">Total harga</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($produkInKasir): ?>
                        <?php foreach ($produkInKasir as $key => $val): ?>
                        <tr>
                            <td><?=$key+1 ?></td>
                            <td><?=$val['nama_produk'] ?></td>
                            <td><?=rupiah($val['harga_jual']) ?></td>
                            <td><input class="form-control jumlah" type="text" value="1" data-id="<?=$val['id_produk'] ?>" data-max="<?=$val['qty_stok'] ?>" data-harga="<?=$val['harga_jual'] ?>" name="qty_barang[]" required=""></td>
                            <td><input class="form-control subtotal<?=$val['id_produk'] ?> subtotal" value="<?=rupiah($val['harga_jual']) ?>" type="text" data-subtotal="<?=$val['harga_jual'] ?>" readonly="" name="subtotal[]"></td>
                            <td>
                                <a href="function.php?function=deletefromkasir&idproduk=<?=$val ['id_produk'] ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <table class="table">
                    <input type="hidden" class="form-control" value="">
                    <tr>
                        <td>Total Semua  </td>
                        <td><input type="text" class="form-control totalharga" data-totalharga="" name="totalharga" readonly="" value=""></td>
                        <td>Bayar  </td>
                        <td>
                            <div>
                                <input type="text" class="form-control bayar" name="bayar" id="bayar" value="" required>
                                <div class="text-danger error-bayar">
                                </div>
                            </div>
                        </td>

                        <td><button class="btn btn-success" type="submit" name="submit"><i class="fa fa-shopping-cart"></i> Bayar</button></td>
                    </tr>

                    <tr>
                        <td>Kembali</td>
                        <td><input type="text" class="form-control kembalian" readonly="" value="<?= rupiah(0) ?>"></td>
                        <td></td>
                        <td>
                        </td>

                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>