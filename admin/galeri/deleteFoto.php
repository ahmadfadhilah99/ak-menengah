<?php
include_once('../../koneksi/config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID foto tidak ditemukan!'); window.location='listGaleri.php';</script>";
    exit();
}

$foto_id = (int) $_GET['id'];

// Cek apakah foto ada di database
$query = mysqli_query($mysqli, "SELECT f.*, g.id as album_id FROM tbl_foto f 
                               JOIN tbl_galeri g ON f.galeri_id = g.id 
                               WHERE f.id = $foto_id");
$foto = mysqli_fetch_assoc($query);

if (!$foto) {
    echo "<script>alert('Foto tidak ditemukan!'); window.location='listGaleri.php';</script>";
    exit();
}

// Hapus gambar dari folder jika ada
if (!empty($foto['image'])) {
    $file_path = "../../assets/img/foto/" . $foto['image'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Hapus foto dari database
$delete_query = mysqli_query($mysqli, "DELETE FROM tbl_foto WHERE id = $foto_id");

if ($delete_query) {
    header("location:manageFoto.php?album_id=" . $foto['album_id'] . "&pesan=berhasildel");
} else {
    echo "<script>alert('Gagal menghapus foto!'); window.location='manageFoto.php?album_id=" . $foto['album_id'] . "';</script>";
}
?> 