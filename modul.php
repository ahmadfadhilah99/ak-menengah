<?php
  include_once('koneksi/config.php');

  $data = mysqli_query($mysqli, "SELECT * FROM tbl_modul WHERE status = 'aktif'");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title>Ak-Menengah</title>
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">

        <link rel="stylesheet" href="assets/css/app.css?<?= time(); ?>">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body>
        <header class="navbar-container1" id="navbar">
            <div class="logo">
                <img src="assets/img/logo.png" alt="logo lab">
            </div>
           <ul class="nav-links">
              <li><a href="index.php">Home</a></li>
              <li><a href="tatatertib.php">Tata Tertib</a></li>
              <li><a href="modul.php">Modul</a></li>
              <li><a href="software.php">Software</a></li>
              <li><a href="galeri.php" class="active">Galeri</a></li>
          </ul>
            <div class="menu-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </header>

        <main>
            <div class="page-modul">
                <div class="content-modul">
                    <h1 class="title">Modul Praktikum</h1>
                    <p class="subtitle">Pilih dan download modul yang Anda butuhkan</p>
                    <div class="search-container">
                        <input type="text" id="searchModul" placeholder="Cari modul..." class="search-input">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </div>
                
                <div class="modul-list">
                    <?php
                    while ($modul = mysqli_fetch_array($data)) {
                        $upload_date = date('d F Y', strtotime($modul['tgl_upload']));
                    ?>
                    <div class="modul-item">
                        <div class="modul-content">
                            <div class="modul-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="modul-info">
                                <h3><?=$modul['nama_modul']?></h3>
                                <div class="modul-meta">
                                    <span class="upload-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <?=$upload_date?>
                                    </span>
                                    <span class="file-type">
                                        <i class="far fa-file"></i>
                                        PDF
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <!-- <a href="<?=$modul['link_modul']?>" class="preview-btn" target="_blank">
                                <i class="far fa-eye"></i>
                                Preview
                            </a> -->
                            <a href="<?=$modul['link_modul']?>" class="download-btn" download>
                                <i class="fas fa-download"></i>
                                Download
                            </a>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </main>

        <footer>
            <div class="content-wrapper" id="about">  
                <img src="assets/img/logo2.png" alt="logo lab">
                <p>Universitas Gunadarma Kampus E <br><br> <b>Jl. Komjen.Pol.M.Jasin No.9, Tugu, Kec. Cimanggis, Kota Depok, Jawa Barat 16451</b></p>
                 <div class="sosial-media">
                    <small><i class="fab fa-instagram"></i> labamen_ug</small>            
                    <small><i class="far fa-envelope"></i> labamendepok@gmail.com</small>            
              </div>
            </div>
        </footer>

        <script src="assets/js/main.js?<?= time(); ?>"></script>

    </body>
</html>