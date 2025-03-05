<?php
    include_once('../../koneksi/config.php');

    $dataAkun = mysqli_query($mysqli, "SELECT tbl_akun.id_akun, tbl_role.id_role, tbl_akun.nama_akun, tbl_akun.status, tbl_role.role
                                    FROM tbl_role
                                    INNER JOIN tbl_akun ON tbl_role.id_role = tbl_akun.id_role;");


    if (isset($_POST['update_status'])) {
        $id = $_POST['id'];
        $status_new = $_POST['status_new'];

        $result = mysqli_query($mysqli, "UPDATE tbl_akun SET status='$status_new' WHERE id_akun=$id ");
        header('location:listAkun.php');
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

    <title>Ak-Menengah | Akun</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <!-- Custom fonts for this template-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


</head>

<body id="page-top">

    <?php
        session_start();

        if ($_SESSION['role'] == '') {
            header("location:../auth/login.php?pesan=gagal");
        } else if ($_SESSION['role'] == 'programmer') {
            header("location:../dashboard.php");
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
            
            <li class="nav-item active">
                <a class="nav-link" href="listAkun.php">
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
            <li class="nav-item">
                <a class="nav-link" href="../software/listSoftware.php">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>Software</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../galeri/listGaleri.php">
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
                        <h1 class="h3 mb-0 text-gray-800">Akun Asisten</h1>
                    </div>
                    <?php if (isset($_GET['pesan'])) {
                            if ($_GET['pesan'] == 'berhasiladd') {
                    ?>
                        <div class="alert alert-success" role="alert">
                            Akun berhasil ditambahkan!
                        </div>    
                    <?php } if ($_GET['pesan'] == 'berhasiledit') { ?>
                        <div class="alert alert-warning" role="alert">
                            Akun berhasil diubah!
                        </div>    
                    <?php } if ($_GET['pesan'] == 'berhasildel') { ?>
                        <div class="alert alert-secondary" role="alert">
                            Akun berhasil dihapus!
                        </div>    
                    <?php }} ?>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <a href="addAkun.php" class="mb-3 btn btn-primary">Tambah <i class="fas fa-fw fa-arrow-right"></i></a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Divisi</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while ($akun = mysqli_fetch_array($dataAkun)) {
                                        ?>
                                        <tr>
                                            <td><?=$akun['nama_akun'] ?></td>
                                            <td><?=$akun['role'] ?></td>
                                            <td><?=$akun['status'] ?></td>
                                            <td style="max-width: 150px;">
                                        <?php 
                                            if ($akun['role'] == 'admin'){
                                        ?>        
                                            <button class="btn btn-primary">Aktif</button>
                                        <?php 
                                            } else {
                                        ?>        
                                                <div class="d-flex justify-content-between">
                                                    <form action='listAkun.php' method='POST' name='update_status' enctype='multipart/form-data'>
                                                        <input type='text' class='form-control' name='id' value="<?=$akun['id_akun']?>" hidden>
                                                        <input type='text' class='form-control' name='status_new' value='<?= $akun['status'] == 'aktif' ? 'nonaktif' : 'aktif';?>' hidden>
                                                        <input type='submit' name='update_status' style='--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;' 
                                                        class='btn <?= $akun['status'] == 'aktif' ? 'btn-danger' : 'btn-primary';?>' value='<?= $akun['status'] == 'aktif' ? 'non-aktifkan' : 'aktifkan';?>'> 
                                                        </input> 
                                                    </form>
                                                </div>
                                        <?php 
                                            }
                                        ?>        
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

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
    <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/datatables-demo.js"></script>

</body>

</html>