<?php
  if(isset($_POST['login-submit'])) {

    require 'dbh.inc.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
      session_start();
      $_SESSION['msg_type'] = "error";
      $_SESSION['message'][] = "Please fill out all the fields.";
      header("Location: ../login.php?error=emptyfields");
      exit();
    } else {
      $sql = "SELECT * FROM users WHERE username=?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql)) {
        session_start();
        $_SESSION['msg_type'] = "error";
        $_SESSION['message'][] = "Database error, try again later.";
        header("Location: ../login.php?error=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result)) {
          $pwdCheck = password_verify($password, $row['password']);
          if($pwdCheck == false) {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Please enter valid credentials.";
            header("Location: ../login.php?error=login");
            exit();
          } else if($pwdCheck == true) {
            session_start();
            $_SESSION['userId'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['adminstatus'] = $row['admin'];

            header("Location: ../index.php?login=success");
            exit();

          } else {
            session_start();
            $_SESSION['msg_type'] = "error";
            $_SESSION['message'][] = "Please enter valid credentials.";
            header("Location: ../login.php?error=login");
            exit();
          }
        } else {
          session_start();
          $_SESSION['msg_type'] = "error";
          $_SESSION['message'][] = "Please enter valid credentials.";
          header("Location: ../login.php?error=login");
          exit();
        }
      }
    }

  } else {
    header("Location: ../login.php");
    exit();
  }