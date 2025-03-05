<?php
  include_once('koneksi/config.php');

  // Check if specific album is requested
  $album_id = isset($_GET['album_id']) ? (int)$_GET['album_id'] : 0;
  
  if ($album_id > 0) {
    // Get specific album details
    $album_query = mysqli_query($mysqli, "SELECT * FROM tbl_galeri WHERE id = $album_id AND status = 'aktif'");
    $album = mysqli_fetch_array($album_query);
    
    // Get all photos from this album (assuming you have a photos table linked to albums)
    // If you don't have a separate photos table, you can modify this to fit your database structure
    $photos = mysqli_query($mysqli, "SELECT * FROM tbl_foto WHERE galeri_id = $album_id AND status = 'aktif'");
  } else {
    // Pagination for album list view
    $itemsPerPage = 9;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $itemsPerPage;
    
    // Get total items for pagination
    $totalItems = mysqli_num_rows(mysqli_query($mysqli, "SELECT * FROM tbl_galeri WHERE status = 'aktif'"));
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    // Get gallery items with pagination
    $data = mysqli_query($mysqli, "SELECT * FROM tbl_galeri WHERE status = 'aktif' ORDER BY tanggal DESC LIMIT $offset, $itemsPerPage");
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?php echo $album_id > 0 ? htmlspecialchars($album['judul']) . ' - ' : ''; ?>Galeri - Ak-Menengah</title>
        <meta name="description" content="Galeri foto kegiatan Laboratorium Ak-Menengah Universitas Gunadarma">
        <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">

        <link rel="stylesheet" href="assets/css/app.css?<?= time(); ?>">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Add Lightbox CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            .photos-grid {
                columns: 4 300px;
                column-gap: 20px;
                padding: 20px;
                width: 100%;
                max-width: 1400px;
                margin: 0 auto;
            }

            .photo-item {
                position: relative;
                overflow: hidden;
                border-radius: 8px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                break-inside: avoid;
                margin-bottom: 20px;
                display: inline-block;
                width: 100%;
                max-width: 100%;
            }

            .photo-item:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.2);
                z-index: 2;
            }

            /* Menghapus pola grid yang lama */
            .photo-item:nth-child(6n+1),
            .photo-item:nth-child(6n+2),
            .photo-item:nth-child(6n+3),
            .photo-item:nth-child(6n+4),
            .photo-item:nth-child(6n+5),
            .photo-item:nth-child(6n),
            .photo-item:nth-child(12n+3) {
                grid-column: auto;
                grid-row: auto;
                margin: 0;
            }

            .photo-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
                display: block;
                object-position: center;
                background-color: #f5f5f5;
            }

            .photo-item a {
                display: block;
                width: 100%;
                height: 100%;
            }

            .photo-item a img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
                display: block;
                object-position: center;
                background-color: #f5f5f5;
            }

            .photo-item:hover img {
                transform: scale(1.1);
            }

            .photo-caption {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: linear-gradient(transparent, rgba(0,0,0,0.85));
                color: white;
                padding: 20px;
                transform: translateY(100%);
                transition: transform 0.3s ease;
                backdrop-filter: blur(5px);
            }

            .photo-item:hover .photo-caption {
                transform: translateY(0);
            }

            .photo-caption h4 {
                margin: 0;
                font-size: 16px;
                font-weight: 600;
                letter-spacing: 0.5px;
                margin-bottom: 8px;
            }

            .photo-caption p {
                margin: 0;
                font-size: 13px;
                line-height: 1.4;
                opacity: 0.9;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            @media (max-width: 1200px) {
                .photos-grid {
                    columns: 3 300px;
                    padding: 15px;
                }
            }

            @media (max-width: 768px) {
                .photos-grid {
                    columns: 2 300px;
                    column-gap: 15px;
                    padding: 15px;
                    width: 95%;
                }
            }

            @media (max-width: 480px) {
                .photos-grid {
                    columns: 2 180px;
                    column-gap: 12px;
                    padding: 12px;
                    width: 100%;
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    align-items: flex-start;
                }

                .photo-item {
                    margin-bottom: 12px;
                    width: calc(50% - 6px);
                    max-width: none;
                    margin-left: 3px;
                    margin-right: 3px;
                    border-radius: 6px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                }

                .photo-item:hover {
                    transform: none;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                }

                .photo-item img {
                    border-radius: 6px;
                }

                .photo-caption {
                    display: none;
                }

                .photo-item a {
                    display: block;
                    width: 100%;
                    height: auto;
                }

                .photo-item a img {
                    width: 100%;
                    height: auto;
                    aspect-ratio: 1;
                    object-fit: cover;
                }
            }
        </style>

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
            <!-- content gallery -->
            <div class="page-galeri">
              <?php if ($album_id > 0 && isset($album)) { ?>
                <!-- Album detail view -->
                <a href="galeri.php" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Galeri</a>
                
                <div class="album-header">
                  <h2><?= htmlspecialchars($album['judul']) ?></h2>
                  <div class="album-meta">
                    <span><i class="far fa-calendar-alt"></i> <?= date('d M Y', strtotime($album['tanggal'])) ?></span>
                  </div>
                  <div class="album-description">
                    <?= nl2br(htmlspecialchars($album['deskripsi'])) ?>
                  </div>
                </div>
                
                <div class="photos-grid">
                  <?php
                    // If you have a separate photos table
                    if (isset($photos) && mysqli_num_rows($photos) > 0) {
                      while ($photo = mysqli_fetch_array($photos)) {
                  ?>
                    <div class="photo-item">
                      <a href="assets/img/galeri/<?= $photo['image'] ?>" data-lightbox="album-<?= $album_id ?>" data-title="<?= htmlspecialchars($photo['judul']) ?>">
                        <img src="assets/img/galeri/<?= $photo['image'] ?>" alt="<?= htmlspecialchars($photo['judul']) ?>">
                      </a>
                      <div class="photo-caption">
                        <h4><?= htmlspecialchars($photo['judul']) ?></h4>
                        <p><?= htmlspecialchars($photo['deskripsi']) ?></p>
                      </div>
                    </div>
                  <?php   
                      }
                    } else {
                      // If you don't have a separate photos table, display a message
                      // or use a different approach based on your database structure
                  ?>
                    <div class="no-results">
                      <i class="fas fa-camera"></i>
                      <p>Belum ada foto dalam album ini</p>
                    </div>
                  <?php
                    }
                  ?>
                </div>
                
              <?php } else { ?>
                <!-- Album list view -->
                <div class="title-galeri">
                  <h1 class="title">Galeri Kegiatan</h1>
                  <p class="subtitle">Dokumentasi berbagai kegiatan di Laboratorium Ak-Menengah</p>
                </div>
                
                <div class="content-galeri">
                <?php
                  if (mysqli_num_rows($data) > 0) {
                    while ($galeri = mysqli_fetch_array($data)) {
                ?>
                
                  <div class="galeri-item" onclick="window.location.href='galeri.php?album_id=<?= $galeri['id'] ?>'">
                    <img src="assets/img/galeri/<?=$galeri['image']?>" alt="<?=htmlspecialchars($galeri['judul'])?>">
                    <div class="galeri-caption">  
                      <h3><?=htmlspecialchars($galeri['judul'])?></h3>
                      <p><?=htmlspecialchars(substr($galeri['deskripsi'], 0, 100)).(strlen($galeri['deskripsi']) > 100 ? '...' : '')?></p>
                      <div class="galeri-action">
                        <span class="date"><i class="far fa-calendar-alt"></i> <?=date('d M Y', strtotime($galeri['tanggal']))?></span>
                      </div>
                    </div>
                  </div>
                
                <?php
                    }
                  } else {
                ?>
                  <div class="no-results">
                    <i class="fas fa-camera"></i>
                    <p>Belum ada album yang ditambahkan</p>
                  </div>
                <?php
                  }
                ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                  <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>"><i class="fas fa-chevron-left"></i></a>
                  <?php endif; ?>
                  
                  <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == $page): ?>
                      <span class="current"><?= $i ?></span>
                    <?php else: ?>
                      <a href="?page=<?= $i ?>"><?= $i ?></a>
                    <?php endif; ?>
                  <?php endfor; ?>
                  
                  <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>"><i class="fas fa-chevron-right"></i></a>
                  <?php endif; ?>
                </div>
                <?php endif; ?>
              <?php } ?>
            </div>
          </main>

          <!-- footer -->
          <footer>
            <div class="content-wrapper" id="about">  
              <img src="assets/img/logo2.png" alt="logo lab">
              <p>Universitas Gunadarma Kampus E <br><br> <b>Jl. Komjen.Pol.M.Jasin No.9, Tugu, Kec. Cimanggis, Kota Depok, Jawa Barat 16451</b></p>
            </div>
          </footer>

          <!-- Scripts -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
          <script src="assets/js/main.js?v=1.0"></script>
          
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              // Initialize Lightbox
              lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'albumLabel': "Gambar %1 dari %2"
              });
            });
          </script>
    </body>
</html>
