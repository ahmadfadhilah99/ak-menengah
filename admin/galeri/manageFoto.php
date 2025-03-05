<?php
include_once('../../koneksi/config.php');

$album_id = isset($_GET['album_id']) ? (int)$_GET['album_id'] : 0;

// Ambil data album
$album_query = mysqli_query($mysqli, "SELECT * FROM tbl_galeri WHERE id = $album_id");
$album = mysqli_fetch_array($album_query);

if (!$album) {
    header("location:listGaleri.php?pesan=albumtidakditemukan");
    exit;
}

// Ambil daftar foto dalam album
$fotos = mysqli_query($mysqli, "SELECT * FROM tbl_foto WHERE galeri_id = $album_id ORDER BY created_at DESC");

// Proses upload foto baru
if (isset($_POST['add_foto'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];

    $allowed_extensions = ['png', 'jpg', 'jpeg', 'svg'];
    $image_name = $_FILES['image']['name'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];

    if (in_array($image_ext, $allowed_extensions)) {
        if ($image_size < 10485760) {
            move_uploaded_file($image_tmp, '../../assets/img/galeri/' . $image_name);
            $query = mysqli_query($mysqli, "INSERT INTO `tbl_foto` (`galeri_id`, `judul`, `deskripsi`, `image`, `status`)  
            VALUES ('$album_id', '$judul', '$deskripsi', '$image_name', '$status');");

            if ($query) {
                header("location:manageFoto.php?album_id=$album_id&pesan=berhasiladd");
            } else {
                echo "<script>alert('Gagal menambahkan foto!');</script>";
            }
        } else {
            echo "<script>alert('Ukuran file terlalu besar!');</script>";
        }
    } else {
        echo "<script>alert('Format file tidak diizinkan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kelola Foto - <?= htmlspecialchars($album['judul']) ?></title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <!-- Custom fonts and styles -->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                        <h1 class="h3 mb-0 text-gray-800">Kelola Foto - <?= htmlspecialchars($album['judul']) ?></h1>
                    </div>

                    <?php if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == 'berhasiladd') { ?>
                            <div class="alert alert-success">Foto berhasil ditambahkan!</div>
                        <?php } elseif ($_GET['pesan'] == 'berhasiledit') { ?>
                            <div class="alert alert-warning">Foto berhasil diubah!</div>
                        <?php } elseif ($_GET['pesan'] == 'berhasildel') { ?>
                            <div class="alert alert-danger">Foto berhasil dihapus!</div>
                    <?php }} ?>

                    <!-- Data Table -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <button type="button" class="mb-3 btn btn-primary" data-toggle="modal" data-target="#addFotoModal">
                                Tambah Foto <i class="fas fa-fw fa-plus"></i>
                            </button>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Gambar</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($foto = mysqli_fetch_array($fotos)) { ?>
                                        <tr>
                                            <td style="max-width: 250px;"><?= htmlspecialchars($foto['judul']) ?></td>
                                            <td>
                                                <img src="../../assets/img/galeri/<?= $foto['image'] ?>" alt="Foto" class="img-fluid" style="max-height: 200px;">
                                            </td>
                                            <td>
                                                <span class="badge badge-<?= $foto['status'] == 'aktif' ? 'success' : 'danger' ?>">
                                                    <?= ucfirst($foto['status']) ?>
                                                </span>
                                            </td>
                                            <td style="max-width: 120px;">
                                                <a href="editFoto.php?id=<?= $foto['id'] ?>" class="btn btn-warning"><i class="fas fa-fw fa-pen"></i></a>
                                                <a href="deleteFoto.php?id=<?= $foto['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')"><i class="fas fa-fw fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../partials/footer.php'; ?>
        </div>
    </div>

    <!-- Add Foto Modal -->
    <div class="modal fade" id="addFotoModal" tabindex="-1" role="dialog" aria-labelledby="addFotoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFotoModalLabel">Tambah Foto Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="manageFoto.php?album_id=<?= $album_id ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formJudul">Judul Foto</label>
                            <input type="text" class="form-control" id="formJudul" name="judul" required>
                        </div>
                        <div class="form-group">
                            <label for="formDeskripsi">Deskripsi</label>
                            <textarea class="form-control" id="formDeskripsi" name="deskripsi" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="formImage">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="formImage" name="image" required>
                                <label class="custom-file-label" for="formImage">Pilih file...</label>
                            </div>
                            <small class="form-text text-muted">Format: PNG, JPG, JPEG, SVG. Maksimal 10MB</small>
                        </div>
                        <div class="form-group">
                            <label for="formStatus">Status</label>
                            <select class="form-control" id="formStatus" name="status" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" name="add_foto" class="btn btn-primary">Simpan Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../assets/js/sb-admin-2.min.js"></script>
    <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/demo/datatables-demo.js"></script>
    
    <script>
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>
</html> 