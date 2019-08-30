<?php
if (isset($_POST['rate-book'])) {
    require 'dbh.inc.php';

    session_start();
    $rating = $_POST['rating'];
    $user_id = $_SESSION['userId'];
    $book_id = $_GET['bookid'];

    if($rating < 1 || $rating > 5) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Please enter a valid rating (1-5).";
        header("Location: ../viewbook.php?id=$book_id&error=invalidrating");
        exit();
    }

    if (empty($rating)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Please enter a valid rating (1-5).";
        header("Location: ../viewbook.php?id=$book_id&error=emptyfields");
        exit();
    } else {
        $sql = "SELECT rating FROM book_ratings WHERE user_id=? AND book_id=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Database error, try again later.";
            header("Location: ../viewbook.php?id=$book_id&error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $user_id, $book_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck > 0) {

                $sql = "UPDATE book_ratings SET rating=? WHERE user_id=? AND book_id=?;";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    session_start();
                    $_SESSION['msg_type'] = "error";
                    $_SESSION['message'][] = "Database error, try again later.";
                    header("Location: ../viewbook.php?id=$book_id&error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "sss", $rating, $user_id, $book_id);
                    mysqli_stmt_execute($stmt);
                    
                    session_start();
                    $_SESSION['msg_type'] = "success";
                    $_SESSION['message'][] = "Book rating updated.";
                    header("Location: ../viewbook.php?id=$book_id&update=success");
                    exit();
                }
            } else {
              $sql = "INSERT INTO book_ratings (user_id, book_id, rating) VALUES (?, ?, ?);";
              $stmt = mysqli_stmt_init($conn);

              if (!mysqli_stmt_prepare($stmt, $sql)) {
                session_start();
                $_SESSION['msg_type'] = "error";
                $_SESSION['message'][] = "Database error, try again later.";
                header("Location: ../viewbook.php?id=$book_id&error=sqlerror");
                exit();
              } else {
                  mysqli_stmt_bind_param($stmt, "sss", $user_id, $book_id, $rating);
                  mysqli_stmt_execute($stmt);
                  session_start();
                  $_SESSION['msg_type'] = "success";
                  $_SESSION['message'][] = "Book rating added.";
                  header("Location: ../viewbook.php?id=$book_id&addrating=success");
                  exit();
              }
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
