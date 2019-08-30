<?php

if (isset($_GET['listid']) && isset($_GET['bookid'])) {
    require 'dbh.inc.php';
    $listid = $_GET['listid'];
    $bookid = $_GET['bookid'];

    $sql = "SELECT * FROM book_lists_books WHERE book_id=? AND list_id=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../viewbook.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $bookid, $listid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "This book is already on the list.";
            header("Location: ../viewbook.php?id=$bookid&error=exists");
            exit();
        } else {
            $sql = "INSERT INTO book_lists_books (book_id, list_id) VALUES (?, ?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                session_start();
                $_SESSION['msg_type'] = "error";
                $_SESSION['message'][] = "Database error, try again later.";
                header("Location: ../viewbook.php?id=$bookid&error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $bookid, $listid);
                mysqli_stmt_execute($stmt);

                session_start();
                $_SESSION['msg_type'] = "success";
                $_SESSION['message'][] = "Book successfully added to the list.";
                header("Location: ../viewbook.php?id=$bookid&addtolist=success");
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
