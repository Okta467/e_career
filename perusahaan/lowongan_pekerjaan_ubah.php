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
    
    $id_lowongan              = $_POST['xid_lowongan'];
    $id_jenis_pekerjaan       = $_POST['xid_jenis_pekerjaan'];
    $id_klasifikasi_pekerjaan = $_POST['xid_klasifikasi_pekerjaan'];
    $nama_lowongan            = htmlspecialchars($purifier->purify($_POST['xnama_lowongan']));
    $penempatan               = htmlspecialchars($purifier->purify($_POST['xpenempatan']));
    $batas_bawah_gaji         = $_POST['xbatas_bawah_gaji'];
    $batas_atas_gaji          = $_POST['xbatas_atas_gaji'];
    $tipe_gaji                = $_POST['xtipe_gaji'];
    $keterangan_lowongan      = htmlspecialchars($purifier->purify($_POST['xketerangan_lowongan']));
    
    $stmt_lowongan = mysqli_stmt_init($connection);
    
    mysqli_stmt_prepare($stmt_lowongan, "SELECT id_perusahaan FROM tbl_lowongan WHERE id=?");
    mysqli_stmt_bind_param($stmt_lowongan, 'i', $id_lowongan);
    mysqli_stmt_execute($stmt_lowongan);

    $result = mysqli_stmt_get_result($stmt_lowongan);
    $lowongan = mysqli_fetch_assoc($result);

    $current_id_perusahaan = $lowongan['id_perusahaan'] ?? null;
    $session_id_perusahaan = $_SESSION['id_perusahaan'];
    
    if ($current_id_perusahaan != $session_id_perusahaan) {
        $_SESSION['msg'] = 'Tidak boleh mengubah lowongan dari perusahaan lain!';
        echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
        return;        
    }

    $stmt_update = mysqli_stmt_init($connection);
    $query = 
        "UPDATE tbl_lowongan SET
            id_jenis_pekerjaan=?
            , id_klasifikasi_pekerjaan=?
            , nama_lowongan=?
            , penempatan=?
            , batas_bawah_gaji=?
            , batas_atas_gaji=?
            , tipe_gaji=?
            , keterangan_lowongan=?
        WHERE id=?";

    mysqli_stmt_prepare($stmt_update, $query);
    mysqli_stmt_bind_param($stmt_update, 'iissiissi', $id_jenis_pekerjaan, $id_klasifikasi_pekerjaan, $nama_lowongan, $penempatan, $batas_bawah_gaji, $batas_atas_gaji, $tipe_gaji, $keterangan_lowongan, $id_lowongan);

    $update = mysqli_stmt_execute($stmt_update);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt_lowongan);
    mysqli_stmt_close($stmt_update);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
?>