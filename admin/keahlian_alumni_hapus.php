<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_keahlian_alumni = $_GET['xid_keahlian_alumni'];
    
    // Get keahlian alumni to delete current file_keahlian after data deletion
    $stmt_keahlian_alumni = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_keahlian_alumni, 'SELECT id_alumni, file_keahlian FROM tbl_keahlian_alumni WHERE id=?');
    mysqli_stmt_bind_param($stmt_keahlian_alumni, 'i', $id_keahlian_alumni);
    mysqli_stmt_execute($stmt_keahlian_alumni);

    $result = mysqli_stmt_get_result($stmt_keahlian_alumni);
    $keahlian_alumni = mysqli_fetch_assoc($result);

    // tbl_keahlian_alumni data statement and execution
    $stmt_hapus = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_hapus, "DELETE FROM tbl_keahlian_alumni WHERE id=?");
    mysqli_stmt_bind_param($stmt_hapus, 'i', $id_keahlian_alumni);

    $delete = mysqli_stmt_execute($stmt_hapus);
    
    // Delete file_keahlian_alumni if data deletio is success
    if ($delete) {
        $target_dir = '../assets/uploads/file_keahlian_alumni/';
        $old_file_keahlian_alumni = $keahlian_alumni['file_keahlian'];
        $file_path_to_unlink = $target_dir . $old_file_keahlian_alumni;
        
        // Delete the old file_keahlian
        if (file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_keahlian_alumni}");
        }
    }

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt_keahlian_alumni);
    mysqli_stmt_close($stmt_hapus);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;keahlian_alumni.php?go=keahlian_alumni'>";
?>