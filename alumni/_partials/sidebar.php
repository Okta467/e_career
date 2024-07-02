<?php
$current_page = $_GET['go'] ?? '';
$user_logged_in = $_SESSION['nama_pegawai'] ?? $_SESSION['nama_guest'] ?? $_SESSION['username'];
?>

<nav class="sidenav shadow-right sidenav-light">
  <div class="sidenav-menu">
    <div class="nav accordion" id="accordionSidenav">
      <!-- Sidenav Menu Heading (Core)-->
      <div class="sidenav-menu-heading">Core</div>
      
      <a class="nav-link <?php if ($current_page === 'dashboard') echo 'active' ?>" href="index.php?go=dashboard">
        <div class="nav-link-icon"><i data-feather="activity"></i></div>
        Dashboard
      </a>

      <div class="sidenav-menu-heading">Alumni</div>

      <a class="nav-link <?php if ($current_page === 'profil') echo 'active' ?>" href="profil.php?go=profil">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Profil
      </a>

      <div class="sidenav-menu-heading">Lowongan</div>
      
      <a class="nav-link <?php if ($current_page === 'lowongan_pekerjaan') echo 'active' ?>" href="lowongan_pekerjaan.php?go=lowongan_pekerjaan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Lowongan Pekerjaan
      </a>
      
      <a class="nav-link <?php if ($current_page === 'lamaran_pekerjaan') echo 'active' ?>" href="lamaran_pekerjaan.php?go=lamaran_pekerjaan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Lamaran Saya
      </a>
      
      <div class="sidenav-menu-heading">Data Alumni</div>
      
      <a class="nav-link <?php if ($current_page === 'keahlian_alumni') echo 'active' ?>" href="keahlian_alumni.php?go=keahlian_alumni">
        <div class="nav-link-icon"><i data-feather="star"></i></div>
        Keahlian
      </a>
      
      <a class="nav-link <?php if ($current_page === 'prestasi_alumni') echo 'active' ?>" href="prestasi_alumni.php?go=prestasi_alumni">
        <div class="nav-link-icon"><i data-feather="star"></i></div>
        Prestasi
      </a>

      <div class="sidenav-menu-heading">Lainnya</div>
      
      <a class="nav-link" href="<?= base_url('logout.php') ?>">
        <div class="nav-link-icon"><i data-feather="log-out"></i></div>
        Keluar
      </a>

    </div>
  </div>
  <!-- Sidenav Footer-->
  <div class="sidenav-footer">
    <div class="sidenav-footer-content">
      <div class="sidenav-footer-subtitle">Anda masuk sebagai:</div>
      <div class="sidenav-footer-title"><?= ucwords($user_logged_in) ?></div>
    </div>
  </div>
</nav>