<?php
    include_once('../../koneksi/config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID album tidak ditemukan!'); window.location='listGaleri.php';</script>";
    exit();
}

$album_id = (int) $_GET['id'];

// Cek apakah album ada di database
$query = mysqli_query($mysqli, "SELECT * FROM tbl_galeri WHERE id = $album_id");
$album = mysqli_fetch_assoc($query);

if (!$album) {
    echo "<script>alert('Album tidak ditemukan!'); window.location='listGaleri.php';</script>";
    exit();
}

// Hapus gambar dari folder jika ada
if (!empty($album['image'])) {
    $file_path = "assets/img/galeri/" . $album['image'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// Hapus semua foto terkait dari album ini (jika ada tabel foto)
mysqli_query($mysqli, "DELETE FROM tbl_foto WHERE galeri_id = $album_id");

// Hapus album dari database
$delete_query = mysqli_query($mysqli, "DELETE FROM tbl_galeri WHERE id = $album_id");

if ($delete_query) {
    echo "<script>alert('Album berhasil dihapus!'); window.location='listGaleri.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus album!'); window.location='listGaleri.php';</script>";
}
?>
