<?php
define("DB_SERVER", "localhost");
define("DB_USERNAME", "anders");
define("DB_PASSWORD", "lytill53");
define("DB_NAME", "tidlog");

# Connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

# Check connection
if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}