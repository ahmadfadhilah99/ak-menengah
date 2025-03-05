<?php
    include_once('../../koneksi/config.php');

    $id = $_GET['id'];
    $select = mysqli_query($mysqli, "SELECT * FROM tbl_galeri WHERE id = $id");

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
            $query = mysqli_query($mysqli, "UPDATE `tbl_galeri` SET 
                `judul` = '$judul',
                `deskripsi` = '$deskripsi',
                `status` = '$status'
                WHERE `id` = '$id'");
        } else {
            if (in_array($image_ext, $allowed_extensions)) {
                if ($image_size < 1044070) {
                    move_uploaded_file($image_tmp, '../../assets/img/galeri/' . $gambar_baru);
                    
                    // Hapus gambar lama jika ada
                    if (!empty($gambar_lama) && file_exists('../../assets/img/galeri/' . $gambar_lama)) {
                        unlink('../../assets/img/galeri/' . $gambar_lama);
                    }
                    
                    $query = mysqli_query($mysqli, "UPDATE `tbl_galeri` SET 
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

        header('location:listGaleri.php?pesan=berhasiledit');
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ak-Menengah | Galeri</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <!-- Custom fonts for this template-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon ">
                    <img src="../../assets/img/logo.png" alt="" width="60" >
                </div>
                <div class="sidebar-brand-text mx-3">LABAMEN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">


            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Fitur
            </div>

            <?php 
                if($_SESSION['role'] == 'admin'){
            ?>
            
            <li class="nav-item">
                <a class="nav-link" href="../akun/listAkun.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Akun</span></a>
                </li>
           
            <?php
                }
                ?>
            <li class="nav-item">
                <a class="nav-link" href="../modul/listModul.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Modul</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="../software/listSoftware.php">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Software</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listGaleri.php">
                    <i class="fas fa-fw fa-image"></i>
                    <span>Galeri</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->


        <!-- -------------------------------------- -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['username']?></span>
                                <img class="img-profile rounded-circle"
                                    src="../../assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                  
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                 <!-- Begin Page Content -->
                 <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Album Galeri</h1>
                    </div>

                    <!-- Edit Galeri -->
                    <?php
                        while ($galeri = mysqli_fetch_array($select)) {
                    ?>
                    <form action="editGaleri.php?id=<?= $galeri['id'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-8">
                                <a href="listGaleri.php" class="mb-2 btn btn-secondary">Kembali <i class="fas fa-fw fa-arrow-right"></i></a>
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row g-3">
                                            <input type="hidden" name="id" value="<?= $galeri['id'] ?>">
                                        <div class="col-md-12">
                                                <label for="formJudul" class="form-label">Judul Album</label>
                                                <input type="text" class="form-control" id="formJudul" name="judul" value="<?= htmlspecialchars($galeri['judul']) ?>" required>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                                <label for="formDeskripsi" class="form-label">Deskripsi</label>
                                                <textarea class="form-control" id="formDeskripsi" name="deskripsi" rows="4" required><?= htmlspecialchars($galeri['deskripsi']) ?></textarea>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label for="formStatus" class="form-label">Status</label>
                                            <select class="form-control" id="formStatus" name="status" required>
                                                    <option value="aktif" <?= $galeri['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                                    <option value="nonaktif" <?= $galeri['status'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
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
                                            <img src="../../assets/img/galeri/<?= $galeri['image'] ?>" alt="Cover Album" class="img-fluid" style="max-height: 200px;">
                                            <input type="hidden" name="gambar_lama" value="<?= $galeri['image'] ?>">
                                    </div>
                                        <div class="form-group">
                                            <label for="formImage">Ganti Cover Album</label>
                                        <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="formImage" name="gambar_baru">
                                                <label class="custom-file-label" for="formImage">Pilih file...</label>
                                            </div>
                                            <small class="form-text text-muted">Format: PNG, JPG, JPEG, SVG. Maksimal 1MB</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" name="edit" class="btn btn-warning">Update Album</button>
                            </div>
                        </div>
                    </form>
                    <?php
                        }
                    ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span> &copy; Copyright Labamen 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../auth/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/chart-area-demo.js"></script>
    <script src="../../assets/js/demo/chart-pie-demo.js"></script>
    
    
    <script>
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
</body>

</html>