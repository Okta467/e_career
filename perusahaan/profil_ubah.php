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
    
    $id_pengguna         = $_SESSION['id_pengguna'];
    $id_perusahaan       = $_SESSION['id_perusahaan'];
    $id_jenis_perusahaan = $_POST['xid_jenis_perusahaan'];
    $username            = htmlspecialchars($purifier->purify($_POST['xusername']));
    $nama_perusahaan     = htmlspecialchars($purifier->purify($_POST['xnama_perusahaan']));
    $password            = $_POST['xpassword'] ? password_hash($_POST['xpassword'], PASSWORD_DEFAULT) : null;
    $hak_akses           = 'perusahaan';
    $alamat_perusahaan   = htmlspecialchars($purifier->purify($_POST['xalamat_perusahaan']));

    mysqli_autocommit($connection, false);

    $success = true;

    try {
        // Siswa statement preparation and execution
        $stmt_perusahaan  = mysqli_stmt_init($connection);
        $query_perusahaan = "UPDATE tbl_perusahaan SET
            id_jenis_perusahaan = ?
            , nama_perusahaan = ?
            , alamat_perusahaan = ?
        WHERE id = ?";
        
        if (!mysqli_stmt_prepare($stmt_perusahaan, $query_perusahaan)) {
            $_SESSION['msg'] = 'Statement Siswa preparation failed: ' . mysqli_stmt_error($stmt_perusahaan);
            echo "<meta http-equiv='refresh' content='0;profil.php?go=profil'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_perusahaan, 'issi', $id_jenis_perusahaan, $nama_perusahaan, $alamat_perusahaan, $id_perusahaan);
        
        if (!mysqli_stmt_execute($stmt_perusahaan)) {
            $_SESSION['msg'] = 'Statement Siswa preparation failed: ' . mysqli_stmt_error($stmt_perusahaan);
            echo "<meta http-equiv='refresh' content='0;profil.php?go=profil'>";
            return;
        }

        // Pengguna statement preparation and execution
        $stmt_pengguna  = mysqli_stmt_init($connection);
        $query_pengguna = !$password
            ? "UPDATE tbl_pengguna SET username=? WHERE id=?"
            : "UPDATE tbl_pengguna SET username=?, password=? WHERE id=?";
        
        if (!mysqli_stmt_prepare($stmt_pengguna, $query_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;profil.php?go=profil'>";
            return;
        }
        
        !$password
            ? mysqli_stmt_bind_param($stmt_pengguna, 'si', $username, $id_pengguna)
            : mysqli_stmt_bind_param($stmt_pengguna, 'ssi', $username, $password, $id_pengguna);
        
        if (!mysqli_stmt_execute($stmt_pengguna)) {
            $_SESSION['msg'] = 'Statement Pengguna preparation failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;profil.php?go=profil'>";
            return;
        }

        // Commit the transaction if all statements succeed
        if (!mysqli_commit($connection)) {
            $_SESSION['msg'] = 'Transaction commit failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;profil.php?go=profil'>";
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
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt_perusahaan);
    mysqli_stmt_close($stmt_pengguna);

    mysqli_autocommit($connection, true);

    mysqli_close($connection);
    echo "<meta http-equiv='refresh' content='0;profil.php?go=profil'>";
?>
