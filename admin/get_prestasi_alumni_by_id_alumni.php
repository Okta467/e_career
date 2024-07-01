<?php
    include '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_alumni = $_POST['id_alumni'];

    $stmt = mysqli_stmt_init($connection);
    $query = 
        "SELECT b.nama_alumni, a.nama_prestasi, a.file_prestasi
        FROM tbl_prestasi_alumni AS a
        JOIN tbl_alumni AS b
            ON b.id = a.id_alumni
        WHERE b.id=?";

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_alumni);
    mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

    $prestasi_alumnis = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo json_encode($prestasi_alumnis);

?>