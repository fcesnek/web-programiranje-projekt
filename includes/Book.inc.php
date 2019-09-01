<?php

if (isset($_POST['add-book'])) {
    require 'dbh.inc.php';

    $title = $_POST['booktitle'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $genre = $_POST['genre'];
    $numPages = $_POST['numPages'];
    $year = $_POST['year'];
    $synopsis = $_POST['synopsis'];
    $cover = $_FILES['bookcover'];

    $fileName = $_FILES['bookcover']['name'];
    $fileTmpName = $_FILES['bookcover']['tmp_name'];
    $fileSize = $_FILES['bookcover']['size'];
    $fileError = $_FILES['bookcover']['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (empty($title) || empty($genre) || empty($numPages) || empty($year) || empty($author) || empty($isbn) || empty($synopsis) || empty($fileName)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Please fill out all the fields.";
        header("Location: ../createbook.php?error=emptyfields");
        exit();
    } else {
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) {
                    $newFileName = $isbn . "." . $fileActualExt;
                    $imagePath = 'uploads/' . $newFileName;
                    $fileDestination = '../uploads/' . $newFileName;
                } else {
                    session_start();
                    $_SESSION['msg_type'] = "error";
                    $_SESSION['message'][] = "File size exceeds max. file size.";
                    header("Location: ../createbook.php?error=fileupload");
                    exit();
                }
            } else {
                session_start();
                $_SESSION['msg_type'] = "error";
                $_SESSION['message'][] = "There was an error uploading your file.";
                header("Location: ../createbook.php?error=fileupload");
                exit();
            }
        } else {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "You cannot upload files of this type.";
            header("Location: ../createbook.php?error=fileupload");
            exit();
        }

        $sql = "INSERT INTO books (title, author, image, synopsis, isbn, genre, year, numPages) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Database error, try again later.";
            header("Location: ../managebooks.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssis", $title, $author, $imagePath, $synopsis, $isbn, $genre, $year, $numPages);
            mysqli_stmt_execute($stmt);

            move_uploaded_file($fileTmpName, $fileDestination);
            session_start();
            $_SESSION['msg_type'] = "success";
            $_SESSION['message'][] = "Book added successfully.";
            header("Location: ../managebooks.php?upload=success");
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else if (isset($_POST['update-book'])) {
    require 'dbh.inc.php';
    $id = $_GET['bookid'];
    $title = $_POST['booktitle'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $synopsis = $_POST['synopsis'];
    $cover = $_FILES['bookcover'];
    $genre = $_POST['genre'];
    $numPages = $_POST['numPages'];
    $year = $_POST['year'];

    $fileName = $_FILES['bookcover']['name'];
    $fileTmpName = $_FILES['bookcover']['tmp_name'];
    $fileSize = $_FILES['bookcover']['size'];
    $fileError = $_FILES['bookcover']['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (empty($title) || empty($genre) || empty($numPages) || empty($year) || empty($author) || empty($isbn) || empty($synopsis) || empty($fileName)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Please fill out all the fields.";
        header("Location: ../updatebook.php?edit=$id&error=emptyfields");
        exit();
    } else {
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 5000000) {
                    $newFileName = $isbn . "." . $fileActualExt;
                    $imagePath = 'uploads/' . $newFileName;
                    $fileDestination = '../uploads/' . $newFileName;
                } else {
                    session_start();
                    $_SESSION['msg_type'] = "error";
                    $_SESSION['message'][] = "File size exceeds max. file size.";
                    header("Location: ../updatebook.php?edit=$id&error=fileupload");
                    exit();
                }
            } else {
                session_start();
                $_SESSION['msg_type'] = "error";
                $_SESSION['message'][] = "There was an error uploading your file.";
                header("Location: ../updatebook.php?edit=$id&error=fileupload");
                exit();
            }
        } else {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "You cannot upload files of this type.";
            header("Location: ../updatebook.php?edit=$id&error=fileupload");
            exit();
        }

        $sql = "UPDATE books SET title=?, author=?, image=?, synopsis=?, isbn=?, genre=?, year=?, numPages=? WHERE id=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Database error, try again later.";
            header("Location: ../updatebook.php?edit=$id&?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ssssssiss", $title, $author, $imagePath, $synopsis, $isbn, $genre, $year, $numPages, $id);
            mysqli_stmt_execute($stmt);

            move_uploaded_file($fileTmpName, $fileDestination);
            session_start();
            $_SESSION['msg_type'] = "success";
            $_SESSION['message'][] = "Book updated successfully.";
            header("Location: ../managebooks.php?update=success");
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else if (isset($_GET['delete'])) {
    require 'dbh.inc.php';
    $id = $_GET['delete'];

    // Delete book from any lists
    $sql = "DELETE FROM book_lists_books WHERE book_id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../managebooks.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
    }

    // Delete ratings for the book
    $sql = "DELETE FROM book_ratings WHERE book_id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../managebooks.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
    }

    $sql = "SELECT image FROM books WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../managebooks.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $bookImgPath = mysqli_fetch_assoc($result);
    }

    $path = "../".$bookImgPath['image'];
    $bookImgRealPath = realpath($path);
    print_r($bookImgRealPath);
    if(is_writable($bookImgRealPath)) {
        unlink($bookImgRealPath);
    }

    // Delete the book
    $sql = "DELETE FROM books WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../managebooks.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        session_start();
        $_SESSION['msg_type'] = "success";
        $_SESSION['message'][] = "Book deleted successfully.";
        header("Location: ../managebooks.php?update=success");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
