<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah alumni?
if (!isAccessAllowed('alumni')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';

  $id_lowongan = $_GET['id_lowongan'] ?? null;

  if (!$id_lowongan) {
    $_SESSION['msg'] = 'error-other';
    echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
    return;
  }
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
          <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-fluid px-4">
              <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                  <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                      <div class="page-header-icon"><i data-feather="file-plus"></i></div>
                      Detail Lowongan Kerja
                    </h1>
                  </div>
                  <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-light text-primary" href="lowongan_pekerjaan.php?go=lowongan_pekerjaan">
                      <i class="me-1" data-feather="arrow-left"></i>
                      Kembali ke Lowongan
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </header>
          <!-- Main page content-->
          <div class="container-xl px-4 mt-5">

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
              WHERE a.id = {$id_lowongan}");

            $lowongan_pekerjaan = mysqli_fetch_assoc($query_lowongan);
            ?>
            
            <!-- Main page content-->

            <?php if (!isset($lowongan_pekerjaan)): ?>
              
              <?php
              $_SESSION['msg'] = 'Lowongan tidak ada!';
              echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
              return;
              ?>

            <?php else: ?>

                <?php
                $rng = rand(0, 2);
                
                $batas_bawah_gaji = $lowongan_pekerjaan['batas_bawah_gaji'] ?? null;
                $batas_atas_gaji = $lowongan_pekerjaan['batas_atas_gaji'] ?? null;
                $tipe_gaji = isset($lowongan_pekerjaan['tipe_gaji']) ? 'per ' . substr($lowongan_pekerjaan['tipe_gaji'], 0, -2) : '';
                ?>
                
                <div class="card card-waves mb-4 mt-5 px-0">
                  <div class="card-body p-5">
                    <div class="row justify-content-between">
                      <div class="col-lg-4">
                        <img class="img-fluid mb-4" src="<?= base_url('assets/img/illustrations/statistics.svg') ?>" alt="" style="max-width: 16.25rem">
                        
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
                
                        <button type="button" class="btn btn-primary p-2 my-4" id="toggle_swal_confirm">
                          Lamar Pekerjaan
                          <i class="ms-1" data-feather="arrow-right"></i>
                        </button>
                
                      </div>
                      <div class="col-lg-8">
                        <div id="keterangan_lowongan">
                        </div>
                      </div>
                
                    </div>
                  </div>
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
      const keterangan_lowongan = `<?= $lowongan_pekerjaan['keterangan_lowongan'] ?>`;
      const sanitized_keterangan_lowongan = DOMPurify.sanitize(keterangan_lowongan, { USE_PROFILES: { html: true } });
      const parsed_keterangan_lowongan = marked.parse(sanitized_keterangan_lowongan);

      $('#keterangan_lowongan').html(parsed_keterangan_lowongan);
        
      
      const formSubmitBtn = $('#toggle_swal_submit');
      const eventName = 'click';
      const formElement = formSubmitBtn.parents('div.container-fluid').find('form');
      // console.log(formElement)
      toggleSwalSubmit(formSubmitBtn, eventName, formElement);
      
      $('#toggle_swal_confirm').on('click', function() {
        const id_lowongan = '<?= $id_lowongan ?>';
        
        Swal.fire({
          title: "Konfirmasi Tindakan?",
          text: "Harap perhatikan kembali sebelum konfirmasi.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, konfirmasi!"
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: "Tindakan Dikonfirmasi!",
              text: "Halaman akan di-reload untuk memproses.",
              icon: "success",
              timer: 3000
            }).then(() => {
              window.location = `lowongan_pekerjaan_lamar.php?id_lowongan=${id_lowongan}`;
            });
          }
        });
      })
    })
   </script>

  </html>

<?php endif ?>