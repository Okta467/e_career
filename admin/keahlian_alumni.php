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

    <meta name="description" content="Data Keahlian Alumni" />
    <meta name="author" content="" />
    <title>Keahlian Alumni - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Keahlian Alumni</h1>
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
                  <i data-feather="star" class="me-2 mt-1"></i>
                  Data Keahlian Alumni
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Alumni</th>
                      <th>Keahlian Alumni</th>
                      <th>Berkas</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_keahlian_alumni = mysqli_query($connection, 
                      "SELECT
                        d.id AS id_keahlian_alumni, d.nama_keahlian, d.file_keahlian,
                        a.id AS id_alumni, a.nisn, a.nama_alumni, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.no_telp, a.email,
                        b.id AS id_kelas, b.nama_kelas,
                        c.id AS id_wali_kelas, c.nama_guru AS nama_wali_kelas,
                        f.id AS id_pengguna, f.username, f.hak_akses
                      FROM tbl_keahlian_alumni AS d
                      INNER JOIN tbl_alumni AS a
                        ON a.id = d.id_alumni
                      LEFT JOIN tbl_kelas AS b
                        ON b.id = a.id_kelas
                      LEFT JOIN tbl_guru AS c
                        ON c.id = b.id_wali_kelas
                      LEFT JOIN tbl_pengguna AS f
                        ON f.id = a.id_pengguna
                      ORDER BY d.id DESC");

                    while ($keahlian_alumni = mysqli_fetch_assoc($query_keahlian_alumni)):
                      $path_file_keahlian_alumni = base_url_return('assets/uploads/file_keahlian_alumni/');
                      $file_keahlian = $keahlian_alumni['file_keahlian'] ?? null;
                      $link_file_keahlian = $path_file_keahlian_alumni . $file_keahlian;
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td>
                          <?= htmlspecialchars($keahlian_alumni['nama_alumni']) ?>
                          <?= "<br><small class='text-muted'>({$keahlian_alumni['nisn']})</small>" ?>
                        </td>
                        <td><?= $keahlian_alumni['nama_keahlian'] ?></td>
                        <td>
                          <?php if ($file_keahlian): ?>

                            <a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="<?= $link_file_keahlian ?>" target="_blank">
                              <i data-feather="eye" class="me-1"></i>Preview
                            </a>

                            <a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="<?= $link_file_keahlian ?>" download>
                              <i data-feather="download-cloud" class="me-1"></i>Download
                            </a>
                            
                          <?php else: ?>
                            
                            <small class="text-muted">Tidak ada</small>
                            
                          <?php endif ?>
                        </td>
                        <td>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                            data-id_keahlian_alumni="<?= $keahlian_alumni['id_keahlian_alumni'] ?>" 
                            data-nama_keahlian="<?= $keahlian_alumni['nama_keahlian'] ?>"
                            data-file_keahlian="<?= $keahlian_alumni['file_keahlian'] ?>">
                            <i class="fa fa-pen-to-square"></i>
                          </button>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                            data-id_keahlian_alumni="<?= $keahlian_alumni['id_keahlian_alumni'] ?>" 
                            data-id_alumni="<?= $keahlian_alumni['id_alumni'] ?>" 
                            data-nama_keahlian="<?= $keahlian_alumni['nama_keahlian'] ?>">
                            <i class="fa fa-trash-can"></i>
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
    
    <!--============================= MODAL INPUT KEAHLIAN ALUMNI =============================-->
    <div class="modal fade" id="ModalInputKeahlianAlumni" tabindex="-1" role="dialog" aria-labelledby="ModalInputKeahlianAlumniTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputKeahlianAlumniTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_keahlian_alumni" name="xid_keahlian_alumni">
              <input type="hidden" id="xfile_keahlian_old" name="xfile_keahlian_old">
              
              <div class="mb-3">
                <label class="small mb-1" for="xid_alumni">Alumni <span class="text-danger fw-bold">*</span></label>
                <select name="xid_alumni" class="form-control select2" id="xid_alumni" required>
                  <option value="">-- Pilih --</option>
                  <?php $query_alumni = mysqli_query($connection, "SELECT * FROM tbl_alumni ORDER BY nama_alumni ASC") ?>
                  <?php while ($keahlian_alumni = mysqli_fetch_assoc($query_alumni)): ?>
          
                    <option value="<?= $keahlian_alumni['id'] ?>"><?= $keahlian_alumni['nama_alumni'] ?></option>
          
                  <?php endwhile ?>
                </select>
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xnama_keahlian">Nama Keahlian <span class="text-danger fw-bold">*</span></label>
                <input type="text" name="xnama_keahlian" class="form-control" id="xnama_keahlian" placeholder="Enter nama keahlian_alumni" required />
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xfile_keahlian">File <span class="text-danger fw-bold">*</span></label>
                <input type="file" name="xfile_keahlian" class="form-control dropify xfile_keahlian" id="xfile_keahlian" required
                  data-height="100"
                  data-max-file-size="200K"
                  data-allowed-file-extensions="pdf">
                <div class="d-flex flex-column">
                  <small class="text-muted mt-1" id="xfile_keahlian_help">*) File <span class="text-danger">.pdf</span> dengan maks. <span class="text-danger">200KB</span></small>
                  <small class="my-2 mb-4" id="xfile_keahlian_help2">Jangan unggah jika tidak ingin mengubah file keahlian alumni!</small>
                </div>
                <div class="small" id="xfile_keahlian_old_container">
                  File saat ini:
                  <a class="btn btn-link p-0" id="xfile_keahlian_old_preview" href="#" target="_blank">Preview</a>
                  <a class="btn btn-link p-0" id="xfile_keahlian_old_download" href="#" download>Download</a>
                </div>
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
    <!--/.modal-input-keahlian-alumni -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        
        $('.dropify').dropify({
          messages: {
            'default': 'Drag and drop a file here or click',
            'replace': 'Drag and drop or click to replace',
            'remove':  'Remove',
            'error':   'Ooops, something wrong happended.'
          },
          error: {
            'fileSize': 'Ukuran berkas maksimal ({{ value }}).',
            'minWidth': 'The image width is too small ({{ value }}}px min).',
            'maxWidth': 'The image width is too big ({{ value }}}px max).',
            'minHeight': 'The image height is too small ({{ value }}}px min).',
            'maxHeight': 'The image height is too big ({{ value }}px max).',
            'imageFormat': 'The image format is not allowed ({{ value }} only).',
            'fileExtension': 'Ekstensi file hanya boleh ({{ value }}).'
          }
        });


        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputKeahlianAlumni .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Keahlian Alumni`);
          $('#ModalInputKeahlianAlumni form').attr({action: 'keahlian_alumni_tambah.php', method: 'post', enctype: 'multipart/form-data'});
          
          $('#ModalInputKeahlianAlumni #xfile_keahlian').prop('required', true);
          $('#ModalInputKeahlianAlumni #xfile_keahlian_required_label').show();

          $('#ModalInputKeahlianAlumni #xfile_keahlian_old_container').hide();
          $('#ModalInputKeahlianAlumni #xfile_keahlian_help2').hide();

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputKeahlianAlumni').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const id_keahlian_alumni = $(this).data('id_keahlian_alumni');
          
          $('#ModalInputKeahlianAlumni .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Keahlian Alumni`);
          $('#ModalInputKeahlianAlumni form').attr({action: 'keahlian_alumni_ubah.php', method: 'post', enctype: 'multipart/form-data'});

          $.ajax({
            url: 'get_keahlian_alumni.php',
            type: 'POST',
            data: {
              id_keahlian_alumni: id_keahlian_alumni
            },
            dataType: 'JSON',
            success: function(data) {
            console.log(data)
              $('#ModalInputKeahlianAlumni #xid_keahlian_alumni').val(data.id_keahlian_alumni);
              $('#ModalInputKeahlianAlumni #xid_alumni').val(data.id_alumni).trigger('change');
              $('#ModalInputKeahlianAlumni #xnama_keahlian').val(data.nama_keahlian);
              
              const file_keahlian_old_path = "<?= base_url_return('assets/uploads/file_keahlian_alumni/') ?>";
              const file_keahlian_old = file_keahlian_old_path + data.file_keahlian;
              
              $('#ModalInputKeahlianAlumni #xfile_keahlian_old').val(data.file_keahlian);
              $('#ModalInputKeahlianAlumni #xfile_keahlian_old_preview').attr('href', file_keahlian_old);
              $('#ModalInputKeahlianAlumni #xfile_keahlian_old_download').attr('href', file_keahlian_old);
              $('#ModalInputKeahlianAlumni #xfile_keahlian_help2').show();
              
              $('#ModalInputKeahlianAlumni #xfile_keahlian').prop('required', false);
              $('#ModalInputKeahlianAlumni #xfile_keahlian_required_label').hide();
              
              !data.file_keahlian
                ? $('#ModalInputKeahlianAlumni #xfile_keahlian_old_container').hide()
                : $('#ModalInputKeahlianAlumni #xfile_keahlian_old_container').show();
    
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalInputKeahlianAlumni').modal('show');
            },
            error: function(requrest, statut, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          });
        });
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_keahlian_alumni = $(this).data('id_keahlian_alumni');
          const nama_keahlian     = $(this).data('nama_keahlian');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `Hapus data alumni: <strong>${nama_keahlian}?</strong>`,
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
                window.location = `keahlian_alumni_hapus.php?xid_keahlian_alumni=${id_keahlian_alumni}`;
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