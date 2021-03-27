<?php

require_once "php/credentials.php";

$connection = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_error()) {
    die("Connection to database failed.<br>");
}

mysqli_set_charset($connection, "UTF8");
