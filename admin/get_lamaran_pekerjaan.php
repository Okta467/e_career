<?php
    include '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_lamaran_pekerjaan = $_POST['id_lamaran_pekerjaan'];

    $stmt = mysqli_stmt_init($connection);
    $query = 
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
        WHERE g.id=? ";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_lamaran_pekerjaan);
    mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

    $lamaran_pekerjaans = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo json_encode($lamaran_pekerjaans);

?>