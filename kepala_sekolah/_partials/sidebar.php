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

      <div class="sidenav-menu-heading">Pengguna</div>
      
      <a class="nav-link <?php if ($current_page === 'profil') echo 'active' ?>" href="profil.php?go=profil">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Profil
      </a>
      
      <a class="nav-link <?php if ($current_page === 'alumni') echo 'active' ?>" href="alumni.php?go=alumni">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Alumni
      </a>
      
      <div class="sidenav-menu-heading">Lamaran Siswa</div>
      
      <a class="nav-link <?php if ($current_page === 'perusahaan') echo 'active' ?>" href="perusahaan.php?go=perusahaan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Perusahaan
      </a>
      
      <a class="nav-link <?php if ($current_page === 'lamaran_pekerjaan') echo 'active' ?>" href="lamaran_pekerjaan.php?go=lamaran_pekerjaan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Lamaran Alumni
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