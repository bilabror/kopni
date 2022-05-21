<?php
// import file config
require_once('config.php');

// proteksi halaman
// halaman ini hanya bisa diakses ketika user tidak dalam keadaan login
if (isset($_SESSION['login'])) {
    header('Location: index.php');
}

// proses login
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = @mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");

    if (@mysqli_num_rows($user) > 0) {
        // ketika data login benar
        $role = mysqli_fetch_assoc($user)['role'];

        $_SESSION['login'] = $username;
        $_SESSION['role'] = $role;
        echo '<script>alert("Login Sukses");window.location="index.php"</script>';
    } else {
        // ketika data login tidak benar
        echo '<script>alert("Login Gagal");history.go(-1);</script>';
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>KOPERASI KONI | LOGIN</title>
</head>
<body style="background-color: #A52A2A">
    <div class="container text-center">
        <div class="mt-5">
            <img class="mt-5" src="assets/img/koperasi-koni.png" alt="Logo Koperasi Koni" width="50%">
            <form action="" method="post" class="row justify-content-center">
                <div class="col-md-6 col-sm-10">
                    <input type="text" class="form-control mb-3" placeholder="Username" name="username" required="" autofocus="1">
                    <input type="password" class="form-control mb-3" placeholder="Password" name="password" required="" autofocus="2">
                    <div class="d-grid gap-2">
                        <button type="submit" name="submit" class="btn btn-primary">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>