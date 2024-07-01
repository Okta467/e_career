<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_alumni = $_GET['xid_alumni'];
    $id_pengguna = $_GET['xid_pengguna'];

    mysqli_autocommit($connection, false);

    $success = true;

    try {
        $stmt_alumni = mysqli_stmt_init($connection);
        $query_alumni = "DELETE FROM tbl_alumni WHERE id=?";

        if (!mysqli_stmt_prepare($stmt_alumni, $query_alumni)) {
            $_SESSION['msg'] = 'Transaction Pegawai failed: ' . mysqli_stmt_error($stmt_alumni);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_alumni, 'i', $id_alumni);

        if (!mysqli_stmt_execute($stmt_alumni)) {
            $_SESSION['msg'] = 'Transaction Pegawai failed: ' . mysqli_stmt_error($stmt_alumni);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

        $stmt_pengguna = mysqli_stmt_init($connection);
        $query_pengguna = "DELETE FROM tbl_pengguna WHERE id=?";

        if (!mysqli_stmt_prepare($stmt_pengguna, $query_pengguna)) {
            $_SESSION['msg'] = 'Transaction Pengguna failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }
        
        mysqli_stmt_bind_param($stmt_pengguna, 'i', $id_pengguna);

        if (!mysqli_stmt_execute($stmt_pengguna)) {
            $_SESSION['msg'] = 'Transaction Pengguna failed: ' . mysqli_stmt_error($stmt_pengguna);
            echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
            return;
        }

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

    !$success
        ? ''
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt_alumni);
    mysqli_stmt_close($stmt_pengguna);

    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;alumni.php?go=alumni'>";
?>