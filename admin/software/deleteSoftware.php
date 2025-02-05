<?php
    include_once('../../koneksi/config.php');
    session_start();

    if ($_SESSION['role'] == '') {
        header("location:../auth/login.php?pesan=gagal");
    } 

    $id = $_GET['id'];
    $result = mysqli_query($mysqli, "DELETE FROM tbl_software WHERE id_software=$id");


    header('location:listSoftware.php?pesan=berhasildel');

?>
