<?php
    include_once('../../koneksi/config.php');

    $id = $_GET['id'];
    $select = mysqli_query($mysqli, "SELECT * FROM tbl_software WHERE id_software = $id");

    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $link = $_POST['link'];
        $status = $_POST['status'];
        $gLama = $_POST['gambarLama'];

        // gambarr baru
        $ekstensi_diperbolehkan	= array('png','jpg','svg','jpeg');
        $gBaru = $_FILES['gambarBaru']['name'];
        $x = explode('.', $gBaru);
        $ekstensi = strtolower(end($x));
        $ukuran	= $_FILES['gambarBaru']['size'];
        $file_tmp = $_FILES['gambarBaru']['tmp_name'];	
        
        if($gBaru == ''){
            // mengubah data tanpa gambar baru
            $result = mysqli_query($mysqli, "UPDATE `tbl_software` SET `id_software`='$id',`nama_software`='$nama',`link_software`='$link',`status`='$status',`image`='$gLama'
            WHERE `id_software` = '$id'");

        } else {
            if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                if($ukuran < 1044070){			
                    move_uploaded_file($file_tmp, '../../assets/img/'.$gBaru);
                    $result = mysqli_query($mysqli, "UPDATE `tbl_software` SET `id_software`='$id',`nama_software`='$nama',`link_software`='$link',`status`='$status',`image`='$gBaru'
                    WHERE `id_software` = '$id'");
                    if($query){
                        echo 'FILE BERHASIL DI UPLOAD';
                    }else{
                        echo 'GAGAL MENGUPLOAD GAMBAR';
                    }
                }else{
                    echo 'UKURAN FILE TERLALU BESAR';
                }
            }else{
                echo 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN';
            }
        }

        
    
        header('location:listSoftware.php?pesan=berhasiledit');
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

    <title>Ak-Menengah | Software</title>
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
                <a class="nav-link" href="listSoftware.php">
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Software</h1>
                    </div>

                    <!-- Edit Software Praktikan -->
                    <?php
                        while ($software = mysqli_fetch_array($select)) {
                    ?>
                    <form action="editSoftware.php?id=<?= $software['id_software']?>" method="POST" enctype="multipart/form-data">
                            
                    <div class="row g-3">
                        <div class="col-md-8">
                            <a href="listSoftware.php" class="mb-2 btn btn-secondary">Kembali <i class="fas fa-fw fa-arrow-right"></i></a>
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <input type="number" class="form-control" id="formid" name="id" value="<?= $software['id_software']?>" hidden>
                                        <div class="col-md-12">
                                            <label for="formNama" class="form-label">Nama Software</label>
                                            <input type="text" class="form-control" id="formNama" name="nama"  value="<?= $software['nama_software']?>" required>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                                <label for="formLink" class="form-label">Link Software</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="formLink" name="link"  value="<?= $software['link_software']?>" required>
                                            </div>  
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label for="formStatus" class="form-label">Status</label>
                                            <select class="form-control" id="formStatus" name="status" required>
                                                <option value=""></option>
                                                <option value="aktif">Aktif</option>
                                                <option value="nonaktif">Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="card shadow mb-4 mt-5">
                                <div class="card-body">
                                    <div class="text-center mt-5">
                                        <img src="../../assets/img/<?= $software['image']?>" alt="" width="250" height="90" >
                                        <input type="text" name="gambarLama" value="<?= $software['image']?>" hidden>
                                    </div>
                                    <div class="mt-5">
                                        <label for="formLink" class="form-label">Logo Software</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" name="gambarBaru">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-warning" type="submit" name="edit">Edit Software</button>
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