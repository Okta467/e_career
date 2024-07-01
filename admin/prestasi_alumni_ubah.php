<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/htmlpurifier/HTMLPurifier.auto.php';
    require_once '../helpers/fileUploadHelper.php';
    require_once '../helpers/getHashedFileNameHelper.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_alumni          = $_POST['xid_alumni'];
    $id_prestasi_alumni = $_POST['xid_prestasi_alumni'];
    $nama_prestasi      = htmlspecialchars($purifier->purify($_POST['xnama_prestasi']));
    $file_prestasi      = $_FILES['xfile_prestasi'];
    $file_prestasi_old  = $_POST['xfile_prestasi_old'];
    $is_uploading       = $file_prestasi['name'] ? true : false;
        
    $stmt_prestasi_alumni = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_prestasi_alumni, 'SELECT id_alumni, file_prestasi FROM tbl_prestasi_alumni WHERE id=?');
    mysqli_stmt_bind_param($stmt_prestasi_alumni, 'i', $id_prestasi_alumni);
    mysqli_stmt_execute($stmt_prestasi_alumni);

    $result = mysqli_stmt_get_result($stmt_prestasi_alumni);
    $prestasi_alumni = mysqli_fetch_assoc($result);

    if ($prestasi_alumni['id_alumni'] != $id_alumni) {
        $_SESSION['msg'] = 'Tidak boleh menghapus data alumni lain!';
        echo "<meta http-equiv='refresh' content='0;prestasi_alumni.php?go=prestasi_alumni'>";
        return;
    }

    if ($is_uploading) {
        // Set upload configuration
        $target_dir    = '../assets/uploads/file_prestasi_alumni/';
        $max_file_size = 200 * 1024; // 200KB in bytes
        $allowed_types = ['pdf'];
    
        // Upload surat lamaran using the configuration
        $upload_file_prestasi = fileUpload($file_prestasi, $target_dir, $max_file_size, $allowed_types);
        $nama_berkas       = $upload_file_prestasi['hashedFilename'];
        $is_upload_success = $upload_file_prestasi['isUploaded'];
        $upload_messages   = $upload_file_prestasi['messages'];
    
        // Check is file uploaded?
        if (!$is_upload_success) {
            $_SESSION['msg'] = $upload_messages;
            echo "<meta http-equiv='refresh' content='0;prestasi_alumni.php?go=prestasi_alumni'>";
            return;
        }
        
        $old_file_prestasi = $prestasi_alumni['file_prestasi'];
        $file_path_to_unlink  = $target_dir . $old_file_prestasi;
        
        // Delete the old bukti pembayaran
        if (file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_prestasi}");
        }
    }
    
    $stmt_update = mysqli_stmt_init($connection);

    $nama_berkas = $is_uploading ? $nama_berkas : $file_prestasi_old;
    
    $query_update = "UPDATE tbl_prestasi_alumni SET
        nama_prestasi = ?
        , file_prestasi = ?
    WHERE id = ?";

    mysqli_stmt_prepare($stmt_update, $query_update);
    mysqli_stmt_bind_param($stmt_update, 'ssi', $nama_prestasi, $nama_berkas, $id_prestasi_alumni);

    $update = mysqli_stmt_execute($stmt_update);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt_prestasi_alumni);
    mysqli_stmt_close($stmt_update);
    
    mysqli_close($connection);
    
    echo "<meta http-equiv='refresh' content='0;prestasi_alumni.php?go=prestasi_alumni'>";
?>