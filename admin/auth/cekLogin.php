<?php

include_once('../../koneksi/config.php');

$username = $_POST['username'];

$login = mysqli_query($mysqli, "SELECT * FROM tbl_akun WHERE username='$username'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);
    
    if( password_verify($_POST['password'], $data['password']) ) {
        session_start();
        if ($data['status'] == 'aktif') {
            if ($data['id_role'] == '1') {
                $_SESSION['username'] = $data['nama_akun'];
                $_SESSION['role'] = "admin";
                header("location:../dashboard.php");

            } else if ($data['id_role'] == '2') {
                $_SESSION['username'] = $data['nama_akun'];
                $_SESSION['role'] = "programmer";
                header("location:../dashboard.php");

            } else {
                header("location:login.php?pesan=gagal");
            }
        } else {
            header("location:login.php?pesan=gagal");
        }
    } else {
        header("location:login.php?pesan=gagal");
    }

} else {
    header("location:login.php?pesan=gagal");
}
