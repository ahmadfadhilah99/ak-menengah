<?php
  include_once('koneksi/config.php');

  $data = mysqli_query($mysqli, "SELECT * FROM tbl_software WHERE status = 'aktif'");

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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
          </ul>
            <div class="menu-toggle">
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
            </div>
        </header>

        <main>
            <!-- content 3 -->
            <div class="page-software" >
              <div class="content-description">
                <h1 class="title">Software</h1>
              </div>
              <div class="content-software">
              <?php
                while ($software = mysqli_fetch_array($data)) {
              ?>
              
                <div class="software">
                  <img src="assets/img/<?=$software['image']?>" alt="">
                  <h1 class="title"><?=$software['nama_software']?></h1>
                  <a href="<?=$software['link_software']?>" target="_blank"><button>Install Sekarang</button></a>
                </div>
              
              <?php
                }
              ?>
              </div>
            </div>
          </main>

          <!-- footer -->
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