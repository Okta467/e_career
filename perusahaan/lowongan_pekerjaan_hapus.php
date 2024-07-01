<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah perusahaan?
    if (!isAccessAllowed('perusahaan')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_lowongan = $_GET['xid_lowongan'];
    
    $stmt_lowongan = mysqli_stmt_init($connection);
    
    mysqli_stmt_prepare($stmt_lowongan, "SELECT id_perusahaan FROM tbl_lowongan WHERE id=?");
    mysqli_stmt_bind_param($stmt_lowongan, 'i', $id_lowongan);
    mysqli_stmt_execute($stmt_lowongan);

    $result = mysqli_stmt_get_result($stmt_lowongan);
    $lowongan = mysqli_fetch_assoc($result);

    $current_id_perusahaan = $lowongan['id_perusahaan'] ?? null;
    $session_id_perusahaan = $_SESSION['id_perusahaan'];
    
    if ($current_id_perusahaan != $session_id_perusahaan) {
        $_SESSION['msg'] = 'Tidak boleh menghapus lowongan dari perusahaan lain!';
        echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
        return;        
    }

    $stmt_hapus = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_hapus, "DELETE FROM tbl_lowongan WHERE id=?");
    mysqli_stmt_bind_param($stmt_hapus, 'i', $id_lowongan);

    $delete = mysqli_stmt_execute($stmt_hapus);

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt_lowongan);
    mysqli_stmt_close($stmt_hapus);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
?>