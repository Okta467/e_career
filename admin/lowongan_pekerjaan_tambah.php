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
    
    $id_perusahaan            = $_POST['xid_perusahaan'];
    $id_jenis_pekerjaan       = $_POST['xid_jenis_pekerjaan'];
    $id_klasifikasi_pekerjaan = $_POST['xid_klasifikasi_pekerjaan'];
    $nama_lowongan            = htmlspecialchars($purifier->purify($_POST['xnama_lowongan']));
    $penempatan               = htmlspecialchars($purifier->purify($_POST['xpenempatan']));
    $batas_bawah_gaji         = $_POST['xbatas_bawah_gaji'];
    $batas_atas_gaji          = $_POST['xbatas_atas_gaji'];
    $tipe_gaji                = $_POST['xtipe_gaji'];
    $keterangan_lowongan      = htmlspecialchars($purifier->purify($_POST['xketerangan_lowongan']));

    $stmt = mysqli_stmt_init($connection);
    $query = 
        "INSERT INTO tbl_lowongan
        (
            id_perusahaan
            , id_jenis_pekerjaan
            , id_klasifikasi_pekerjaan
            , nama_lowongan
            , penempatan
            , batas_bawah_gaji
            , batas_atas_gaji
            , tipe_gaji
            , keterangan_lowongan
        )
        VALUES(?,?,?,?,?,?,?,?,?)";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'iiissiiss', $id_perusahaan, $id_jenis_pekerjaan, $id_klasifikasi_pekerjaan, $nama_lowongan, $penempatan, $batas_bawah_gaji, $batas_atas_gaji, $tipe_gaji, $keterangan_lowongan);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;lowongan_pekerjaan.php?go=lowongan_pekerjaan'>";
?>