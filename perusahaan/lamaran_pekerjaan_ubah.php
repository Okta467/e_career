<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah perusahaan?
    if (!isAccessAllowed('perusahaan')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_lamaran_pekerjaan      = $_POST['xid_lamaran_pekerjaan'];
    $status_lamaran            = $_POST['xstatus_lamaran'];
    $keterangan_lamaran        = htmlspecialchars($purifier->purify($_POST['xketerangan_lamaran']));
    $is_status_lamaran_allowed = $status_lamaran && in_array($status_lamaran, ['tidak_lolos', 'pemberkasan', 'interview', 'lolos', 'lainnya']);

    if (!$is_status_lamaran_allowed) {
        $_SESSION['msg'] = 'Status lamaran tidak diperbolehkan!';
        echo "<meta http-equiv='refresh' content='0;lamaran_pekerjaan.php?go=lamaran_pekerjaan'>";
        return;
    }

    $stmt_lamaran_pekerjaan = mysqli_stmt_init($connection);
    $query_lamaran_pekerjaan = 
        "SELECT b.id AS id_perusahaan
        FROM tbl_lowongan AS a
        INNER JOIN tbl_perusahaan AS b
            ON b.id = a.id_perusahaan
        INNER JOIN tbl_lamaran_pekerjaan AS c
            ON a.id = c.id_lowongan
        WHERE c.id=?";
    
    mysqli_stmt_prepare($stmt_lamaran_pekerjaan, $query_lamaran_pekerjaan);
    mysqli_stmt_bind_param($stmt_lamaran_pekerjaan, 'i', $id_lamaran_pekerjaan);
    mysqli_stmt_execute($stmt_lamaran_pekerjaan);

    $result = mysqli_stmt_get_result($stmt_lamaran_pekerjaan);
    $lamaran_pekerjaan = mysqli_fetch_assoc($result);

    $current_id_perusahaan = $lamaran_pekerjaan['id_perusahaan'] ?? null;
    $session_id_perusahaan = $_SESSION['id_perusahaan'];
    
    if ($current_id_perusahaan != $session_id_perusahaan) {
        $_SESSION['msg'] = 'Tidak boleh mengubah lowongan dari perusahaan lain!';
        echo "<meta http-equiv='refresh' content='0;lamaran_pekerjaan.php?go=lamaran_pekerjaan'>";
        return;
    }

    $stmt_ubah = mysqli_stmt_init($connection);
    $query = 
        "UPDATE tbl_lamaran_pekerjaan SET
            status_lamaran=?
            , keterangan_lamaran=?
        WHERE id=?";

    mysqli_stmt_prepare($stmt_ubah, $query);
    mysqli_stmt_bind_param($stmt_ubah, 'ssi', $status_lamaran, $keterangan_lamaran, $id_lamaran_pekerjaan);

    $update = mysqli_stmt_execute($stmt_ubah);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt_lamaran_pekerjaan);
    mysqli_stmt_close($stmt_ubah);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;lamaran_pekerjaan.php?go=lamaran_pekerjaan'>";
?>