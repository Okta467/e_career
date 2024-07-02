<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah kepala_sekolah?
if (!isAccessAllowed('kepala_sekolah')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Lamaran Alumni" />
    <meta name="author" content="" />
    <title>Lamaran Alumni - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Lamaran Alumni</h1>
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
            
            <!-- Tools Cetak Pengumuman -->
            <div class="card mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="settings" class="me-2 mt-1"></i>
                  Tools Cetak Laporan
                </div>
              </div>
              <div class="card-body">
                <div class="row gx-3">
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1" for="xdari_tanggal">Dari Tanggal</label>
                    <input class="form-control" id="xdari_tanggal" type="date" name="xdari_tanggal" required>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1" for="xsampai_tanggal">Sampai Tanggal</label>
                    <input class="form-control" id="xsampai_tanggal" type="date" name="xsampai_tanggal" required>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1 invisible" for="xcetak_pengumuman">Filter Button</label>
                    <button class="btn btn-primary w-100" id="xcetak_pengumuman" type="button">
                      <i data-feather="printer" class="me-1"></i>
                      Cetak
                    </button>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="briefcase" class="me-2 mt-1"></i>
                  Data Lamaran Alumni
                </div>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Alumni</th>
                      <th>Kelas</th>
                      <th>Perusahaan</th>
                      <th>Jenis</th>
                      <th>Nama Lowongan</th>
                      <th>Penempatan</th>
                      <th>Status</th>
                      <th>Tgl. Melamar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_lamaran_pekerjaan = mysqli_query($connection, 
                      "SELECT
                        a.id AS id_lowongan, a.nama_lowongan, a.penempatan, a.batas_bawah_gaji, a.batas_atas_gaji, a.tipe_gaji, a.keterangan_lowongan,
                        b.id AS id_perusahaan, b.nama_perusahaan, b.alamat_perusahaan,
                        c.id AS id_jenis_perusahaan, c.nama_jenis AS jenis_perusahaan,
                        d.id AS id_jenis_pekerjaan, d.jenis_pekerjaan,
                        f.id AS id_klasifikasi_pekerjaan, f.klasifikasi_pekerjaan,
                        g.id AS id_lamaran_pekerjaan, g.status_lamaran, g.keterangan_lamaran, g.created_at AS tgl_melamar,
                        h.id AS id_alumni, h.nisn, h.nama_alumni, h.jk, h.alamat AS alamat_alumni, h.tmp_lahir, h.tgl_lahir, h.no_telp AS no_telp_alumni, h.email AS email_alumni,
                        i.id AS id_kelas, i.nama_kelas
                      FROM tbl_lowongan AS a
                      INNER JOIN tbl_perusahaan AS b
                        ON b.id = a.id_perusahaan
                      LEFT JOIN tbl_jenis_perusahaan AS c
                        ON c.id = b.id_jenis_perusahaan
                      LEFT JOIN tbl_jenis_pekerjaan AS d
                        ON d.id = a.id_jenis_pekerjaan
                      LEFT JOIN tbl_klasifikasi_pekerjaan AS f
                        ON f.id = a.id_klasifikasi_pekerjaan
                      INNER JOIN tbl_lamaran_pekerjaan AS g
                        ON a.id = g.id_lowongan
                      INNER JOIN tbl_alumni AS h
                        ON h.id = g.id_alumni
                      LEFT JOIN tbl_kelas AS i
                        ON i.id = h.id_kelas
                      ORDER BY g.id DESC");

                    while ($lamaran_pekerjaan = mysqli_fetch_assoc($query_lamaran_pekerjaan)):
                      $status_lamaran = $lamaran_pekerjaan['status_lamaran'];
                      $formatted_status_lamaran = ucwords(str_replace('_', ' ', $status_lamaran));
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td>
                          <?= htmlspecialchars($lamaran_pekerjaan['nama_alumni']) ?>
                          <?= "<br><small class='text-muted'>({$lamaran_pekerjaan['nisn']})</small>" ?>
                        </td>
                        <td><?= $lamaran_pekerjaan['nama_kelas'] ?></td>
                        <td><?= $lamaran_pekerjaan['nama_perusahaan'] ?></td>
                        <td><?= $lamaran_pekerjaan['jenis_pekerjaan'] ?></td>
                        <td><?= $lamaran_pekerjaan['nama_lowongan'] ?></td>
                        <td><?= $lamaran_pekerjaan['penempatan'] ?></td>
                        <td>
                          
                          <?php if ($status_lamaran === 'tidak_lolos') : ?>
                            
                            <span class="badge bg-red-soft text-red"><?= $formatted_status_lamaran ?></span>
                            
                          <?php elseif ($status_lamaran === 'pemberkasan') : ?>
                            
                            <span class="badge bg-purple-soft text-purple"><?= $formatted_status_lamaran ?></span>
                            
                          <?php elseif ($status_lamaran === 'interview'): ?>
                            
                            <span class="badge bg-blue-soft text-blue"><?= $formatted_status_lamaran ?></span>
  
                          <?php elseif ($status_lamaran === 'lolos'): ?>
                            
                            <span class="badge bg-green-soft text-green"><?= $formatted_status_lamaran ?></span>
                          
                          <?php else: ?>

                            <span class="badge bg-secondary-dark text-dark"><?= $formatted_status_lamaran ?></span>
                            
                          <?php endif ?>
                          
                        </td>
                        <td><?= date('m-d-Y', strtotime($lamaran_pekerjaan['tgl_melamar'])) ?></td>
                      </tr>
                        
                    <?php endwhile ?>
                  </tbody>
                </table>
              </div>
            </div>
            
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
        $('#xcetak_pengumuman').on('click', function() {
          const dari_tanggal = $('#xdari_tanggal').val();
          const sampai_tanggal = $('#xsampai_tanggal').val();
          
          const url = `laporan_lamaran_pekerjaan.php?dari_tanggal=${dari_tanggal}&sampai_tanggal=${sampai_tanggal}`;
          
          printExternal(url);
        });
      });
    </script>

  </body>

  </html>

<?php endif ?>