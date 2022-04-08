<?php
require_once('config.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="<?=baseUrl() ?>">KOPERASI KONI</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>
        <!-- Navbar-->
        <a href="logout.php" class="ms-auto ms-md-0 me-3 me-lg-4 btn btn-success"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="<?=baseUrl() ?>">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-gauge"></i>
                            </div>
                            Dashboard
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#masterDataNav" aria-expanded="false" aria-controls="masterDataNav">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            Master Data
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="masterDataNav" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=baseUrl('?page=kategori-barang') ?>">Kategori Barang</a>
                                <a class="nav-link" href="<?=baseUrl('?page=list-barang') ?>">List Barang</a>
                                <a class="nav-link" href="<?=baseUrl('?page=stok-barang') ?>">Stok Barang</a>
                                <a class="nav-link" href="<?=baseUrl('?page=barang-terjual') ?>">Barang Terjual</a>
                            </nav>
                        </div>

                        <a class="nav-link" href="<?=baseUrl('?page=transaksi') ?>">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            Transaksi
                        </a>

                        <a class="nav-link" href="<?=baseUrl('?page=laporan-penjualan') ?>">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-file"></i>
                            </div>
                            Laporan Penjualan
                        </a>

                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#settingNav" aria-expanded="false" aria-controls="settingNav">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-gear"></i>
                            </div>
                            Setting
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="settingNav" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?=baseUrl('?page=setting-user') ?>">User</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <?php

                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    $path = "pages/{$page}.php";
                    if (file_exists($path)) {
                        require($path);
                    } else {
                        require("pages/dashboard.php");
                    }
                } else {
                    require('pages/dashboard.php');
                }


                ?>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">
                            Copyright &copy; Your Website 2022
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>

    <script>

        // datatable
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });


        $(document).ready(function() {

            totalHarga();

            // search produk
            // untuk halaman transaksi
            $("#cari").keyup(function() {
                $.ajax({
                    type: "POST",
                    url: "function.php?function=caribarang",
                    data: 'keyword='+$(this).val(),
                    beforeSend: function() {
                        $("#hasil_cari").hide();
                        $("#tunggu").html('<p style="color:green"><blink>tunggu sebentar</blink></p>');
                    },
                    success: function(html) {
                        $("#tunggu").html('');
                        $("#hasil_cari").show();
                        $("#hasil_cari").html(html);
                    }
                });
            });


            // ketika mengetikan sesuatu di kolom jumlah
            // untuk halaman transaksi
            $('.jumlah').keyup(function() {
                let limitStok = parseInt($(this).data('max'));
                let jumlah = parseInt($(this).val());
                let id = $(this).data('id');
                let hargaJual = $(this).data('harga');
                $(`.subtotal${id}`).val(rupiah(hargaJual*jumlah))
                $(`.subtotal${id}`).data('subtotal', hargaJual*jumlah)
                if (jumlah > limitStok) {
                    $(this).val(limitStok)
                    $(`.subtotal${id}`).val(rupiah(hargaJual*limitStok))
                    $(`.subtotal${id}`).data('subtotal', hargaJual*limitStok)
                } else if (jumlah < 1 || $(this).val().length === 0) {
                    $(this).val(1)
                    $(`.subtotal${id}`).val(rupiah(hargaJual))
                    $(`.subtotal${id}`).data('subtotal', hargaJual)
                } else {
                    $(`.error-penjualan${id}`).html(``)
                }
                totalHarga()
                kembalian()
            })


            // ketika mengetikan sesuatu di halaman bayar
            // untuk halaman transaksi
            $('.bayar').keyup(function() {
                kembalian();
            })



        });


        // menentukan total harga
        // untuk halaman transaksi
        function totalHarga() {
            var sum = 0;
            $(".subtotal").each(function() {
                sum += +$(this).data('subtotal');
            });
            $('.totalharga').val(rupiah(sum))
            $('.totalharga').data('totalharga', sum)
        }


        // menentukan kembalian
        // untuk halaman transaksi
        function kembalian() {
            let MinimalBayar = $('.totalharga').data('totalharga');
            let bayar = $('.bayar').val();
            let kembalian = bayar - MinimalBayar;
            if (bayar < MinimalBayar) {
                $('.kembalian').val(`-${rupiah(kembalian)}`)
                $('.error-bayar').html(`minimal pembayaran adalah ${rupiah(MinimalBayar)}`)
            } else {
                $('.kembalian').val(rupiah(kembalian))
                $('.error-bayar').html(``)

            }
        }

        // set format number ke rupiah
        function rupiah(numb) {
            let format = numb.toString().split('').reverse().join('');
            let convert = format.match(/\d{1,3}/g);
            return 'Rp.' + convert.join('.').split('').reverse().join('')
        }

    </script>
</body>
</html>