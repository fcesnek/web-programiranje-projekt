<?php

if (isset($_GET['listid']) && isset($_GET['bookid'])) {
    require 'dbh.inc.php';
    $listid = $_GET['listid'];
    $bookid = $_GET['bookid'];

    $sql = "DELETE FROM book_lists_books WHERE book_id=? AND list_id=?";
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

        session_start();
        $_SESSION['msg_type'] = "success";
        $_SESSION['message'][] = "Book successfully removed from the list.";
        header("Location: ../viewbook.php?id=$bookid&removefromlist=success");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
