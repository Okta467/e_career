<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')) :
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
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="user-plus" class="me-2"></i>Tambah Alumni</button>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                        <th>Ubah/<br>Hapus/<br>Detail</th>
                        <th>Nama/NISN</th>
                        <th class="text-center">JK</th>
                        <th>Kelas</th>
                        <th>No. Telepon</th>
                        <th>Email</th>
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
                          <div class="dropdown">
                            <button class="btn btn-sm btn-outline-blue dropdown-toggle" id="dropdownFadeIn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownFadeIn">

                              <button class="dropdown-item toggle_modal_ubah" type="button"
                                data-id_alumni="<?= $alumni['id_alumni'] ?>">
                                <i data-feather="edit" class="me-1"></i>
                                Ubah
                              </button>

                              <button class="dropdown-item text-danger toggle_swal_hapus" type="button"
                                data-id_alumni="<?= $alumni['id_alumni'] ?>"
                                data-nama_alumni="<?= $alumni['nama_alumni'] ?>">
                                <i data-feather="trash-2" class="me-1"></i>
                                Hapus
                              </button>

                              <div class="dropdown-divider"></div>
                              
                              <button class="dropdown-item toggle_modal_detail_alumni" type="button"
                                data-id_alumni="<?= $alumni['id_alumni'] ?>"
                                data-nama_alumni="<?= $alumni['nama_alumni'] ?>"
                                data-username="<?= $alumni['username'] ?>"
                                data-hak_akses="<?= $alumni['hak_akses'] ?>"
                                data-alamat="<?= $alumni['alamat'] ?>"
                                data-tmp_lahir="<?= $alumni['tmp_lahir'] ?>"
                                data-tgl_lahir="<?= $alumni['tgl_lahir'] ?>">
                                <i data-feather="list" class="me-1"></i>
                                Detail
                              </button>

                            </div>
                          </div>
                        </td>
                        <td>
                          <?= htmlspecialchars($alumni['nama_alumni']) ?>
                          <?= "<br><small class='text-muted'>({$alumni['nisn']})</small>" ?>
                        </td>
                        <td><div class="text-center"><?= ucfirst($alumni['jk']) ?></div></td>
                        <td><?= $alumni['nama_kelas'] ?></td>
                        <td><?= $alumni['no_telp'] ?></td>
                        <td><?= $alumni['email'] ?></td>
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
    
    <!--============================= MODAL DETAIL ALUMNI =============================-->
    <div class="modal fade" id="ModalDetailAlumni" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAlumni" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i data-feather="info" class="me-2"></i>Detail Alumni</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!--/.modal-detail-alumni -->
      
    <!--============================= MODAL INPUT ALUMNI =============================-->
    <div class="modal fade" id="ModalInputAlumni" tabindex="-1" role="dialog" aria-labelledby="ModalInputAlumniTitle" aria-hidden="true" data-focus="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputAlumniTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
    
              <input type="hidden" name="xid_alumni" id="xid_alumni" required>
              <input type="hidden" name="xid_pengguna" id="xid_pengguna" required>
    
              <div class="mb-3">
                <label class="small mb-1" for="xnisn">NISN (10 Digit) <span class="text-danger fw-bold">*</span></label>
                <input class="form-control xnisn" id="xnisn" type="text" name="xnisn" minlength="10" maxlength="10" placeholder="Enter nisn" required>
              </div>
    
              <div class="mb-3">
                <label class="small mb-1" for="xnama_alumni">Nama Alumni <span class="text-danger fw-bold">*</span></label>
                <input class="form-control" id="xnama_alumni" type="text" name="xnama_alumni" placeholder="Enter nama Alumni" required>
              </div>
    
              <div class="mb-3">
                <label class="small mb-1" for="xid_kelas">Kelas <span class="text-danger fw-bold">*</span></label>
                <select name="xid_kelas" class="form-control select2" id="xid_kelas" required>
                  <option value="">-- Pilih --</option>
                  <?php $query_kelas = mysqli_query($connection, "SELECT * FROM tbl_kelas ORDER BY nama_kelas ASC") ?>
                  <?php while ($kelas = mysqli_fetch_assoc($query_kelas)): ?>

                    <option value="<?= $kelas['id'] ?>"><?= $kelas['nama_kelas'] ?></option>

                  <?php endwhile ?>
                </select>
              </div>
    
              <div class="mb-3">
                <label class="small mb-1" for="xpassword">Password <span class="text-danger fw-bold">*</span></label>
                <div class="input-group input-group-joined mb-1">
                  <input class="form-control mb-1" id="xpassword" type="password" name="xpassword" placeholder="Enter password" autocomplete="new-password" required>
                  <button class="input-group-text" id="xpassword_toggle" type="button"><i class="fa-regular fa-eye"></i></button>
                </div>
                <small class="text-muted" id="xpassword_help"></small>
              </div>
    
    
              <div class="row gx-3">
    
                <div class="col-md-6">
                  <div class="form-check form-check-solid mb-3">
                    <input class="form-check-input" id="xjk_l" type="radio" name="xjk" value="l" checked required>
                    <label class="form-check-label" for="xjk_l">Laki-laki</label>
                  </div>
                </div>
    
                <div class="col-md-6">
                  <div class="form-check form-check-solid mb-3">
                    <input class="form-check-input" id="xjk_p" type="radio" name="xjk" value="p" required>
                    <label class="form-check-label" for="xjk_p">Perempuan</label>
                  </div>
                </div>
    
              </div>
    
    
              <div class="mb-3">
                <label class="small mb-1" for="xalamat">Alamat</label>
                <input class="form-control" id="xalamat" type="text" name="xalamat" placeholder="Enter alamat" required>
              </div>
    
    
              <div class="row gx-3">
    
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="small mb-1" for="xtmp_lahir">Tempat Lahir</label>
                    <input class="form-control" id="xtmp_lahir" type="text" name="xtmp_lahir" placeholder="Enter tempat lahir" required>
                  </div>
                </div>
    
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="small mb-1" for="xtgl_lahir">Tanggal Lahir</label>
                    <input class="form-control" id="xtgl_lahir" type="date" name="xtgl_lahir" required>
                  </div>
                </div>
    
              </div>
    
              
              <div class="mb-3">
                <label class="small mb-1" for="xno_telp">No. Telp</label>
                <input class="form-control" id="xno_telp" type="text" name="xno_telp" min="0" maxlength="16" placeholder="Enter no telp" required>
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xemail">Email <span class="text-danger fw-bold">*</span></label>
                <input class="form-control" id="xemail" type="email" name="xemail" aria-describedby="emailHelp" placeholder="Enter email address" required>
              </div>
    
            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Batal</button>
              <button class="btn btn-primary" type="submit" id="toggle_swal_submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-input-alumni -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>

    <!-- PAGE SCRIPT -->
    <script>
        let password = document.getElementById('xpassword');
        let passwordConfirm = document.getElementById('xpassword_confirm');
    
        let passwordToggle = document.getElementById('xpassword_toggle');
        let passwordConfirmToggle = document.getElementById('xpassword_confirm_toggle');
    
        let passwordHelp = document.getElementById('xpassword_help');
        let passwordConfirmHelp = document.getElementById('xpassword_confirm_help');
        
        passwordToggle.addEventListener('click', function() {
          initTogglePassword(password, passwordToggle);
        });
    </script>

    <script>
      $(document).ready(function() {

        const selectKelas = $('#xid_kelas');
        initSelect2(selectKelas, {
          width: '100%',
          dropdownParent: "#ModalInputAlumni .modal-content .modal-body"
        });

        $('.toggle_modal_detail_alumni').tooltip({
          title: 'Alamat, Hak Akses Akun, dan Tempat, Tanggal Lahir',
          delay: {
            show: 1000,
            hide: 100
          }
        });
      

        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputAlumni .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Alumni`);
          $('#ModalInputAlumni form').attr({action: 'alumni_tambah.php', method: 'post'});
          $('#ModalInputAlumni #xpassword').attr('required', true);
          $('#ModalInputAlumni #xpassword_help').html('');

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputAlumni').modal('show');
        });

        
        $('.toggle_modal_ubah').on('click', function() {
          const id_alumni   = $(this).data('id_alumni');
          const nama_alumni = $(this).data('nama_alumni');
          
          $('#ModalInputAlumni .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Alumni`);
          $('#ModalInputAlumni form').attr({action: 'alumni_ubah.php', method: 'post'});
          $('#ModalInputAlumni #xpassword').attr('required', false);
          $('#ModalInputAlumni #xpassword_help').html('Kosongkan jika tidak ingin ubah password.');
        
          $.ajax({
            url: 'get_alumni.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_alumni': id_alumni
            },
            success: function(data) {
              $('#ModalInputAlumni #xid_alumni').val(data[0].id_alumni);
              $('#ModalInputAlumni #xid_pengguna').val(data[0].id_pengguna);
              $('#ModalInputAlumni #xnisn').val(data[0].nisn);
              $('#ModalInputAlumni #xnama_alumni').val(data[0].nama_alumni);
              $('#ModalInputAlumni #xid_kelas').val(data[0].id_kelas).trigger('change');
              $(`#ModalInputAlumni input[name="xjk"][value="${data[0].jk}"]`).prop('checked', true)
              $('#ModalInputAlumni #xalamat').val(data[0].alamat);
              $('#ModalInputAlumni #xtmp_lahir').val(data[0].tmp_lahir);
              $('#ModalInputAlumni #xtgl_lahir').val(data[0].tgl_lahir);
              $('#ModalInputAlumni #xno_telp').val(data[0].no_telp);
              $('#ModalInputAlumni #xemail').val(data[0].email);
              
              $('#ModalInputAlumni').modal('show');
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
          
          $('#ModalInputAlumni #xid_alumni').val(id_alumni);
          $('#ModalInputAlumni #xnama_alumni').val(nama_alumni);
        
          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputAlumni').modal('show');
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
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_alumni    = $(this).data('id_alumni');
          const id_pengguna = $(this).data('id_pengguna');
          const nama_alumni  = $(this).data('nama_alumni');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `Hapus data alumni: <strong>${nama_alumni}?</strong>`,
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
                window.location = `alumni_hapus.php?xid_alumni=${id_alumni}&xid_pengguna=${id_pengguna}`;
              });
            }
          });
        });
        

        const formSubmitBtn = $('#toggle_swal_submit');
        const eventName = 'click';
        
        toggleSwalSubmit(formSubmitBtn, eventName);
        
      });
    </script>

  </body>

  </html>

<?php endif ?>