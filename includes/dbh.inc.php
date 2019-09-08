<?php
  // $dbServername = "localhost";
  // $dbUsername = "root";
  // $dbPassword = "";
  // $dbName = "webprog";

  $dbServername = getenv('DB_SERVER_NAME');
  $dbUsername = getenv('DB_USERNAME');
  $dbPassword = getenv('DB_PASSWORD');
  $dbName = getenv('DB_NAME');
  $dbPort = getenv('DB_PORT');

  $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName, $dbPort);

  if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
  }
