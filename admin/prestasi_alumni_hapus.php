<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_prestasi_alumni = $_GET['xid_prestasi_alumni'];
    
    // Get prestasi alumni to delete current file_prestasi after data deletion
    $stmt_prestasi_alumni = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_prestasi_alumni, 'SELECT id_alumni, file_prestasi FROM tbl_prestasi_alumni WHERE id=?');
    mysqli_stmt_bind_param($stmt_prestasi_alumni, 'i', $id_prestasi_alumni);
    mysqli_stmt_execute($stmt_prestasi_alumni);

    $result = mysqli_stmt_get_result($stmt_prestasi_alumni);
    $prestasi_alumni = mysqli_fetch_assoc($result);

    // tbl_prestasi_alumni data statement and execution
    $stmt_hapus = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_hapus, "DELETE FROM tbl_prestasi_alumni WHERE id=?");
    mysqli_stmt_bind_param($stmt_hapus, 'i', $id_prestasi_alumni);

    $delete = mysqli_stmt_execute($stmt_hapus);
    
    // Delete file_prestasi_alumni if data deletio is success
    if ($delete) {
        $target_dir = '../assets/uploads/file_prestasi_alumni/';
        $old_file_prestasi_alumni = $prestasi_alumni['file_prestasi'];
        $file_path_to_unlink = $target_dir . $old_file_prestasi_alumni;
        
        // Delete the old file_prestasi
        if (file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_prestasi_alumni}");
        }
    }

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt_prestasi_alumni);
    mysqli_stmt_close($stmt_hapus);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;prestasi_alumni.php?go=prestasi_alumni'>";
?>