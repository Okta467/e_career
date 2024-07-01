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

    <meta name="description" content="Data Lamaran Pekerjaan" />
    <meta name="author" content="" />
    <title>Lamaran Pekerjaan - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Lamaran Pekerjaan</h1>
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
                  <i data-feather="briefcase" class="me-2 mt-1"></i>
                  Data Lamaran Pekerjaan
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
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
                      <th>Aksi</th>
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
                        g.id AS id_lamaran_pekerjaan, g.status_lamaran, g.keterangan_lamaran,
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
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                            data-id_lamaran_pekerjaan="<?= $lamaran_pekerjaan['id_lamaran_pekerjaan'] ?>">
                            <i class="fa fa-pen-to-square"></i>
                          </button>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                            data-id_lamaran_pekerjaan="<?= $lamaran_pekerjaan['id_lamaran_pekerjaan'] ?>" 
                            data-nama_alumni="<?= $lamaran_pekerjaan['nama_alumni'] ?>"
                            data-nama_lowongan="<?= $lamaran_pekerjaan['nama_lowongan'] ?>">
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
    
    <!--============================= MODAL INPUT LAMARAN PEKERJAAN =============================-->
    <div class="modal fade" id="ModalInputLamaranPekerjaan" tabindex="-1" role="dialog" aria-labelledby="ModalInputLamaranPekerjaanTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputLamaranPekerjaanTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_lamaran_pekerjaan" name="xid_lamaran_pekerjaan">
            
              <div class="mb-3">
                <label class="small mb-1" for="xid_alumni">Alumni <span class="text-danger">*</span></label>
                <select name="xid_alumni" class="form-control select2" id="xid_alumni" required>
                  <option value="">-- Pilih --</option>
                  <?php
                  $query_alumni = mysqli_query($connection, 
                    "SELECT a.id AS id_alumni, a.nama_alumni, b.nama_kelas
                    FROM tbl_alumni AS a
                    LEFT JOIN tbl_kelas AS b
                      ON b.id = a.id_kelas
                    ORDER BY b.nama_kelas DESC, a.nama_alumni ASC");
                    
                  while ($alumni = mysqli_fetch_assoc($query_alumni)):
                  ?>

                    <option value="<?= $alumni['id_alumni'] ?>"><?= "({$alumni['nama_kelas']}) -- {$alumni['nama_alumni']}" ?></option>

                  <?php endwhile ?>
                </select>
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xid_perusahaan">Perusahaan <span class="text-danger">*</span></label>
                <select name="xid_perusahaan" class="form-control select2" id="xid_perusahaan" required>
                  <option value="">-- Pilih --</option>
                  <?php
                  $query_perusahaan = mysqli_query($connection, 
                    "SELECT a.id, a.nama_perusahaan
                    FROM tbl_perusahaan AS a
                    INNER JOIN tbl_lowongan AS b
                      ON a.id = b.id_perusahaan 
                    ORDER BY nama_perusahaan ASC");
                  
                  while ($perusahaan = mysqli_fetch_assoc($query_perusahaan)): ?>

                    <option value="<?= $perusahaan['id'] ?>"><?= $perusahaan['nama_perusahaan'] ?></option>

                  <?php endwhile ?>
                </select>
                <small class="text-muted">Perusahaan yang ditampilkan hanya yang memiliki lowongan pekerjaan.</small>
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xid_lowongan">Lowongan <span class="text-danger">*</span></label>
                <select name="xid_lowongan" class="form-control select2" id="xid_lowongan" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xstatus_lamaran">Status <span class="text-danger">*</span></label>
                <select name="xstatus_lamaran" class="form-control select2" id="xstatus_lamaran" required>
                  <option value="">-- Pilih --</option>
                  <option value="tidak_lolos">Tidak Lolos</option>
                  <option value="pemberkasan">Pemberkasan</option>
                  <option value="interview">Interview</option>
                  <option value="lolos">Lolos</option>
                  <option value="lainnya">Lainnya</option>
                </select>
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xketerangan_lamaran">Keterangan</label>
                <textarea name="xketerangan_lamaran" rows="4" class="form-control" id="xketerangan_lamaran" placeholder="Keterangan dari status ...."></textarea>
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Batal</button>
              <button class="btn btn-primary" id="toggle_swal_submit" type="submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-input-lamaran-pekerjaan -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputLamaranPekerjaan .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Lamaran Pekerjaan`);
          $('#ModalInputLamaranPekerjaan form').attr({action: 'lamaran_pekerjaan_tambah.php', method: 'post'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputLamaranPekerjaan').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const id_lamaran_pekerjaan   = $(this).data('id_lamaran_pekerjaan');
          const nama_lamaran_pekerjaan = $(this).data('nama_lamaran_pekerjaan');
          
          $('#ModalInputLamaranPekerjaan .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Lamaran Pekerjaan`);
          $('#ModalInputLamaranPekerjaan form').attr({action: 'lamaran_pekerjaan_ubah.php', method: 'post'});

          $.ajax({
            url: 'get_lamaran_pekerjaan.php',
            type: 'POST',
            data: {
              id_lamaran_pekerjaan: id_lamaran_pekerjaan
            },
            dataType: 'JSON',
            success: function(data) {
              $('#ModalInputLamaranPekerjaan #xid_lamaran_pekerjaan').val(data[0].id_lamaran_pekerjaan);
              $('#ModalInputLamaranPekerjaan #xid_alumni').val(data[0].id_alumni).trigger('change');
              $('#ModalInputLamaranPekerjaan #xid_perusahaan').val(data[0].id_perusahaan).trigger('change');
              $('#ModalInputLamaranPekerjaan #xid_lowongan').val(data[0].id_lowongan).trigger('change');
              $('#ModalInputLamaranPekerjaan #xstatus_lamaran').val(data[0].status_lamaran).trigger('change');
              $('#ModalInputLamaranPekerjaan #xketerangan_lamaran').val(data[0].keterangan_lamaran);
              
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalInputLamaranPekerjaan').modal('show');
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          });
        });


        $('#xid_perusahaan').on('change', function() {
          const id_perusahaan = $(this).val();

          $.ajax({
            url: 'get_lowongan_by_id_perusahaan.php',
            type: 'POST',
            data: {
              id_perusahaan: id_perusahaan,
            },
            dataType: 'JSON',
            success: function(data) {
              console.log(data)
              const lowonganSelect = $('#xid_lowongan');
              lowonganSelect.empty();
          
              // Append options to the select element
              data.forEach(function(item) {
                const option = new Option(item.nama_lowongan, item.id_lowongan);
                lowonganSelect.append(option);
              });
              
              // Initialize Select2
              initSelect2(lowonganSelect, {
                width: '100%',
                dropdownParent: "#ModalInputLamaranPekerjaan .modal-content .modal-body"
              });

            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_lamaran_pekerjaan = $(this).data('id_lamaran_pekerjaan');
          const nama_alumni = $(this).data('nama_alumni');
          const nama_lowongan = $(this).data('nama_lowongan');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `<div class="mb-1">Hapus data lamaran:</div><strong>${nama_alumni} (${nama_lowongan})?</strong>`,
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
                window.location = `lamaran_pekerjaan_hapus.php?xid_lamaran_pekerjaan=${id_lamaran_pekerjaan}`;
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