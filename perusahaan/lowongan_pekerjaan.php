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
            
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="tool" class="me-2 mt-1"></i>
                  Data Lowongan Pekerjaan
                </div>
                <a class="btn btn-sm btn-primary" href="lowongan_pekerjaan_halaman_tambah_or_ubah.php?go=lowongan_pekerjaan"><i data-feather="plus-circle" class="me-2"></i>Lowongan Baru</a>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Perusahaan</th>
                      <th>Jenis</th>
                      <th>Klasifikasi</th>
                      <th>Nama Lowongan</th>
                      <th>Penempatan</th>
                      <th>Gaji</th>
                      <th>Tipe</th>
                      <th>Keterangan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_lowongan_pekerjaan = mysqli_query($connection, 
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
                      WHERE b.id = {$_SESSION['id_perusahaan']}
                      ORDER BY a.id DESC");

                    while ($lowongan_pekerjaan = mysqli_fetch_assoc($query_lowongan_pekerjaan)):
                      $batas_bawah_gaji = $lowongan_pekerjaan['batas_bawah_gaji'] ?? null;
                      $batas_atas_gaji = $lowongan_pekerjaan['batas_atas_gaji'] ?? null;
                      
                      if (!$batas_bawah_gaji && !$batas_atas_gaji):
                        $gaji = '<small class="text-muted">Tidak ditampilkan</small>';
                        $tipe_gaji = '<small class="text-muted">-</small>';
                      else:
                        $formatted_batas_bawah_gaji = number_format($batas_bawah_gaji, 0, ',', '.');
                        $formatted_batas_atas_gaji = number_format($batas_atas_gaji, 0, ',', '.');
                        
                        $gaji = !$batas_atas_gaji
                          ? "Rp{$formatted_batas_bawah_gaji}"
                          : "Rp{$formatted_batas_bawah_gaji} - Rp{$formatted_batas_atas_gaji}";

                        $tipe_gaji = ucfirst($lowongan_pekerjaan['tipe_gaji']);
                      endif;

                      $link_ubah_lowongan = "lowongan_pekerjaan_halaman_tambah_or_ubah.php?go=lowongan_pekerjaan";
                      $link_ubah_lowongan .= "&id_lowongan={$lowongan_pekerjaan['id_lowongan']}";
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $lowongan_pekerjaan['nama_perusahaan'] ?></td>
                        <td><?= $lowongan_pekerjaan['jenis_pekerjaan'] ?></td>
                        <td>
                          <div class="ellipsis toggle_tooltip" title="<?= $lowongan_pekerjaan['klasifikasi_pekerjaan'] ?>">
                            <?= $lowongan_pekerjaan['klasifikasi_pekerjaan'] ?>
                          </div>
                        </td>
                        <td><?= $lowongan_pekerjaan['nama_lowongan'] ?></td>
                        <td><?= $lowongan_pekerjaan['penempatan'] ?></td>
                        <td><?= $gaji ?></td>
                        <td><?= $tipe_gaji ?></td>
                        <td>
                          <button type="button" class="btn btn-xs rounded-pill btn-outline-primary toggle_detail_keterangan_lowongan" data-id_lowongan="<?= $lowongan_pekerjaan['id_lowongan'] ?>">
                            <i data-feather="list" class="me-1"></i>
                            Detail
                          </button>
                        </td>
                        <td>
                          <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="<?= $link_ubah_lowongan ?>">
                            <i class="fa fa-pen-to-square"></i>
                          </a>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                            data-id_lowongan="<?= $lowongan_pekerjaan['id_lowongan'] ?>" 
                            data-nama_lowongan="<?= $lowongan_pekerjaan['nama_lowongan'] ?>">
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
    
    <!--============================= MODAL DETAIL KETERANGAN LOWONGAN =============================-->
    <div class="modal fade" id="ModalDetailKeteranganLowongan" tabindex="-1" role="dialog" aria-labelledby="ModalDetailKeteranganLowonganTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalDetailKeteranganLowonganTitle"><i data-feather="list" class="me-2 mt-1"></i>Keterangan Lowongan</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div id="xdetail_keterangan_lowongan" class="p-3"></div>

          </div>
          <div class="modal-footer">
            <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!--/.modal-detail-keterangan-lowongan -->
    
    <!--============================= MODAL INPUT LOWONGAN PEKERJAAN =============================-->
    <div class="modal fade" id="ModalInputLowonganPekerjaan" tabindex="-1" role="dialog" aria-labelledby="ModalInputLowonganPekerjaanTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputLowonganPekerjaanTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_lowongan" name="xid_lowongan">
            
              <div class="mb-3">
                <label class="small mb-1" for="xnama_lowongan">Lowongan Pekerjaan</label>
                <input type="text" name="xnama_lowongan" class="form-control" id="xnama_lowongan" placeholder="Enter lowongan_pekerjaan" required />
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Batal</button>
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-input-lowongan-pekerjaan -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {


        $('.toggle_modal_ubah').on('click', function() {
          const id_lowongan = $(this).data('id_lowongan');
          const nama_lowongan = $(this).data('nama_lowongan');
          
          $('#ModalInputLowonganPekerjaan .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Lowongan Pekerjaan`);
          $('#ModalInputLowonganPekerjaan form').attr({action: 'lowongan_pekerjaan_ubah.php', method: 'post'});

          $('#ModalInputLowonganPekerjaan #xid_lowongan').val(id_lowongan);
          $('#ModalInputLowonganPekerjaan #xnama_lowongan').val(nama_lowongan);

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputLowonganPekerjaan').modal('show');
        });


        $('.toggle_detail_keterangan_lowongan').on('click', function() {
          const id_lowongan = $(this).data('id_lowongan');

          $.ajax({
            url: 'get_keterangan_lowongan.php',
            type: 'POST',
            data: {
              id_lowongan: id_lowongan
            },
            dataType: 'JSON',
            success: function(data) {
              const keterangan_lowongan = data[0].keterangan_lowongan;
              const sanitized_keterangan_lowongan = DOMPurify.sanitize(keterangan_lowongan, { USE_PROFILES: { html: true } });
              const parsed_keterangan_lowongan = marked.parse(sanitized_keterangan_lowongan);

              $('#xdetail_keterangan_lowongan').html(parsed_keterangan_lowongan);
              
              $('#ModalDetailKeteranganLowongan').modal('show');
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_lowongan   = $(this).data('id_lowongan');
          const nama_lowongan = $(this).data('nama_lowongan');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `Hapus data lowongan_pekerjaan: <strong>${nama_lowongan}?</strong>`,
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
                window.location = `lowongan_pekerjaan_hapus.php?xid_lowongan=${id_lowongan}`;
              });
            }
          });
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>