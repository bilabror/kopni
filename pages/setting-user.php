<?php
$primaryKey = $_SESSION['login'];
$user = @mysqli_fetch_assoc(@mysqli_query($conn, "SELECT * FROM user WHERE username='$primaryKey'"));

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $newPassword = $_POST['new_password'];
    $updatePassword = '';
    if (!empty($_POST['new_password']))
        $updatePassword = ",password='$newPassword'";


    $sql = @mysqli_query($conn, "UPDATE user SET nama='$nama',username='$username'$updatePassword WHERE username='$primaryKey'");

    if ($sql) {
        $_SESSION['login'] = $username;
        echo "<script>window.alert('Data Berhasil Diubah')</script>";
        echo "<script>window.location.href='".baseUrl("?page=setting-user")."'</script>";
    }

}


?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Setting User</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Edit User
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" required value="<?=$user['nama'] ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" required value="<?=$user['username'] ?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="new_password" class="col-sm-2 col-form-label">Password Baru</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                        <i class="text-muted">
                            Kosongkan jika tidak akan melakukan perubahan password
                        </i>
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col">
                        <button class="btn btn-primary" name="submit" type="submit"><i class="fa-solid fa-floppy-disk"></i> SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>