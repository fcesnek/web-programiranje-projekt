<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://kit.fontawesome.com/77b5f67e57.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="./style.css">
  <title></title>
</head>

<body>
  <header>
    <nav class="navbar">
      <span class="navbar-toggle" id="js-navbar-toggle">
        <i class="fas fa-bars"></i>
      </span>
      <a href="index.php" class="home-button"><i class="icon fas fa-book-open"></i>Home</a>
      <ul class="main-nav" id="js-menu">
        <?php
          if(isset($_SESSION['userId']) && isset($_SESSION['adminstatus']) && $_SESSION['adminstatus'] == 1) {
            echo '<li>
                    <span class="nav-username">Logged in as: '. $_SESSION['username'].'</span>
                  </li>
                  <li>
                    <a href="managebooks.php" class="nav-link"><i class="icon fas fa-book"></i>Manage Books</a>
                  </li>
                  <li>
                    <a href="manageusers.php" class="nav-link"><i class="icon fas fa-users"></i>Manage Users</a>
                  </li>
                  <li>
                    <a href="managelists.php" class="nav-link"><i class="icon fas fa-list-alt"></i>My lists</a>
                  </li>
                  <li>
                    <form action="includes/Logout.inc.php" method="post">
                      <input class="logout-button" type="submit" name="logout-submit" value="Logout">
                    </form>
                  </li>';
          }
          if(!isset($_SESSION['userId'])) {
            echo '<li>
                    <a href="signup.php" class="nav-link">Sign Up</a>
                  </li>
                  <li>
                    <a href="login.php" class="nav-link">Login</a>
                  </li>';
          } else if(isset($_SESSION['userId']) && isset($_SESSION['adminstatus']) && $_SESSION['adminstatus'] == 0) {
            echo '<li>
                    <span class="nav-username">Logged in as: '. $_SESSION['username'].'</span>
                  </li>
                  <li>
                    <a href="managelists.php" class="nav-link"><i class="icon fas fa-list-alt"></i>My lists</a>
                  </li>
                  <li>
                    <form action="includes/Logout.inc.php" method="post">
                      <input class="logout-button" type="submit" name="logout-submit" value="Logout">
                    </form>
                  </li>';
          }
        ?>
      </ul>
    </nav>
  </header>
  <script>
  let mainNav = document.getElementById('js-menu');
  let navBarToggle = document.getElementById('js-navbar-toggle');

  navBarToggle.addEventListener('click', function() {
    mainNav.classList.toggle('active');
  });
  </script>