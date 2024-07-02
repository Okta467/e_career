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

    <meta name="description" content="Data Alumni" />
    <meta name="author" content="" />
    <title>Alumni - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Alumni</h1>
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
            
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="user" class="me-2 mt-1"></i>
                  Data Alumni
                </div>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama/NISN</th>
                      <th class="text-center">JK</th>
                      <th>Kelas</th>
                      <th>No. Telepon</th>
                      <th>Email</th>
                      <th>Detail Alumni</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $no = 1;
                    $query_alumni = mysqli_query($connection, 
                      "SELECT
                        a.id AS id_alumni, a.nisn, a.nama_alumni, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.no_telp, a.email,
                        b.id AS id_kelas, b.nama_kelas,
                        c.id AS id_wali_kelas, c.nama_guru AS nama_wali_kelas,
                        f.id AS id_pengguna, f.username, f.hak_akses
                      FROM tbl_alumni AS a
                      LEFT JOIN tbl_kelas AS b
                        ON b.id = a.id_kelas
                      LEFT JOIN tbl_guru AS c
                        ON c.id = b.id_wali_kelas
                      LEFT JOIN tbl_pengguna AS f
                        ON f.id = a.id_pengguna
                      ORDER BY a.id DESC");

                    while ($alumni = mysqli_fetch_assoc($query_alumni)):
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td>
                          <?= htmlspecialchars($alumni['nama_alumni']) ?>
                          <?= "<br><small class='text-muted'>({$alumni['nisn']})</small>" ?>
                        </td>
                        <td><div class="text-center"><?= ucfirst($alumni['jk']) ?></div></td>
                        <td><?= $alumni['nama_kelas'] ?></td>
                        <td><?= $alumni['no_telp'] ?></td>
                        <td><?= $alumni['email'] ?></td>
                        <td>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_detail_alumni" type="button"
                            data-id_alumni="<?= $alumni['id_alumni'] ?>"
                            data-nama_alumni="<?= $alumni['nama_alumni'] ?>"
                            data-username="<?= $alumni['username'] ?>"
                            data-hak_akses="<?= $alumni['hak_akses'] ?>"
                            data-alamat="<?= $alumni['alamat'] ?>"
                            data-tmp_lahir="<?= $alumni['tmp_lahir'] ?>"
                            data-tgl_lahir="<?= $alumni['tgl_lahir'] ?>">
                            <i class="fa fa-list"></i>
                          </button>
                        </td>
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
    
    <!--============================= MODAL DETAIL SISWA =============================-->
    <div class="modal fade" id="ModalDetailAlumni" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAlumni" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i data-feather="info" class="me-2"></i>Detail Alumni</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="p-4">
              <h4><i data-feather="star" class="me-2"></i>Alumni</h4>
              <p class="mb-0 xnama_alumni"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="key" class="me-2"></i>Username</h4>
              <p class="mb-0 xusername"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="key" class="me-2"></i>Hak Akses</h4>
              <p class="mb-0 xhak_akses"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="home" class="me-2"></i>Alamat</h4>
              <p class="mb-0 xalamat"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="gift" class="me-2"></i>Tempat, Tanggal Lahir</h4>
              <p class="mb-0 xtmp_tgl_lahir"></p>
            </div>
          
          </div>
          <div class="modal-footer">
            <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!--/.modal-detail-alumni -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>

    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {

        $('.toggle_modal_detail_alumni').tooltip({
          title: 'Alamat, Hak Akses Akun, dan Tempat, Tanggal Lahir',
          delay: {
            show: 1000,
            hide: 100
          }
        });

        
        $('.toggle_modal_detail_alumni').on('click', function() {
          const data = $(this).data();
        
          $('#ModalDetailAlumni .xnama_alumni').html(data.nama_alumni);
          $('#ModalDetailAlumni .xusername').html(data.username || 'Tidak ada (akun belum dibuat)');
          $('#ModalDetailAlumni .xhak_akses').html(data.hak_akses || 'Tidak ada (akun belum dibuat)');
          $('#ModalDetailAlumni .xalamat').html(data.alamat);
          $('#ModalDetailAlumni .xtmp_tgl_lahir').html(`${data.tmp_lahir}, ${moment(data.tgl_lahir).format("DD MMMM YYYY")}`);
        
          $('#ModalDetailAlumni').modal('show');
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>