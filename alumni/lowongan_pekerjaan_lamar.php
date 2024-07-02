<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah alumni?
    if (!isAccessAllowed('alumni')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_lowongan = $_GET['id_lowongan'];
    $id_alumni = $_SESSION['id_alumni'];
    $status_lamaran = 'pemberkasan';

    $stmt_lamaran_pekerjaan = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_lamaran_pekerjaan, "SELECT id FROM tbl_lamaran_pekerjaan WHERE id_lowongan=? AND id_alumni=?");
    mysqli_stmt_bind_param($stmt_lamaran_pekerjaan, 'ii', $id_lowongan, $id_alumni);
    mysqli_stmt_execute($stmt_lamaran_pekerjaan);

    $result = mysqli_stmt_get_result($stmt_lamaran_pekerjaan);
    $lamaran_pekerjaan = mysqli_fetch_assoc($result);

    if ($lamaran_pekerjaan) {
        $_SESSION['msg'] = 'Anda sudah melamar lowongan pekerjaan ini!';
        echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
        return;
    }

    $stmt_insert = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_insert, "INSERT INTO tbl_lamaran_pekerjaan (id_lowongan, id_alumni, status_lamaran) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt_insert, 'iis', $id_lowongan, $id_alumni, $status_lamaran);

    $insert = mysqli_stmt_execute($stmt_insert);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt_insert);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
?>