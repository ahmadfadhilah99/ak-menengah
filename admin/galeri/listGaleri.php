<?php
include_once('../../koneksi/config.php');

session_start();
if ($_SESSION['role'] == '') {
    header("location:../auth/login.php?pesan=gagal");
}

$dataGaleri = mysqli_query($mysqli, "SELECT * FROM tbl_galeri ORDER BY tanggal DESC;");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ak-Menengah | Galeri</title>
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon.png">

    <!-- Custom fonts and styles -->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include '../partials/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include '../partials/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Manajemen Galeri</h1>
                    </div>

                    <?php if (isset($_GET['pesan'])) {
                        if ($_GET['pesan'] == 'berhasiladd') { ?>
                            <div class="alert alert-success">Album berhasil ditambahkan!</div>
                        <?php } elseif ($_GET['pesan'] == 'berhasiledit') { ?>
                            <div class="alert alert-warning">Album berhasil diubah!</div>
                        <?php } elseif ($_GET['pesan'] == 'berhasildel') { ?>
                            <div class="alert alert-danger">Album berhasil dihapus!</div>
                    <?php }} ?>

                    <!-- Data Table -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <a href="addGaleri.php" class="mb-3 btn btn-primary">Tambah Album <i class="fas fa-fw fa-plus"></i></a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Gambar</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($galeri = mysqli_fetch_array($dataGaleri)) { ?>
                                        <tr>
                                            <td style="max-width: 250px;"><?= $galeri['judul'] ?></td>
                                            <td>
                                                <img src="../../assets/img/galeri/<?= $galeri['image'] ?>" width="100">
                                            </td>
                                            <td><?= date('d M Y', strtotime($galeri['tanggal'])) ?></td>
                                            <td style="max-width: 120px;">
                                                <a href="editGaleri.php?id=<?= $galeri['id'] ?>" class="btn btn-warning"><i class="fas fa-fw fa-pen"></i></a>
                                                <a href="deleteGaleri.php?id=<?= $galeri['id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus album ini?')"><i class="fas fa-fw fa-trash"></i></a>
                                                <a href="manageFoto.php?album_id=<?= $galeri['id'] ?>" class="btn btn-info"><i class="fas fa-fw fa-images"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
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
            <?php include '../partials/footer.php'; ?>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scripts -->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../assets/js/sb-admin-2.min.js"></script>
    <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/demo/datatables-demo.js"></script>

</body>
</html>
