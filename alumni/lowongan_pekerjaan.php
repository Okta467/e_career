<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah alumni?
if (!isAccessAllowed('alumni')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Lowongan Pekerjaan" />
    <meta name="author" content="" />
    <title>Lowongan Pekerjaan - <?= SITE_NAME ?></title>
  </head>

  <body class="nav-fixed">
    <!--============================= TOPNAV =============================-->
    <?php include '_partials/topnav.php' ?>
    <!--//END TOPNAV -->
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <!--============================= SIDEBAR =============================-->
        <?php include '_partials/sidebar.php' ?>
        <!--//END SIDEBAR -->
      </div>
      <div id="layoutSidenav_content">
        <main>
          <!-- Main page content-->
          <div class="container-xl px-4 mt-5">

            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
              <div class="me-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Lowongan Pekerjaan</h1>
                <div class="small">
                  <span class="fw-500 text-primary"><?= date('D') ?></span>
                  &middot; <?= date('M d, Y') ?> &middot; <?= date('H:i') ?> WIB
                </div>
              </div>

              <!-- Date range picker example-->
              <div class="input-group input-group-joined border-0 shadow w-auto">
                <span class="input-group-text"><i data-feather="calendar"></i></span>
                <input class="form-control ps-0 pointer" id="litepickerRangePlugin" value="Tanggal: <?= date('d M Y') ?>" readonly />
              </div>

            </div>

            <?php
            $query_lowongan = mysqli_query($connection, 
              "SELECT
                a.id AS id_lowongan, a.nama_lowongan, a.penempatan, a.batas_bawah_gaji, a.batas_atas_gaji, a.tipe_gaji, a.keterangan_lowongan, a.created_at AS tgl_lowongan_diposting,
                b.id AS id_perusahaan, b.nama_perusahaan, b.alamat_perusahaan,
                c.id AS id_jenis_perusahaan, c.nama_jenis AS jenis_perusahaan,
                d.id AS id_jenis_pekerjaan, d.jenis_pekerjaan,
                f.id AS id_klasifikasi_pekerjaan, f.klasifikasi_pekerjaan
              FROM tbl_lowongan AS a
              INNER JOIN tbl_perusahaan AS b
                ON b.id = a.id_perusahaan
              LEFT JOIN tbl_jenis_perusahaan AS c
                ON c.id = b.id_jenis_perusahaan
              LEFT JOIN tbl_jenis_pekerjaan AS d
                ON d.id = a.id_jenis_pekerjaan
              LEFT JOIN tbl_klasifikasi_pekerjaan AS f
                ON f.id = a.id_klasifikasi_pekerjaan
              ORDER BY a.id DESC");

            $lowongan_pekerjaans = mysqli_fetch_all($query_lowongan, MYSQLI_ASSOC);

            $illusration = [
              '<img src="' . base_url_return('assets/img/illustrations/browser-stats.svg') . '" alt="..." style="width: 8rem">',
              '<img src="' . base_url_return('assets/img/illustrations/team-spirit.svg') . '" alt="..." style="width: 8rem">',
              '<img src="' . base_url_return('assets/img/illustrations/problem-solving.svg') . '" alt="..." style="width: 8rem">',
            ];
            ?>
            
            <!-- Main page content-->

            <?php if (!isset($lowongan_pekerjaans)): ?>

              <div class="card card-waves mb-4 mt-5">
                <div class="card-body p-5">
                  <div class="row align-items-center justify-content-between">
                    <div class="col">
                      <h2 class="text-primary">Oops! lowongan kerja saat ini tidak ada.</h2>
                      <p class="text-gray-700">Sembari menunggu lowongan baru, alumni bisa melengkapi berkas <a href="prestasi_alumni.php?go=prestasi_alumni">prestasi</a> dan <a href="keahlian_alumni.php?go=keahlian_alumni">keahlian.</a></p>
                    </div>
                    <div class="col d-none d-lg-block mt-xxl-n4"><img src="<?= base_url('assets/img/illustrations/at-work.svg') ?>" class="img-fluid px-xl-4 mt-xxl-n5"></div>
                  </div>
                </div>
              </div>

            <?php else: ?>
              
              <div class="row mt-5 mb-4">

                <?php foreach($lowongan_pekerjaans as $lowongan_pekerjaan): ?>

                  <?php
                  $rng = rand(0, 2);
                  
                  $batas_bawah_gaji = $lowongan_pekerjaan['batas_bawah_gaji'] ?? null;
                  $batas_atas_gaji = $lowongan_pekerjaan['batas_atas_gaji'] ?? null;
                  $tipe_gaji = isset($lowongan_pekerjaan['tipe_gaji']) ? 'per ' . substr($lowongan_pekerjaan['tipe_gaji'], 0, -2) : '';
                  ?>

                    <div class="col-xl-6 mb-4">
                      <!-- Dashboard example card 1-->
                      <a class="card lift h-100" href="lowongan_pekerjaan_detail.php?id_lowongan=<?= $lowongan_pekerjaan['id_lowongan'] ?>">
                        <div class="card-body d-flex justify-content-center flex-column">
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                              <i class="feather-xl text-primary mb-3" data-feather="package"></i>
                              
                              <h5><?= $lowongan_pekerjaan['nama_lowongan'] ?></h5>
                              <div><?= $lowongan_pekerjaan['nama_perusahaan'] ?></div>
                              
                              <div class="small mt-4">
                                <i class="me-3" data-feather="map-pin"></i>
                                <?= $lowongan_pekerjaan['penempatan'] ?>
                              </div>
                      
                              <div class="small mt-1">
                                <i class="me-3" data-feather="trending-up"></i>
                                <?php if (!$lowongan_pekerjaan['batas_bawah_gaji'] && !$lowongan_pekerjaan['batas_atas_gaji']): ?>

                                  Tidak ditampilkan

                                <?php elseif (!$lowongan_pekerjaan['batas_atas_gaji']): ?>

                                  <?= 'Rp' . number_format($batas_bawah_gaji, 0, ',', '.') . ' ' ?>
                                  <?= $tipe_gaji ?>

                                <?php else: ?>
                                  
                                  <?= 'Rp' . number_format($batas_bawah_gaji, 0, ',', '.') . ' - ' ?>
                                  <?= 'Rp' . number_format($batas_atas_gaji, 0, ',', '.') . ' ' ?>
                                  <?= $tipe_gaji ?>

                                <?php endif ?>
                              </div>
                      
                              <div class="small mt-1">
                                <i class="me-3" data-feather="clock"></i>
                                <?= $lowongan_pekerjaan['jenis_pekerjaan'] ?>
                              </div>
                      
                              <div class="small mt-1">
                                <i class="me-3" data-feather="briefcase"></i>
                                <?= $lowongan_pekerjaan['klasifikasi_pekerjaan'] ?>
                              </div>
                      
                              <div class="small mt-3">
                                <span class="text-muted">Diposting: </span>
                                <?= date('d M Y', strtotime($lowongan_pekerjaan['tgl_lowongan_diposting'])) ?>
                              </div>
                              
                            </div>
                            <?= $illusration[$rng] ?>
                          </div>
                        </div>
                      </a>
                    </div>
                  
                <?php endforeach ?>

              </div>

            <?php endif ?>
            
          </div>
        </main>
        
        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
    </div>
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>

  </body>

  <!-- PAGE SCRIPT -->
   <script>
    $(document).ready(function() {

    })
   </script>

  </html>

<?php endif ?>