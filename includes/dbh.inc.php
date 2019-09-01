<?php

  $dbServername = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "webprog";

  $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword);

  if(!$conn) {
    die("Connection failed: ".mysqli_connect_error());
  }