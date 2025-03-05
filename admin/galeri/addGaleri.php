<?php
include_once('../../koneksi/config.php');

if (isset($_POST['add'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $status = $_POST['status'];
    $tanggal = date('Y-m-d');

    $allowed_extensions = ['png', 'jpg', 'jpeg', 'svg'];
    $image_name = $_FILES['image']['name'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $image_size = $_FILES['image']['size'];
    $image_tmp = $_FILES['image']['tmp_name'];

    if ($image_name == '') {
        // Jika tidak ada gambar, hanya masukkan data teks
        $query = mysqli_query($mysqli, "INSERT INTO `tbl_galeri` (`judul`, `deskripsi`, `tanggal`, `status`) 
        VALUES ('$judul', '$deskripsi', '$tanggal', '$status');");
    } else {
        if (in_array($image_ext, $allowed_extensions)) {
            if ($image_size < 10485760) {
                move_uploaded_file($image_tmp, '../../assets/img/galeri/' . $image_name);
                $query = mysqli_query($mysqli, "INSERT INTO `tbl_galeri` (`judul`, `deskripsi`, `tanggal`, `image`, `status`)  
                VALUES ('$judul', '$deskripsi', '$tanggal', '$image_name', '$status');");

                if ($query) {
                    echo 'FILE BERHASIL DI UPLOAD';
                } else {
                    echo 'GAGAL MENGUPLOAD GAMBAR';
                }
            } else {
                echo 'UKURAN FILE TERLALU BESAR';
            }
        } else {
            echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
        }
    }

    header('location:listGaleri.php?pesan=berhasiladd');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Album Galeri</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <!-- Custom fonts for this template-->
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
            <div id="content">
                <?php include '../partials/topbar.php'; ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Tambah Album Galeri</h1>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="addGaleri.php" method="POST" enctype="multipart/form-data">
                            
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <a href="listGaleri.php" class="mb-2 btn btn-secondary">Kembali <i class="fas fa-fw fa-arrow-right"></i></a>
                                    <div class="card shadow mb-4">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <label for="formJudul" class="form-label">Judul Album</label>
                                                    <input type="text" class="form-control" id="formJudul" name="judul" required>
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <label for="formDeskripsi" class="form-label">Deskripsi</label>
                                                    <textarea class="form-control" id="formDeskripsi" name="deskripsi" rows="4" required></textarea>
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <label for="formStatus" class="form-label">Status</label>
                                                    <select class="form-control" id="formStatus" name="status" required>
                                                        <option value=""></option>
                                                        <option value="aktif">Aktif</option>
                                                        <option value="nonaktif">Nonaktif</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <label for="formImage" class="form-label">Cover Album</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="formImage" name="image">
                                                        <label class="custom-file-label" for="formImage">Pilih file...</label>
                                                    </div>
                                                    <small class="form-text text-muted">Format: PNG, JPG, JPEG, SVG. Maksimal 10MB</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" name="add" class="btn btn-primary">Simpan Album</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
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
