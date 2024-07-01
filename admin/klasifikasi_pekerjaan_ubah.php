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
    
    $id_klasifikasi_pekerjaan   = $_POST['xid_klasifikasi_pekerjaan'];
    $klasifikasi_pekerjaan = htmlspecialchars($purifier->purify($_POST['xklasifikasi_pekerjaan']));

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "UPDATE tbl_klasifikasi_pekerjaan SET klasifikasi_pekerjaan=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'si', $klasifikasi_pekerjaan, $id_klasifikasi_pekerjaan);

    $update = mysqli_stmt_execute($stmt);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;klasifikasi_pekerjaan.php?go=klasifikasi_pekerjaan'>";
?>