<?php
    include_once('../../koneksi/config.php');
    session_start();

    if ($_SESSION['role'] == '') {
        header("location:../auth/login.php?pesan=gagal");
    } 

    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "DELETE FROM tbl_modul WHERE id_modul=$id");


    header('location:listModul.php?pesan=berhasildel');

?>
