<?php

require('config.php');

if ($_GET['function'] == 'caribarang') {
    $cari = trim(strip_tags($_POST['keyword']));
    if ($cari == '') {} else {
        $hasil1 = mysqli_query($conn, "SELECT produk.*, kategori_produk.nama_kategori
				                        FROM produk
                                        INNER JOIN stok_awal ON stok_awal.id_stok = produk.id_stok
                                        INNER JOIN kategori_produk ON produk.id_kategori = kategori_produk.id_kategori
				                        WHERE qty_stok>0 AND nama_produk LIKE '$cari%' OR qty_stok>0 AND nama_kategori LIKE '$cari%'");

        ?>
        <table class="table table-sm table-stripped" width="100%">
            <?php foreach ($hasil1 as $hasil) {
                ?>
                <tr>
                    <td><?php echo $hasil['nama_produk']; ?></td>
                    <td><?php echo $hasil['harga_jual']; ?></td>
                    <td>
                        <a href="function.php?function=addtokasir&idproduk=<?=$hasil['id_produk'] ?>">
                            <button class="btn btn-success">Beli</button></a></td>
                </tr>
                <?php
            } ?>
        </table>
        <?php
    }
}

if ($_GET['function'] == 'addtokasir') {
    $_SESSION['produkInKasir'][] = $_GET['idproduk'];
    header('Location: index.php?page=transaksi');
}

if ($_GET['function'] == 'deletefromkasir') {
    if (($key = array_search($_GET['idproduk'], $_SESSION['produkInKasir'])) !== false) {
        unset($_SESSION['produkInKasir'][$key]);
    }
    header('Location: index.php?page=transaksi');
}





?>