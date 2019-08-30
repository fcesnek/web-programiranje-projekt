<?php

if (isset($_GET['delete'])) {
    require 'dbh.inc.php';
    $id = $_GET['delete'];

    $sql = "SELECT id FROM book_lists WHERE user_id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../manageusers.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result_lists = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result_lists)) {
            $current_list_id = $row['id'];
            $sql = "DELETE FROM book_lists_books WHERE list_id=?;";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                session_start();
                $_SESSION['msg_type'] = "error";
                $_SESSION['message'][] = "Database error, try again later.";
                header("Location: ../manageusers.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $current_list_id);
                mysqli_stmt_execute($stmt);
            }
        }
        $sql = "DELETE FROM book_lists WHERE user_id=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Database error, try again later.";
            header("Location: ../manageusers.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
        }

        $sql = "DELETE FROM users WHERE id=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Database error, try again later.";
            header("Location: ../manageusers.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);

            session_start();
            $_SESSION['msg_type'] = "success";
            $_SESSION['message'][] = "User deleted successfully.";
            header("Location: ../manageusers.php?delete=success");
            exit();
        }

    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
