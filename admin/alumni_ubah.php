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
    
    $id_alumni    = $_POST['xid_alumni'];
    $id_kelas    = $_POST['xid_kelas'];
    $nisn        = $_POST['xnisn'];
    $nama_alumni  = htmlspecialchars($purifier->purify($_POST['xnama_alumni']));
    $password    = $_POST['xpassword'] ? password_hash($_POST['xpassword'], PASSWORD_DEFAULT) : null;
    $hak_akses   = 'pimpinan';
    $jk          = $_POST['xjk'];
    $alamat      = htmlspecialchars($purifier->purify($_POST['xalamat']));
    $tmp_lahir   = htmlspecialchars($purifier->purify($_POST['xtmp_lahir']));
    $tgl_lahir   = $_POST['xtgl_lahir'];
    $no_telp     = isset($_POST['xno_telp']) ? '62' . $_POST['xno_telp'] : null;
    $email       = htmlspecialchars($purifier->purify($_POST['xemail']));

    mysqli_autocommit($connection, false);

    $success = true;

    try {
        // Alumni statement preparation and execution
        $stmt_alumni  = mysqli_stmt_init($connection);
        $query_alumni = "UPDATE tbl_alumni SET
            id_kelas = ?
            , nisn = ?
            , nama_alumni = ?
            , jk = ?
            , alamat = ?
            , tmp_lahir = ?
            , tgl_lahir = ?
            , no_telp = ?
            , email = ?
        WHERE id = ?";
        
        if (!mysqli_stmt_prepare($stmt_alumni, $query_alumni)) {
            $_SESSION['msg'] = 'Statement Alumni preparation failed: ' . mysqli_stmt_error($stmt_alumni);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_alumni, 'issssssssi', $id_kelas, $nisn, $nama_alumni, $jk, $alamat, $tmp_lahir, $tgl_lahir, $no_telp, $email, $id_alumni);
        
        if (!mysqli_stmt_execute($stmt_alumni)) {
            $_SESSION['msg'] = 'Statement Alumni preparation failed: ' . mysqli_stmt_error($stmt_alumni);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

        // Current Alumni statement preparation and execution
        $stmt_current_alumni = mysqli_stmt_init($connection);
        $query_current_alumni = "SELECT id_pengguna FROM tbl_alumni WHERE id=?";
        
        mysqli_stmt_prepare($stmt_current_alumni, $query_current_alumni);
        mysqli_stmt_bind_param($stmt_current_alumni, 'i', $id_alumni);
        mysqli_stmt_execute($stmt_current_alumni);

        $result = mysqli_stmt_get_result($stmt_current_alumni);
        $current_alumni = mysqli_fetch_assoc($result);

        $id_pengguna = $current_alumni['id_pengguna'];

        // Pengguna statement preparation and execution
        $stmt_pengguna  = mysqli_stmt_init($connection);
        $query_pengguna = !$password
            ? "UPDATE tbl_pengguna SET username=? WHERE id=?"
            : "UPDATE tbl_pengguna SET username=?, password=? WHERE id=?";
        
        if (!mysqli_stmt_prepare($stmt_pengguna, $query_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }
        
        !$password
            ? mysqli_stmt_bind_param($stmt_pengguna, 'si', $username, $id_pengguna)
            : mysqli_stmt_bind_param($stmt_pengguna, 'ssi', $username, $password, $id_pengguna);
        
        if (!mysqli_stmt_execute($stmt_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

        // Commit the transaction if all statements succeed
        if (!mysqli_commit($connection)) {
            $_SESSION['msg'] = 'Transaction commit failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

    } catch (Exception $e) {
        // Roll back the transaction if any statement fails
        $success = false;
        mysqli_rollback($connection);
        $_SESSION['msg'] = 'Transaction failed: ' . $e->getMessage();
    }

    !$success
        ? ''
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt_alumni);
    mysqli_stmt_close($stmt_current_alumni);
    mysqli_stmt_close($stmt_pengguna);

    mysqli_autocommit($connection, true);

    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
?>
