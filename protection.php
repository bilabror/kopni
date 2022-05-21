<?php

// isAdmin
// Ketika funsi ini dipanggil artinya halaman tersebut hanya boleh diakses dengan syarat rolenya adalah admin.
function isAdmin() {
    if ($_SESSION['role'] != 'admin')
        echo '<script>alert("Akses Anda Ditolak");window.location="index.php"</script>';
}