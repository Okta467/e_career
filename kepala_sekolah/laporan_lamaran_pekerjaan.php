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

    <meta name="description" content="Data Pengumuman" />
    <meta name="author" content="" />
    <title>Pengumuman - <?= SITE_NAME ?></title>
  </head>

  <body class="bg-white">
    <?php
    $no = 1;
    $dari_tanggal = $_GET['dari_tanggal'] ?? null;
    $sampai_tanggal = $_GET['sampai_tanggal'] ?? null;

    if (!$dari_tanggal || !$sampai_tanggal) {
      echo 'Input dari dan sampai tanggal harus diisi!';
      return;
    }

    $stmt_lamaran_pekerjaan = mysqli_stmt_init($connection);
    $query_lamaran_pekerjaan =
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
      WHERE g.created_at BETWEEN ? AND ?
      ORDER BY g.id DESC";
      
    mysqli_stmt_prepare($stmt_lamaran_pekerjaan, $query_lamaran_pekerjaan);
    mysqli_stmt_bind_param($stmt_lamaran_pekerjaan, 'ss', $dari_tanggal, $sampai_tanggal);
    mysqli_stmt_execute($stmt_lamaran_pekerjaan);

    $result = mysqli_stmt_get_result($stmt_lamaran_pekerjaan);
    $lamaran_pekerjaans = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt_lamaran_pekerjaan);
    mysqli_close($connection);
    ?>

    <h4 class="text-center mb-4">Laporan Lamaran Pekerjaan Alumni <?= "({$dari_tanggal} s.d. {$sampai_tanggal})" ?></h4>

    <table class="table table-striped table-bordered table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Alumni</th>
          <th>Kelas</th>
          <th>Perusahaan</th>
          <th>Nama Lowongan</th>
          <th>Penempatan</th>
          <th>Status</th>
          <th>Tgl. Melamar</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$result->num_rows): ?>

          <tr>
            <td colspan="9"><div class="text-center">Tidak ada data</div></td>
          </tr>
        
        <?php else: ?>

          <?php foreach($lamaran_pekerjaans as $lamaran_pekerjaan) : ?>

            <?php
            $status_lamaran = $lamaran_pekerjaan['status_lamaran'];
            $formatted_status_lamaran = ucwords(str_replace('_', ' ', $status_lamaran));
            ?>
            
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <?= htmlspecialchars($lamaran_pekerjaan['nama_alumni']) ?>
                <?= "<br><small class='text-muted'>({$lamaran_pekerjaan['nisn']})</small>" ?>
              </td>
              <td>
                <div class="text-nowrap">
                  <?= $lamaran_pekerjaan['nama_kelas'] ?>
                </div>
              </td>
              <td><?= $lamaran_pekerjaan['nama_perusahaan'] ?></td>
              <td><?= "{$lamaran_pekerjaan['nama_lowongan']} ({$lamaran_pekerjaan['jenis_pekerjaan']})" ?></td>
              <td><?= $lamaran_pekerjaan['penempatan'] ?></td>
              <td><?= $formatted_status_lamaran ?></td>
              <td>
                <div class="text-nowrap">
                  <?= date('m-d-Y', strtotime($lamaran_pekerjaan['tgl_melamar'])) ?>
                </div>
              </td>
            </tr>

          <?php endforeach ?>

        <?php endif ?>
      </tbody>
    </table>

  </body>

  </html>

<?php endif ?>