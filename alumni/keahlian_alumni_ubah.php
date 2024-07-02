<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah alumni?
    if (!isAccessAllowed('alumni')) {
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
    
    $id_alumni          = $_SESSION['id_alumni'];
    $id_keahlian_alumni = $_POST['xid_keahlian_alumni'];
    $nama_keahlian     = htmlspecialchars($purifier->purify($_POST['xnama_keahlian']));
    $file_keahlian     = $_FILES['xfile_keahlian'];
    $file_keahlian_old = $_POST['xfile_keahlian_old'];
    $is_uploading      = $file_keahlian['name'] ? true : false;
        
    $stmt_keahlian_alumni = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_keahlian_alumni, 'SELECT id_alumni, file_keahlian FROM tbl_keahlian_alumni WHERE id=?');
    mysqli_stmt_bind_param($stmt_keahlian_alumni, 'i', $id_keahlian_alumni);
    mysqli_stmt_execute($stmt_keahlian_alumni);

    $result = mysqli_stmt_get_result($stmt_keahlian_alumni);
    $keahlian_alumni = mysqli_fetch_assoc($result);

    if ($keahlian_alumni['id_alumni'] != $id_alumni) {
        $_SESSION['msg'] = 'Tidak boleh mengubah data alumni lain!';
        echo "<meta http-equiv='refresh' content='0;keahlian_alumni.php?go=keahlian_alumni'>";
        return;
    }

    if ($is_uploading) {
        // Set upload configuration
        $target_dir    = '../assets/uploads/file_keahlian_alumni/';
        $max_file_size = 200 * 1024; // 200KB in bytes
        $allowed_types = ['pdf'];
    
        // Upload surat lamaran using the configuration
        $upload_file_keahlian = fileUpload($file_keahlian, $target_dir, $max_file_size, $allowed_types);
        $nama_berkas       = $upload_file_keahlian['hashedFilename'];
        $is_upload_success = $upload_file_keahlian['isUploaded'];
        $upload_messages   = $upload_file_keahlian['messages'];
    
        // Check is file uploaded?
        if (!$is_upload_success) {
            $_SESSION['msg'] = $upload_messages;
            echo "<meta http-equiv='refresh' content='0;keahlian_alumni.php?go=keahlian_alumni'>";
            return;
        }
        
        $old_file_keahlian = $keahlian_alumni['file_keahlian'];
        $file_path_to_unlink  = $target_dir . $old_file_keahlian;
        
        // Delete the old bukti pembayaran
        if (file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_keahlian}");
        }
    }
    
    $stmt_update = mysqli_stmt_init($connection);

    $nama_berkas = $is_uploading ? $nama_berkas : $file_keahlian_old;
    
    $query_update = "UPDATE tbl_keahlian_alumni SET
        nama_keahlian = ?
        , file_keahlian = ?
    WHERE id = ?";

    mysqli_stmt_prepare($stmt_update, $query_update);
    mysqli_stmt_bind_param($stmt_update, 'ssi', $nama_keahlian, $nama_berkas, $id_keahlian_alumni);

    $update = mysqli_stmt_execute($stmt_update);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt_keahlian_alumni);
    mysqli_stmt_close($stmt_update);
    
    mysqli_close($connection);
    
    echo "<meta http-equiv='refresh' content='0;keahlian_alumni.php?go=keahlian_alumni'>";
?>