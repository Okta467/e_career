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
    
    $id_kelas   = $_POST['xid_kelas'];
    $nisn       = $_POST['xnisn'];
    $nama_alumni = htmlspecialchars($purifier->purify($_POST['xnama_alumni']));
    $username   = $nisn;
    $password   = password_hash($_POST['xpassword'], PASSWORD_DEFAULT);
    $hak_akses  = 'alumni';
    $jk         = $_POST['xjk'];
    $alamat     = htmlspecialchars($purifier->purify($_POST['xalamat']));
    $tmp_lahir  = htmlspecialchars($purifier->purify($_POST['xtmp_lahir']));
    $tgl_lahir  = $_POST['xtgl_lahir'];
    $no_telp    = '62' . $_POST['xno_telp'];
    $email      = htmlspecialchars($purifier->purify($_POST['xemail']));

    // Turn off autocommit mode
    mysqli_autocommit($connection, false);

    // Initialize the success flag
    $success = true;

    // Begin the transaction
    try {
        // Pengguna statement preparation and execution
        $stmt_pengguna  = mysqli_stmt_init($connection);
        $query_pengguna = "INSERT INTO tbl_pengguna (username, password, hak_akses) VALUES (?, ?, ?)";
        
        if (!mysqli_stmt_prepare($stmt_pengguna, $query_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_pengguna, 'sss', $username, $password, $hak_akses);
        
        if (!mysqli_stmt_execute($stmt_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

        // Alumni statement preparation and execution
        $stmt_alumni  = mysqli_stmt_init($connection);
        $query_alumni = "INSERT INTO tbl_alumni 
        (
            id_pengguna
            , id_kelas
            , nisn
            , nama_alumni
            , jk
            , alamat
            , tmp_lahir
            , tgl_lahir
            , no_telp
            , email
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if (!mysqli_stmt_prepare($stmt_alumni, $query_alumni)) {
            $_SESSION['msg'] = 'Statement Alumni preparation failed: ' . mysqli_stmt_error($stmt_alumni);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }
        
        $id_pengguna = mysqli_insert_id($connection);
        mysqli_stmt_bind_param($stmt_alumni, 'iissssssss', $id_pengguna, $id_kelas, $nisn, $nama_alumni, $jk, $alamat, $tmp_lahir, $tgl_lahir, $no_telp, $email);
        
        if (!mysqli_stmt_execute($stmt_alumni)) {
            $_SESSION['msg'] = 'Statement Alumni preparation failed: ' . mysqli_stmt_error($stmt_alumni);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

        // Commit the transaction if all statements succeed
        if (!mysqli_commit($connection)) {
            $_SESSION['msg'] = 'Transaction commit failed: ' . mysqli_stmt_error($stmt_alumni);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

    } catch (Exception $e) {
        // Roll back the transaction if any statement fails
        $success = false;
        mysqli_rollback($connection);
        $_SESSION['msg'] = 'Transaction failed: ' . $e->getMessage();
    }

    // Close the statements
    mysqli_stmt_close($stmt_pengguna);
    mysqli_stmt_close($stmt_alumni);

    // Turn autocommit mode back on
    mysqli_autocommit($connection, true);

    // Close the connection
    mysqli_close($connection);

    !$success
        ? ''
        : $_SESSION['msg'] = 'save_success';

    echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
?>
