<?php

if(isset($_POST['signup-submit'])) {
  require 'dbh.inc.php';

  $username = $_POST['username'];
  $password = $_POST['password'];
  $password_confirm = $_POST['cpassword'];

  if(empty($username) || empty($password) || empty($password_confirm)) {
    session_start();
    $_SESSION['msg_type'] = "error";
    $_SESSION['message'][] = "Please fill out all the fields.";
    header("Location: ../signup.php?error=emptyfields&username=".$username);
    exit();
  } else if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    session_start();
    $_SESSION['msg_type'] = "error";
    $_SESSION['message'][] = "Please enter a valid username.";
    header("Location: ../signup.php?error=invalidusername");
    exit();
  } else if($password !== $password_confirm) {
    session_start();
    $_SESSION['msg_type'] = "error";
    $_SESSION['message'][] = "Your passwords do not match.";
    header("Location: ../signup.php?error=invalidpassword&username=".$username);
    exit();
  } else {
      $sql = "SELECT username FROM users WHERE username=?";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../signup.php?error=sqlerror");
        exit();
      } else {
        
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if($resultCheck > 0) {
          session_start();
          $_SESSION['msg_type'] = "error";
          $_SESSION['message'][] = "This username already exists.";
          header("Location: ../signup.php?error=usernametaken");
          exit();
        } else {
          $sql = "INSERT INTO users (username, password, date_registered) VALUES (?, ?, CURRENT_TIME());";
          $stmt = mysqli_stmt_init($conn);

          if(!mysqli_stmt_prepare($stmt, $sql)) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Database error, try again later.";
            header("Location: ../signup.php?error=sqlerror");
            exit();
          } else {
            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPwd);
            mysqli_stmt_execute($stmt);

            $sql = "SELECT * FROM users WHERE username=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
              session_start();
              $_SESSION['msg_type'] = "error";
              $_SESSION['message'][] = "Database error, try again later.";
              header("Location: ../signup.php?error=sqlerror");
              exit();
            } else { 
              mysqli_stmt_bind_param($stmt, "s", $username);
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              $user = mysqli_fetch_assoc($result);
              $user_id = $user['id'];

              $list_names = ['Favorites', 'Currently reading', 'Plan to read', 'Read'];

              foreach ($list_names as $name) {
                $sql = "INSERT INTO book_lists (user_id, name) VALUES (?, ?);";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                  session_start();
                  $_SESSION['msg_type'] = "error";
                  $_SESSION['message'][] = "Database error, try again later.";
                  header("Location: ../signup.php?error=sqlerror");
                  exit();
                } else { 
                  mysqli_stmt_bind_param($stmt, "ss", $user_id, $name);
                  mysqli_stmt_execute($stmt);
                }
              }
            }
            session_start();
            $_SESSION['msg_type'] = "success";
            $_SESSION['message'][] = "Registered successfully. You can now log in.";
            header("Location: ../login.php?signup=success");
            exit();
          }
        }
      }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
} else {
  header("Location: ../signup.php");
  exit();
}