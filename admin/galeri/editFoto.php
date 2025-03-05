<?php
include_once('../../koneksi/config.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$select = mysqli_query($mysqli, "SELECT f.*, g.id as album_id FROM tbl_foto f 
                                JOIN tbl_galeri g ON f.galeri_id = g.id 
                                WHERE f.id = $id");
$foto = mysqli_fetch_array($select);

if (!$foto) {
    header("location:listGaleri.php?pesan=fototidakditemukan");
    exit;
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];
    $gambar_lama = $_POST['gambar_lama'];

    // Cek apakah ada gambar baru
    $allowed_extensions = ['png', 'jpg', 'jpeg', 'svg'];
    $gambar_baru = $_FILES['gambar_baru']['name'];
    $image_ext = strtolower(pathinfo($gambar_baru, PATHINFO_EXTENSION));
    $image_size = $_FILES['gambar_baru']['size'];
    $image_tmp = $_FILES['gambar_baru']['tmp_name'];

    if ($gambar_baru == '') {
        // Update data tanpa gambar baru
        $query = mysqli_query($mysqli, "UPDATE `tbl_foto` SET 
            `judul` = '$judul',
            `deskripsi` = '$deskripsi',
            `status` = '$status'
            WHERE `id` = '$id'");
    } else {
        if (in_array($image_ext, $allowed_extensions)) {
            if ($image_size < 10485760) {
                move_uploaded_file($image_tmp, '../../assets/img/galeri/' . $gambar_baru);
                
                // Hapus gambar lama jika ada
                if (!empty($gambar_lama) && file_exists('../../assets/img/galeri/' . $gambar_lama)) {
                    unlink('../../assets/img/galeri/' . $gambar_lama);
                }
                
                $query = mysqli_query($mysqli, "UPDATE `tbl_foto` SET 
                    `judul` = '$judul',
                    `deskripsi` = '$deskripsi',
                    `status` = '$status',
                    `image` = '$gambar_baru'
                    WHERE `id` = '$id'");
            } else {
                echo "<script>alert('Ukuran file terlalu besar!');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file tidak diizinkan!');</script>";
            exit;
        }
    }

    header("location:manageFoto.php?album_id=" . $foto['album_id'] . "&pesan=berhasiledit");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Foto - <?= htmlspecialchars($foto['judul']) ?></title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <!-- Custom fonts and styles -->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <?php
    session_start();
    if ($_SESSION['role'] == '') {
        header("location:../auth/login.php?pesan=gagal");
    }
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include '../partials/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include '../partials/topbar.php'; ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Foto</h1>
                    </div>

                    <form action="editFoto.php?id=<?= $foto['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <a href="manageFoto.php?album_id=<?= $foto['album_id'] ?>" class="mb-2 btn btn-secondary">Kembali <i class="fas fa-fw fa-arrow-right"></i></a>
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <input type="hidden" name="id" value="<?= $foto['id'] ?>">
                                            <div class="col-md-12">
                                                <label for="formJudul" class="form-label">Judul Foto</label>
                                                <input type="text" class="form-control" id="formJudul" name="judul" value="<?= htmlspecialchars($foto['judul']) ?>" required>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <label for="formDeskripsi" class="form-label">Deskripsi</label>
                                                <textarea class="form-control" id="formDeskripsi" name="deskripsi" rows="4"><?= htmlspecialchars($foto['deskripsi']) ?></textarea>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <label for="formStatus" class="form-label">Status</label>
                                                <select class="form-control" id="formStatus" name="status" required>
                                                    <option value="aktif" <?= $foto['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                                    <option value="nonaktif" <?= $foto['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <img src="../../assets/img/foto/<?= $foto['image'] ?>" alt="Foto" class="img-fluid" style="max-height: 200px;">
                                            <input type="hidden" name="gambar_lama" value="<?= $foto['image'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="formImage">Ganti Foto</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="formImage" name="gambar_baru">
                                                <label class="custom-file-label" for="formImage">Pilih file...</label>
                                            </div>
                                            <small class="form-text text-muted">Format: PNG, JPG, JPEG, SVG. Maksimal 10MB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="edit" class="btn btn-warning">Update Foto</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php include '../partials/footer.php'; ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../assets/js/sb-admin-2.min.js"></script>
    
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>
</html> 