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
      
      <a class="nav-link <?php if ($current_page === 'pengguna') echo 'active' ?>" href="pengguna.php?go=pengguna">
        <div class="nav-link-icon"><i data-feather="users"></i></div>
        Pengguna
      </a>
      
      <div class="sidenav-menu-heading">Perusahaan</div>

      <?php
      if (in_array($current_page, ['perusahaan', 'jenis_perusahaan'])) {
        $active_nav_container_perusahaan = 'active';
        $show_nav_menu_perusahaan = 'show';
      }
      ?>

      <a class="nav-link collapsed <?= $active_nav_container_perusahaan ?? '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapsePerusahaan" aria-expanded="false" aria-controls="collapsePerusahaan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Perusahaan
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse <?= $show_nav_menu_perusahaan ?? '' ?>" id="collapsePerusahaan" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
          <a class="nav-link <?php if ($current_page === 'perusahaan') echo 'active' ?>" href="perusahaan.php?go=perusahaan">
            Data Perusahaan
          </a>
          <a class="nav-link <?php if ($current_page === 'jenis_perusahaan') echo 'active' ?>" href="jenis_perusahaan.php?go=jenis_perusahaan">
            Jenis Perusahaan
          </a>
        </nav>
      </div>

      <?php
      if (in_array($current_page, ['lowongan_pekerjaan', 'jenis_pekerjaan', 'klasifikasi_pekerjaan'])) {
        $active_nav_container_lowongan = 'active';
        $show_nav_menu_lowongan = 'show';
      }
      ?>

      <a class="nav-link collapsed <?= $active_nav_container_lowongan ?? '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLowongan" aria-expanded="false" aria-controls="collapseLowongan">
        <div class="nav-link-icon"><i data-feather="tool"></i></div>
        Lowongan
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse <?= $show_nav_menu_lowongan ?? '' ?>" id="collapseLowongan" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
          <a class="nav-link <?php if ($current_page === 'lowongan_pekerjaan') echo 'active' ?>" href="lowongan_pekerjaan.php?go=lowongan_pekerjaan">
            Data Lowongan
          </a>
          <a class="nav-link <?php if ($current_page === 'jenis_pekerjaan') echo 'active' ?>" href="jenis_pekerjaan.php?go=jenis_pekerjaan">
            Jenis Pekerjaan
          </a>
          <a class="nav-link <?php if ($current_page === 'klasifikasi_pekerjaan') echo 'active' ?>" href="klasifikasi_pekerjaan.php?go=klasifikasi_pekerjaan">
            Klasifikasi Pekerjaan
          </a>
        </nav>
      </div>
      
      <div class="sidenav-menu-heading">Alumni</div>
      
      <a class="nav-link <?php if ($current_page === 'alumni') echo 'active' ?>" href="alumni.php?go=alumni">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Alumni
      </a>
      
      <?php
      if (in_array($current_page, ['lamaran_pekerjaan', 'prestasi_alumni', 'keahlian_alumni'])) {
        $active_nav_container_lamaran = 'active';
        $show_nav_menu_lamaran = 'show';
      }
      ?>
      
      <a class="nav-link collapsed <?= $active_nav_container_lamaran ?? '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseLamaran" aria-expanded="false" aria-controls="collapseLamaran">
        <div class="nav-link-icon"><i data-feather="star"></i></div>
        Lamaran Pekerjaan
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse <?= $show_nav_menu_lamaran ?? '' ?>" id="collapseLamaran" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
          <a class="nav-link <?php if ($current_page === 'lamaran_pekerjaan') echo 'active' ?>" href="lamaran_pekerjaan.php?go=lamaran_pekerjaan">
            Data Lamaran
          </a>
          <a class="nav-link <?php if ($current_page === 'prestasi_alumni') echo 'active' ?>" href="prestasi_alumni.php?go=prestasi_alumni">
            Prestasi
          </a>
          <a class="nav-link <?php if ($current_page === 'keahlian_alumni') echo 'active' ?>" href="keahlian_alumni.php?go=keahlian_alumni">
            Keahlian
          </a>
        </nav>
      </div>
      
      <div class="sidenav-menu-heading">Guru</div>
      
      <a class="nav-link <?php if ($current_page === 'guru') echo 'active' ?>" href="guru.php?go=guru">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Guru
      </a>
      
      <?php
      if (in_array($current_page, ['jabatan', 'pangkat_golongan', 'pendidikan', 'jurusan_pendidikan', 'kelas'])) {
        $active_nav_container_detail_guru = 'active';
        $show_nav_menu_detail_guru = 'show';
      }
      ?>
      
      <a class="nav-link collapsed <?= $active_nav_container_detail_guru ?? '' ?>" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDetailGuru" aria-expanded="false" aria-controls="collapseDetailGuru">
        <div class="nav-link-icon"><i data-feather="book"></i></div>
        Detail Guru
        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
      <div class="collapse <?= $show_nav_menu_detail_guru ?? '' ?>" id="collapseDetailGuru" data-bs-parent="#accordionSidenav">
        <nav class="sidenav-menu-nested nav">
          <a class="nav-link <?php if ($current_page === 'jabatan') echo 'active' ?>" href="jabatan.php?go=jabatan">
            Jabatan
          </a>
          <a class="nav-link <?php if ($current_page === 'pangkat_golongan') echo 'active' ?>" href="pangkat_golongan.php?go=pangkat_golongan">
            Pangkat / Golongan
          </a>
          <a class="nav-link <?php if ($current_page === 'pendidikan') echo 'active' ?>" href="pendidikan.php?go=pendidikan">
            Pendidikan
          </a>
          <a class="nav-link <?php if ($current_page === 'jurusan_pendidikan') echo 'active' ?>" href="jurusan_pendidikan.php?go=jurusan_pendidikan">
            Jurusan
          </a>
          <a class="nav-link <?php if ($current_page === 'kelas') echo 'active' ?>" href="kelas.php?go=kelas">
            Kelas
          </a>
        </nav>
      </div>
      
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