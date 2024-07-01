<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah perusahaan?
    if (!isAccessAllowed('perusahaan')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_perusahaan = $_POST['id_perusahaan'];

    $stmt1 = mysqli_stmt_init($connection);
    $query = 
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
        WHERE b.id=?";

    mysqli_stmt_prepare($stmt1, $query);
    mysqli_stmt_bind_param($stmt1, 'i', $id_perusahaan);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $lowongans = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt1);
    mysqli_close($connection);

    echo json_encode($lowongans);

?>