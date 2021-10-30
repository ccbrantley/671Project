<?php
  $hostName = "localhost";
  $database = "671PROJECT";
  $userName = "user";
  $password = "password";
  $charset = 'utf8mb4';
  $dsn = "mysql:host=$hostName;dbname=$database;charset=$charset";
  $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];
?>
