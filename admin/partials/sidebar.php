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
    <a class="nav-link" href="listModul.php">
        <i class="fas fa-fw fa-book"></i>
        <span>Modul</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="../software/listSoftware.php">
        <i class="fas fa-fw fa-desktop"></i>
        <span>Software</span></a>
</li>
<li class="nav-item active">
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