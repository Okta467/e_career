<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah perusahaan?
if (!isAccessAllowed('perusahaan')) :
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
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Alumni</th>
                      <th>Kelas</th>
                      <th>Prestasi</th>
                      <th>Keahlian</th>
                      <th>Nama Lowongan</th>
                      <th>Jenis</th>
                      <th>Penempatan</th>
                      <th>Status</th>
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
                        i.id AS id_kelas, i.nama_kelas,
                        IFNULL(j.jml_file_prestasi, 0) AS jml_file_prestasi,
                        IFNULL(k.jml_file_keahlian, 0) AS jml_file_keahlian
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
                      LEFT JOIN
                      (
                        SELECT id_alumni, COUNT(id) jml_file_prestasi 
                        FROM tbl_prestasi_alumni 
                        GROUP BY id_alumni
                      ) AS j
                        ON h.id = j.id_alumni
                      LEFT JOIN
                      (
                        SELECT id_alumni, COUNT(id) jml_file_keahlian
                        FROM tbl_keahlian_alumni 
                        GROUP BY id_alumni
                      ) AS k
                        ON h.id = k.id_alumni
                      WHERE b.id = {$_SESSION['id_perusahaan']}
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
                        <td>
                          <?php if (!$lamaran_pekerjaan['jml_file_prestasi']): ?>

                            <small class="text-muted">Tidak ada</small>

                          <?php else: ?>
                          
                            <button type="button" class="btn btn-xs rounded-pill btn-outline-primary toggle_daftar_prestasi_alumni" data-id_alumni="<?= $lamaran_pekerjaan['id_alumni'] ?>">
                              <i data-feather="list" class="me-1"></i>
                              Daftar
                              <span class="btn btn-sm rounded-pill btn-outline-primary py-0 px-2 ms-1"><?= $lamaran_pekerjaan['jml_file_prestasi'] ?></button>
                            </button>
                          
                          <?php endif ?>
                        </td>
                        <td>
                          <?php if (!$lamaran_pekerjaan['jml_file_keahlian']): ?>

                            <small class="text-muted">Tidak ada</small>

                          <?php else: ?>
                          
                            <button type="button" class="btn btn-xs rounded-pill btn-outline-primary toggle_daftar_keahlian_alumni" data-id_alumni="<?= $lamaran_pekerjaan['id_alumni'] ?>">
                              <i data-feather="list" class="me-1"></i>
                              Daftar
                              <span class="btn btn-sm rounded-pill btn-outline-primary py-0 px-2 ms-1"><?= $lamaran_pekerjaan['jml_file_keahlian'] ?></button>
                            </button>
                          
                          <?php endif ?>
                        </td>
                        <td><?= $lamaran_pekerjaan['nama_lowongan'] ?></td>
                        <td><?= $lamaran_pekerjaan['jenis_pekerjaan'] ?></td>
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
                        <td>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                            data-id_lamaran_pekerjaan="<?= $lamaran_pekerjaan['id_lamaran_pekerjaan'] ?>">
                            <i class="fa fa-pen-to-square"></i>
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
    
    <!--============================= MODAL DAFTAR FILE SISWA =============================-->
    <div class="modal fade" id="ModalDaftarFileAlumni" tabindex="-1" role="dialog" aria-labelledby="ModalDaftarFileAlumniTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalDaftarFileAlumniTitle"><i data-feather="book" class="me-2 mt-1"></i>Daftar Jurusan</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <table class="table table-striped" id="table_daftar_file_alumni">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Alumni</th>
                    <th>Nama</th>
                    <th>File</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Tutup</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-daftar-file-alumni -->
    
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
                <label class="small mb-1" for="xid_alumni">Alumni</label>
                <input type="text" name="xid_alumni" class="form-control" id="xid_alumni" disabled />
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xid_perusahaan">Perusahaan</label>
                <input type="text" name="xid_perusahaan" class="form-control" id="xid_perusahaan" disabled />
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xid_lowongan">Lowongan</label>
                <input type="text" name="xid_lowongan" class="form-control" id="xid_lowongan" disabled />
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
        
        let tableDaftarFileAlumni = document.getElementById("table_daftar_file_alumni");

        if (tableDaftarFileAlumni) {
          var datatableDaftarFileAlumni = new simpleDatatables.DataTable(tableDaftarFileAlumni, {
            fixedHeader: true,
            pageLength: 5,
            lengthMenu: [
              [3, 5, 10, 25, 50, 100],
              [3, 5, 10, 25, 50, 100],
            ]
          });
        }

        const selectModalInputLamaranPekerjaan = $('#ModalInputLamaranPekerjaan .select2');

        initSelect2(selectModalInputLamaranPekerjaan, {
          width: '100%',
          dropdownParent: '#ModalInputLamaranPekerjaan .modal-content .modal-body'
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

              $('#ModalInputLamaranPekerjaan #xid_alumni')
                .val(data[0].nama_alumni)
                .attr('id', data[0].id_alumni)

              $('#ModalInputLamaranPekerjaan #xid_perusahaan')
                .val(data[0].nama_perusahaan)
                .attr('id', data[0].id_perusahaan)

              $('#ModalInputLamaranPekerjaan #xid_lowongan')
                .val(data[0].nama_lowongan)
                .attr('id', data[0].id_lowongan)

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

        
        $('.toggle_daftar_prestasi_alumni').on('click', function() {
          const id_alumni = $(this).data('id_alumni');
          
          $('#ModalDaftarFileAlumni .modal-title').html(`<i data-feather="star" class="me-2 mt-1"></i>Daftar Prestasi Alumni`);
        
          $.ajax({
            url: 'get_prestasi_alumni_by_id_alumni.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_alumni': id_alumni
            },
            success: function(data) {
              // add datatables row
              let i = 1;
              let rowsData = [];
              
              for (key in data) {
                let filePrestasi = data[key]['file_prestasi'];
        
                if (!filePrestasi) {
                  filePrestasiHtml = `<small class="text-muted">Tidak ada</small>`;
                } else {
                  filePrestasiPath = "<?= base_url_return('assets/uploads/file_prestasi_alumni/') ?>" + filePrestasi;
                  
                  // Preview button
                  filePrestasiHtml = 
                    `<a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="${filePrestasiPath}" target="_blank">
                      <i data-feather="eye" class="me-1"></i>Preview
                    </a>`;
                  
                  // Download button
                  filePrestasiHtml +=
                    `<a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="${filePrestasiPath}" download>
                      <i data-feather="download-cloud" class="me-1"></i>Download
                    </a>`;
                }
                
                rowsData.push([i++, data[key]['nama_alumni'], data[key]['nama_prestasi'], filePrestasiHtml]);
              }
        
              datatableDaftarFileAlumni.destroy();
              datatableDaftarFileAlumni.init();
              datatableDaftarFileAlumni.insert({
                data: rowsData
              });
        
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalDaftarFileAlumni').modal('show');
            },
            error: function(request, status, error) {
              console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });
        
        
        $('.toggle_daftar_keahlian_alumni').on('click', function() {
          const id_alumni = $(this).data('id_alumni');
          
          $('#ModalDaftarFileAlumni .modal-title').html(`<i data-feather="star" class="me-2 mt-1"></i>Daftar Keahlian Alumni`);
        
          $.ajax({
            url: 'get_keahlian_alumni_by_id_alumni.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_alumni': id_alumni
            },
            success: function(data) {
              // add datatables row
              let i = 1;
              let rowsData = [];
              
              for (key in data) {
                let fileKeahlian = data[key]['file_keahlian'];
        
                if (!fileKeahlian) {
                  fileKeahlianHtml = `<small class="text-muted">Tidak ada</small>`;
                } else {
                  fileKeahlianPath = "<?= base_url_return('assets/uploads/file_keahlian_alumni/') ?>" + fileKeahlian;
                  
                  // Preview button
                  fileKeahlianHtml = 
                    `<a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="${fileKeahlianPath}" target="_blank">
                      <i data-feather="eye" class="me-1"></i>Preview
                    </a>`;
                  
                  // Download button
                  fileKeahlianHtml +=
                    `<a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="${fileKeahlianPath}" download>
                      <i data-feather="download-cloud" class="me-1"></i>Download
                    </a>`;
                }
                
                rowsData.push([i++, data[key]['nama_alumni'], data[key]['nama_keahlian'], fileKeahlianHtml]);
              }
        
              datatableDaftarFileAlumni.destroy();
              datatableDaftarFileAlumni.init();
              datatableDaftarFileAlumni.insert({
                data: rowsData
              });
        
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalDaftarFileAlumni').modal('show');
            },
            error: function(request, status, error) {
              console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });
        

        const formSubmitBtn = $('#toggle_swal_submit');
        const eventName = 'click';
        
        toggleSwalSubmit(formSubmitBtn, eventName);
        
      });
    </script>

  </body>

  </html>

<?php endif ?>