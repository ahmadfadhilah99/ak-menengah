<?php
session_start();

include_once('Koneksi/config.php');

$username = $_POST['username'];
// $password = $_POST['password'];
$password = md5($_POST['password']);


$login = mysqli_query($mysqli, "SELECT * FROM tbl_akun WHERE username='$username' and password='$password'");

$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);
    if ($data['status'] == 'aktif') {
        if ($data['id_role'] == '1') {
            $_SESSION['username'] = $data['nama'];
            $_SESSION['role'] = "admin";
            header("location:admin/dashboard.php");

        } else if ($data['id_role'] == '2') {
            $_SESSION['username'] = $data['nama'];
            $_SESSION['role'] = "programmer";
            header("location:admin/dashboard.php");

        } else {
            header("location:index.php?pesan=gagal");
        }
    } else {
        header("location:index.php?pesan=gagal");
    }
} else {
    header("location:index.php?pesan=gagal");
}
