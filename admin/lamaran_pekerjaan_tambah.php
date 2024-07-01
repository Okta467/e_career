<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_alumni                 = $_POST['xid_alumni'];
    $id_lowongan               = $_POST['xid_lowongan'];
    $status_lamaran            = $_POST['xstatus_lamaran'];
    $keterangan_lamaran        = htmlspecialchars($purifier->purify($_POST['xketerangan_lamaran']));
    $is_status_lamaran_allowed = $status_lamaran && in_array($status_lamaran, ['tidak_lolos', 'pemberkasan', 'interview', 'lolos', 'lainnya']);

    if (!$is_status_lamaran_allowed) {
        $_SESSION['msg'] = 'Status lamaran tidak diperbolehkan!';
        echo "<meta http-equiv='refresh' content='0;lamaran_pekerjaan.php?go=lamaran_pekerjaan'>";
        return;
    }

    $stmt = mysqli_stmt_init($connection);
    $query = 
        "INSERT INTO tbl_lamaran_pekerjaan 
        (
            id_lowongan
            , id_alumni
            , status_lamaran
            , keterangan_lamaran
        )
        VALUES (?, ?, ?, ?)";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'iiss', $id_lowongan, $id_alumni, $status_lamaran, $keterangan_lamaran);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;lamaran_pekerjaan.php?go=lamaran_pekerjaan'>";
?>