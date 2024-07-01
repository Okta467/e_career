<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
  include_once 'lowongan_pekerjaan_dummy_text.php';

  $id_lowongan = $_GET['id_lowongan'] ?? null;

  if ($id_lowongan) {
    $stmt_lowongan = mysqli_stmt_init($connection);
    $query_lowongan = 
      "SELECT
        a.id AS id_lowongan, a.nama_lowongan, a.penempatan, a.batas_bawah_gaji, a.batas_atas_gaji, a.tipe_gaji, a.keterangan_lowongan,
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
      WHERE a.id=?";

    mysqli_stmt_prepare($stmt_lowongan, $query_lowongan);
    mysqli_stmt_bind_param($stmt_lowongan, 'i', $id_lowongan);
    mysqli_stmt_execute($stmt_lowongan);

    $result = mysqli_stmt_get_result($stmt_lowongan);
    $lowongan_pekerjaan = mysqli_fetch_assoc($result);
  }

  $form_action = $id_lowongan ? 'lowongan_pekerjaan_ubah.php' : 'lowongan_pekerjaan_tambah.php';

  $id_perusahaan            = $lowongan_pekerjaan['id_perusahaan'] ?? null;
  $nama_perusahaan          = $lowongan_pekerjaan['nama_perusahaan'] ?? null;
  $alamat_perusahaan        = $lowongan_pekerjaan['alamat_perusahaan'] ?? null;
  $nama_lowongan            = $lowongan_pekerjaan['nama_lowongan'] ?? null;
  $penempatan               = $lowongan_pekerjaan['penempatan'] ?? null;
  $id_klasifikasi_pekerjaan = $lowongan_pekerjaan['id_klasifikasi_pekerjaan'] ?? null;
  $id_jenis_pekerjaan       = $lowongan_pekerjaan['id_jenis_pekerjaan'] ?? null;
  $batas_bawah_gaji         = $lowongan_pekerjaan['batas_bawah_gaji'] ?? null;
  $batas_atas_gaji          = $lowongan_pekerjaan['batas_atas_gaji'] ?? null;
  $tipe_gaji                = $lowongan_pekerjaan['tipe_gaji'] ?? null;
  $keterangan_lowongan      = $lowongan_pekerjaan['keterangan_lowongan'] ?? DUMMY_KETERANGAN_LOWONGAN;
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
                      Lowongan Kerja Baru
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
          <div class="container-fluid px-4">
            <form action="<?= $form_action ?>" method="POST">
              <div class="row gx-4">
              
                <div class="col-lg-8">

                  <!-- Data Lowongan -->
                  <div class="card mb-4">
                    <div class="card-header">Data Lowongan</div>
                    <div class="card-body">

                      <input type="hidden" name="xid_lowongan" value="<?= $id_lowongan ?>">
                      
                      <div class="mb-3">
                        <label class="small mb-1" for="xid_perusahaan">Perusahaan <span class="text-danger">*</span></label>
                          <select name="xid_perusahaan" class="form-control select2" id="xid_perusahaan" required>
                            <option value="">-- Pilih --</option>
                            <?php $query_perusahaan = mysqli_query($connection, "SELECT * FROM tbl_perusahaan ORDER BY nama_perusahaan ASC") ?>
                            <?php while ($perusahaan = mysqli_fetch_assoc($query_perusahaan)): ?>

                              <option value="<?= $perusahaan['id'] ?>" <?php if ($perusahaan['id'] == $id_perusahaan) echo 'selected' ?>><?= $perusahaan['nama_perusahaan'] ?></option>
                              
                            <?php endwhile ?>
                          </select>
                      </div>

                  
                      <div class="row gx-3 mb-3">
                  
                        <div class="mb-3 col-md-6">
                          <label class="small mb-1" for="xnama_lowongan">Nama Lowongan <span class="text-danger">*</span></label>
                          <input type="text" name="xnama_lowongan" value="<?= $nama_lowongan ?>" class="form-control" id="xnama_lowongan" placeholder="Enter nama lowongan" required>
                        </div>
                  
                        <div class="mb-3 col-md-6">
                          <label class="small mb-1" for="xpenempatan">Penempatan <span class="text-danger">*</span></label>
                          <input type="text" name="xpenempatan" value="<?= $penempatan ?>" class="form-control" id="xpenempatan" placeholder="Enter penempatan" required>
                        </div>
                  
                      </div>
                      
                  
                      <div class="row gx-3 mb-3">
                  
                        <div class="mb-3 col-md-6">
                          <label class="small mb-1" for="xid_klasifikasi_pekerjaan">Klasifikasi Pekerjaan <span class="text-danger">*</span></label>
                          <select name="xid_klasifikasi_pekerjaan" class="form-control select2" id="xid_klasifikasi_pekerjaan" required>
                            <option value="">-- Pilih --</option>
                            <?php $query_klasifikasi_pekerjaan = mysqli_query($connection, "SELECT * FROM tbl_klasifikasi_pekerjaan ORDER BY klasifikasi_pekerjaan ASC") ?>
                            <?php while ($klasifikasi_pekerjaan = mysqli_fetch_assoc($query_klasifikasi_pekerjaan)): ?>

                              <option value="<?= $klasifikasi_pekerjaan['id'] ?>" <?php if ($klasifikasi_pekerjaan['id'] == $id_klasifikasi_pekerjaan) echo 'selected' ?>><?= $klasifikasi_pekerjaan['klasifikasi_pekerjaan'] ?></option>
                              
                            <?php endwhile ?>
                          </select>
                        </div>
                  
                        <div class="mb-3 col-md-6">
                          <label class="small mb-1" for="xid_jenis_pekerjaan">Jenis Pekerjaan <span class="text-danger">*</span></label>
                          <select name="xid_jenis_pekerjaan" class="form-control select2" id="xid_jenis_pekerjaan" required>
                            <option value="">-- Pilih --</option>
                            <?php $query_jenis_pekerjaan = mysqli_query($connection, "SELECT * FROM tbl_jenis_pekerjaan ORDER BY jenis_pekerjaan ASC") ?>
                            <?php while ($jenis_pekerjaan = mysqli_fetch_assoc($query_jenis_pekerjaan)): ?>

                              <option value="<?= $jenis_pekerjaan['id'] ?>" <?php if ($jenis_pekerjaan['id'] == $id_jenis_pekerjaan) echo 'selected' ?>><?= $jenis_pekerjaan['jenis_pekerjaan'] ?></option>
                              
                            <?php endwhile ?>
                          </select>
                        </div>
                  
                      </div>
                  
                  
                      <div class="row gx-3 mb-3">
                  
                        <div class="mb-3 col-md-4">
                          <label class="small mb-1" for="xbatas_bawah_gaji">Batas Bawah Gaji</label>
                          <input type="number" name="xbatas_bawah_gaji" value="<?= $batas_bawah_gaji ?>" min="0" class="form-control" id="xbatas_bawah_gaji" placeholder="Enter nama lowongan">
                        </div>
                  
                        <div class="mb-3 col-md-4">
                          <label class="small mb-1" for="xbatas_atas_gaji">
                            Batas Atas Gaji
                            <i data-feather="info" class="ms-2 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Cukup isi batas bawah gaji jika tidak ada rentang gaji, atau jangan isi keduanya jika tidak ingin menampilkan gaji."></i>
                          </label>
                          <input type="number" name="xbatas_atas_gaji" value="<?= $batas_atas_gaji ?>" min="0" class="form-control" id="xbatas_atas_gaji" placeholder="Enter penempatan">
                        </div>
                  
                        <div class="mb-3 col-md-4">
                          <label class="small mb-1" for="xtipe_gaji">
                            Tipe Gaji
                            <i data-feather="info" class="ms-2 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Tipe gaji tidak akan ditampilkan jika batas bawah dan atas gaji tidak diisi."></i>
                          </label>
                          <select name="xtipe_gaji" class="form-control select2" id="xtipe_gaji" required>
                            <option value="harian" <?php if ($tipe_gaji === 'harian') echo 'selected' ?>>Harian</option>
                            <option value="mingguan" <?php if ($tipe_gaji === 'mingguan') echo 'selected' ?>>Mingguan</option>
                            <option value="bulanan" <?php if (!$tipe_gaji || $tipe_gaji === 'bulanan') echo 'selected' ?>>Bulanan</option>
                            <option value="tahunan" <?php if ($tipe_gaji === 'tahunan') echo 'selected' ?>>Tahunan</option>
                          </select>
                        </div>
                  
                      </div>
                  
                    </div>
                  </div>
                  
                  <!-- Keterangan Lowongan -->
                  <div class="card card-header-actions mb-4 mb-lg-0">
                    <div class="card-header">
                      Keterangan Lowongan
                      <i class="text-muted" data-feather="info" data-bs-toggle="tooltip" data-bs-placement="left" title="Teks di dalam input hanya sebagai contoh saja."></i>
                    </div>
                    <div class="card-body">
                      <p class="small text-danger">Teks maksimal 5000 karakter!</p>
                      <textarea name="xketerangan_lowongan" id="lowonganEditor">
                      </textarea>
                    </div>
                  </div>

                </div>


                <div class="col-lg-4">
                  <div class="card">
                    <div class="card-header">
                      Publish
                    </div>
                    <div class="card-body text-center p-5">
                      
                      <?php if (isset($_GET['id_lowongan'])): ?>
                        
                      <img class="img-fluid mb-4" src="<?= base_url('assets/img/illustrations/statistics.svg') ?>" alt="" style="max-width: 16.25rem">
                      <h5><?= $nama_perusahaan ?></h5>
                      <p class="mb-4"><?= $alamat_perusahaan ?></p>
                      
                      <?php endif ?>
                      
                      <div class="d-grid">
                        <button class="fw-500 btn btn-primary" id="toggle_swal_submit" type="submit">Simpan Lowongan</button>
                      </div>
                    </div>
                  </div>
                </div>
              
              </div>
            </form>
          </div>
        </main>
        
        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
    </div>
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        var easyMDE = new EasyMDE({
          element: document.getElementById('lowonganEditor'),
          toolbar: ['bold', 'italic', 'heading', '|', 'quote', 'unordered-list', 'ordered-list', '|', 'link', 'preview', 'guide'],
        });


        const select2 = $('.select2');

        initSelect2(select2, {
          width: '100%',
          dropdownParent: 'body'
        });
        

        const formSubmitBtn = $('#toggle_swal_submit');
        const eventName = 'click';
        const formElement = formSubmitBtn.parents('div.container-fluid').find('form');
        // console.log(formElement)
        toggleSwalSubmit(formSubmitBtn, eventName, formElement);


        const keterangan_lowongan = `<?= "{$keterangan_lowongan}" ?>`;
        const sanitized_keterangan_lowongan = DOMPurify.sanitize(keterangan_lowongan, { USE_PROFILES: { html: true } });
        
        easyMDE.value(sanitized_keterangan_lowongan)
      });
    </script>

  </body>

  </html>

<?php endif ?>